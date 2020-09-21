<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use DateTime;

use App\Concesionaria;
use App\Equipo;

class ExcelReport_HorasTrabajadas implements FromView
{
    use Exportable;


    private $data = [], $row = -1, $col = -1, $max_row = -1, $max_col = -1;
    private $span_value = 'span_cell', $free_value = 'free_cell';
    private $start_date, $end_date;

    public function __construct($data)
    {
        $this->start_date = new DateTime($data['start_date']);
        $this->end_date = new DateTime($data['end_date']);
    }

    private function nextRow($letEmpty = 1)
    {
        $this->row += $letEmpty;
        $this->col = -1;

        // defino la fila mas grande
        if ( $this->max_row < $this->row ) $this->max_row = $this->row;
    }
    private function nextCol($letEmpty = 0)
    {
        $this->col += $letEmpty;

        do {    // En caso que no este vacia, busca la siguiente
            $this->col++;
        } while ( isset($this->data[$this->row][$this->col]) && $this->data[$this->row][$this->col] != $this->free_value );
        // dd('sale de aqui');

        // defino la columna mas grande
        if ( $this->max_col < $this->col ) $this->max_col = $this->col;
    }
    private function add($value = '', $span = [])
    {
        // Siguiente columna
        $this->nextCol();
        
        // Agregar value
        $this->data[$this->row][$this->col] = [];
        $this->data[$this->row][$this->col]['value'] = $value;

        // Verificacion del span
        if ( !array_key_exists('rowspan', $span) && !array_key_exists('colspan', $span) ) return; // en caso de no haber datos en span entonces acaba aqui

        // defino las variables a usar
        if ( array_key_exists('rowspan', $span) ) $rowspan = $span['rowspan']; else $rowspan = 1;
        if ( array_key_exists('colspan', $span) ) $colspan = $span['colspan']; else $colspan = 1;
        if ( array_key_exists('use', $span) ) $use = $span['use']; else $use = true;

        // Caso: usar el span significa: en el blade se definiran los span, en el array los espacios seran llenados con 'span'
        if ( $use ) { // en caso que exista el use en span y sea true entonces se agrega el span
            if ( $rowspan > 1 ) $this->data[$this->row][$this->col]['rowspan'] = $rowspan;
            if ( $colspan > 1 ) $this->data[$this->row][$this->col]['colspan'] = $colspan;
            
            for ($r = $this->row; $r < $this->row + $rowspan; $r++) { 
                for ($c = $this->col; $c < $this->col + $colspan; $c++) { 
                    if ( $r != $this->row || $c != $this->col ) $this->set($r, $c, $this->span_value);
                }
            }
            // dd($this->data);
        }
        
        // Caso: no usar el span significa: en el blade NO se definiran los span y en el array los espacios seran llenados con celdas vacias ['value' => '']
        else {
            for ($r = $this->row; $r < $this->row + $rowspan; $r++) { 
                for ($c = $this->col; $c < $this->col + $colspan; $c++) { 
                    if ( $r != $this->row || $c != $this->col ) $this->set($r, $c, $this->free_value);
                }
            }
            // dd($this->data);
        }
    }
    private function set($row, $col, $value)
    {
        // defino el valor en el lugar
        if ( $value == $this->span_value ) {
            $this->data[$row][$col] = $this->span_value;
        } else if ( $value == $this->free_value ) {
            if ( !isset($this->data[$row][$col]) ) $this->data[$row][$col] = $this->free_value;
        } else {
            $this->data[$row][$col]['value'] = $value;
        }

        // hago existir los espacios libres
        if ( $value != $this->free_value ) {
            for ($r = 0; $r <= $row; $r++) { 
                for ($c = 0; $c <= $col; $c++) { 
                    $this->set($r, $c, $this->free_value);
                }
            }
        }

        // defino la fila y columna mas grande
        if ( $this->max_row < $this->row ) $this->max_row = $this->row;
        if ( $this->max_col < $this->col ) $this->max_col = $this->col;
    }

    private function loadData()
    {
        // Row 1
        $this->nextRow();
        $this->add('Suma de HORAS', ['rowspan' => 2, 'colspan' => 4, 'use' => true]);
        $this->add('Etiquetas de columna');
        
        // Row 2
        $this->nextRow();
        $months = $this->getMonths();
        foreach ($months as $month) {
            $this->add($month['name'], ['colspan' => count($month['days'])]);
            $this->add('Total '.$month['name']);
        }
        $this->add('Total general');

        // Row 3
        $this->nextRow();
        $this->add('Etiquetas de fila');
        $this->add('CODIGO');
        $this->add('DESC. EQUIPO');
        $this->add('Tipo Hora');

        foreach ($months as $month) {
            foreach ($month['days'] as $day) $this->add($day . '/' . $month['name']);
            $this->add();
        }
        
        // dd($this->data);
        // dd([$this->data, $this->max_row, $this->max_col]);
        // dd($this->data);
        // $this->data = Equipo::join('ua', 'ua.id', '=', 'equipo.ua_id')
        //                     ->join('controldiario', 'equipo.id', '=', 'controldiario.equipo_id')
        //                     ->select('ua.codigo', 'equipo.descripcion')
        //                     ->;
        
        // return $rows;
    }

    private function getMonths()
    {
        setlocale(LC_TIME, 'es_ES');

        $months = [];
        $month = new DateTime($this->start_date->format('Y-m-d'));

        while ( $month <= $this->end_date ) {
            $new_month['name'] = substr(strtolower(strftime('%b', $month->getTimestamp())), 0, 3);
            
            $days = [];
            $day = new DateTime($month->format('Y-m-d'));
            while ( $day->format('m') == $month->format('m') && $day <= $this->end_date ) {
                $days[] = $day->format('d');
                $day->modify('+1 day');
            }
            
            $new_month['days'] = $days;
            $month = new DateTime($day->format('Y-m-d'));
            // $date = new DateTime(date('Y-m-d', strtotime($date->format('Y-m-d') . ' + 1 months')));

            $months[] = $new_month;
        }

        return $months;
    }
    
    private function getEquipos()
    {
        return Equipo::join('ua', 'equipo.ua_id', '=', 'ua.id')
                    ->join('controldiario', 'equipo.id', '=', 'controldiario.equipo_id')
                    ->select('equipo.id AS id', 'DISTINCT equipo.descripcion AS descripcion', 'ua.codigo AS codigo')
                    ->where('controldiario.fecha', '>=', $this->start_time->format())
                    ->orWhere('controldiario.fecha', '<=', $this->end_time->format())->get();
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view():View
    {
        $this->loadData();

        return view('app.controldiario.exports.excelReports.HorasTrabajadas', [
            'data' => $this->data,
            'max_row' => $this->max_row,
            'max_col' => $this->max_col,
            'span_value' => $this->span_value,
            'free_value' => $this->free_value
        ]);
    }
}

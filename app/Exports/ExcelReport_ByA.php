<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

use App\Concesionaria;
use App\Equipo;
use App\Tipohora;
use App\Controldiario;
use DateTime;
use Exception;
use DB;

class ExcelReport_ByA extends ExcelHelper implements FromView 
{
    use Exportable;


    private $start_date, $end_date, $equipo_ids;

    public function __construct(DateTime $start_date, DateTime $end_date, array $equipo_ids)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->equipo_ids = $equipo_ids;
    }


    private function loadData()
    {
        $concesionaria = Concesionaria::getConcesionariaActual();

        // Parte 1
        $this->nextCell()->add('MEDICIÓN DE ALQUILER DE EQUIPOS', ['colspan' => 12]);
        
        // Parte 2
        $this->nextCell(2)->add([['CONCESIONARIA:', $concesionaria->razonsocial]]);
        $this->nextCell()->add([['SUBCONTRATISTA:', '']]);
        $this->nextCell()->add([['PERIODO:', '(' . $this->start_date->format('d/m/Y') . ' AL ' . $this->end_date->format('d/m/Y') . ')']]);

        // Parte 3
        $this->nextCell(2);
        $this->add('CODIGO', ['rowspan' => 3]);
        $this->add('EQUIPO', ['rowspan' => 3]);
        $this->add('Dias de permanencia', ['rowspan' => 3]);
        $this->add('HORAS TRABAJADAS', ['rowspan' => 3]);
        $this->add('HORAS MANTENIMIENTO', ['rowspan' => 3]);
        $this->add('Horas minimas establecidas', ['rowspan' => 3]);
        $this->add('Horas minimas por derecho', ['rowspan' => 3]);
        $this->add('Horas minimas a pagar', ['rowspan' => 3]);
        $this->add('TOTAL HORAS A PAGAR', ['rowspan' => 3]);
        $this->nextCol()->add('RESPONSABLE POR EQUIPO', ['rowspan' => 3]);

        $summaryEquipos = $this->getSummaryEquipos();
        $this->nextCell(4)->add($summaryEquipos);
        
        $letRows = count($summaryEquipos);

        // Parte 4
        $header = $this->getEquiposHeader();
        $body = $this->formatTable($this->getEquipos());
        $table = $this->addTableHeaders($header, $body);
        $this->nextCell($letRows)->add($table);
        $letRows = count($table);
        
        // Parte 5
        $this->nextRow($letRows + 10);
        $this->nextCol()->add('_________________________________', ['colspan' => 4]);
        $this->nextCol()->add('_________________________________', ['colspan' => 4]);
        $this->nextCol()->add('_________________________________', ['colspan' => 4]);
        $this->nextRow();
        $this->nextCol()->add('ING. JOSE SALINAS', ['colspan' => 4]);
        $this->nextCol()->add('GUILLERMO CIPAGAUTA', ['colspan' => 4]);
        $this->nextCol()->add('REPRESENTANTE SUBCONTRATISTA', ['rowspan' => 2, 'colspan' => 4]);
        $this->nextRow();
        $this->nextCol()->add('GERENTE DE OPERACIONES Y MANTENIMIENTO', ['colspan' => 4]);
        $this->nextCol()->add('INGENIERÍA (Equipos)', ['colspan' => 4]);
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

    private function getSummaryEquipos(): array
    {
        // Traigo las fechas formateadas para uso rapido
        $startDate = $this->start_date->format('Y-m-d');
        $endDate = $this->end_date->format('Y-m-d');
        
        // Consigo todos los ids de tipos de hora mantenimiento
        $thMantenimiento_ids = Tipohora::select('id')->where('descripcion', 'like', '%mantenimiento%')->get();
        
        // variable de respuesta
        $table = [];

        foreach ($this->equipo_ids as $equipo_id) {
            $equipo = Equipo::join('ua', 'ua.id', '=', 'equipo.ua_id')
                            ->join('controldiario', 'controldiario.equipo_id', '=', 'equipo.id')
                            ->select('ua.codigo', 'equipo.descripcion', DB::raw('COUNT(controldiario.id) AS dias_permanencia'))
                            ->where('equipo.id', '=', $equipo_id)
                            ->where('controldiario.fecha', '>=', $startDate)
                            ->where('controldiario.fecha', '<=', $endDate)
                            ->groupBy('ua.codigo', 'equipo.descripcion')->first();

            $codigo = $equipo['codigo'];
            $descripcion = $equipo['descripcion'];
            $dias_permanencia = $equipo['dias_permanencia'];

            // Horas trabajadas
            $a = Controldiario::select(DB::raw('SUM(hora_total) AS a'))
                            ->where('equipo_id', '=', $equipo_id)
                            ->where('tipohora_id', '=', NULL)
                            ->where('fecha', '>=', $startDate)
                            ->where('fecha', '<=', $endDate)->first()['a'];
            $a = is_null($a) ? 0 : floatval($a);

            // Horas de mantenimiento
            $b = Controldiario::select(DB::raw('SUM(hora_total) AS b'))
                            ->where('equipo_id', '=', $equipo_id)
                            ->where(function ($query) use ($thMantenimiento_ids) {
                                foreach ($thMantenimiento_ids as $th) $query->orWhere('tipohora_id', '=', $th['id']);
                            })
                            ->where('fecha', '>=', $startDate)
                            ->where('fecha', '<=', $endDate)->first()['b'];
            $b = is_null($b) ? 0 : floatval($b);
            
            // Horas minimas establecidas
            $c = round((120/31) * intval($dias_permanencia), 2);

            // Horas minimas por derecho
            $d = $c > $b ? $c - $b : 0;

            // Horas minimas a pagar
            $e = $d > $a ? $d - $a : 0;

            // Horas total a pagar
            $f = $a + $e;
            
            // Responsable de equipo
            $responsable = 'Sin definir';

            // Agrego las filas de la tabla de resumen de equipos
            $array = $this->formatTable([
                [$codigo, $descripcion, $dias_permanencia, $a, $b, $c, $d, $e, $f, '', $responsable]
            ], [ // le defino offset rows en 2 para que tenga una fila libre despues y trasposed en verdadero para que el array no salga vertical sino horizontal
                'oRows' => 2
            ]);

            // fusionamos el valor de $table con el de $array
            $table = array_merge($table, $array);
        }
        
        return $table;
    }
    
    private function getEquiposHeader(): array
    {
        $months = $this->getMonths();

        $array = ['CODIGO', 'DESC. EQUIPO', 'Tipo Hora'];

        foreach ($months as $month) {
            foreach ($month['days'] as $day) $array = array_merge($array, [$day . '-' . $month['name']]);
        }

        $array = array_merge($array, ['Total general']);

        return [$array];
    }

    private function getEquipos(): array
    {
        $start_date = $this->start_date->format('Y-m-d');
        $end_date = $this->end_date->format('Y-m-d');
        
        $table = [];

        foreach ($this->equipo_ids as $equipo_id) { 
            $equipo = Equipo::join('ua', 'equipo.ua_id', '=', 'ua.id')
                            ->join('controldiario', 'equipo.id', '=', 'controldiario.equipo_id')
                            ->select('ua.codigo AS codigo', 'equipo.descripcion AS descripcion')->distinct()
                            ->where('equipo.id', '=', $equipo_id)
                            ->where('controldiario.fecha', '>=', $start_date)
                            ->where('controldiario.fecha', '<=', $end_date)->first();

            $codigo = $equipo['codigo'];
            $descripcion = $equipo['descripcion'];

            $array = $this->formatTable([[$codigo, $descripcion]], ['subData' => $this->getTipoHora($equipo_id)]);

            if ( !empty($table) ) $table = array_merge($table, $array);
            else $table = $array;

        } unset($equipo_id);

        return $table;
    }

    private function getTipoHora($equipo_id): array
    {
        // Traigo las fechas formateadas para uso rapido
        $start_date = $this->start_date->format('Y-m-d');
        $end_date = $this->end_date->format('Y-m-d');

        // Hago la consulta a la db de y consigo la tabla bruta
        $dbTipoHora = TipoHora::rightJoin('controldiario', 'tipohora.id', '=', 'controldiario.tipohora_id')
                            ->select('tipohora.id AS id', 'tipohora.descripcion AS descripcion')->distinct()
                            ->where('controldiario.equipo_id', '=', $equipo_id)
                            ->where('controldiario.fecha', '>=', $this->start_date->format('Y-m-d'))
                            ->where('controldiario.fecha', '<=', $this->end_date->format('Y-m-d'))->get();
        
        $tiposHora = [];
        foreach ($dbTipoHora as $th) $tiposHora[] = ['descripcion' => $th['descripcion'], 'id' => $th['id']];

        // Preparo los grupos para la reparacion de la consulta
        $groups = [];

        // Grupo de "HORAS PARADAS"
        $group = [];
        $query = TipoHora::select('id')->where('descripcion', 'like', '%parado%')->get();
        for ($i = 0; $i < count($query); $i++) { 
            $group = array_merge($group, [$query[$i]['id']]);
        }
        $groups[] = ['descripcion' => 'HORAS PARADAS', 'ids' => $group, 'found' => false];

        // Grupo de "HORAS MANTENIMIENTO"
        $group = [];
        $query = TipoHora::select('id')->where('descripcion', 'like', '%mantenimiento%')->get();
        for ($i = 0; $i < count($query); $i++) { 
            $group = array_merge($group, [$query[$i]['id']]);
        }
        $groups[] = ['descripcion' => 'HORAS MANTENIMIENTO', 'ids' => $group, 'found' => false];
        
        // Grupo de "HORAS TRABAJADAS"
        $groups[] = ['descripcion' => 'HORAS TRABAJADAS', 'ids' => [NULL], 'found' => false];
        
        // Elimino todos los registros que tengan algun id de alguno de los grupos
        for ($i = 0; $i < count($groups); $i++) { // Paso por todos los grupos existentes
            // Elimino todos los registros que tengan algun id de este grupo
            foreach ($groups[$i]['ids'] as $id) { // Paso por cada id del grupo existente
                // Elimino el registro que tenga el id de este grupo
                for ($j = 0; $j < count($tiposHora); $j++) {  // Paso por cada registro del query principal
                    if ( $tiposHora[$j]['id'] == $id ) {
                        $groups[$i]['found'] = true;
                        unset($tiposHora[$j]);
                    }
                }
                // Para reacomodar los indices
                $tiposHora = array_merge($tiposHora);
            }
        }
        // Reparo el formato de los ids del query principal
        for ($i = 0; $i < count($tiposHora); $i++) {  // Paso por cada registro del query principal
            $tiposHora[$i]['ids'] = [$tiposHora[$i]['id']];
            unset($tiposHora[$i]['id']);
        }
        // Agregar los nuevos grupos al query principal
        foreach ($groups as $group) {
            if ( $group['found'] ) {
                $tiposHora[] = [
                    'descripcion' => $group['descripcion'],
                    'ids' => $group['ids']
                ];
            }
        }

        $array = [];
        
        foreach ($tiposHora as $tipoHora) { 
            $ids = $tipoHora['ids'];
            $descripcion = mb_strtoupper($tipoHora['descripcion'], 'utf-8');

            $array[] = [
                'value' => $descripcion,
                'subData' => $this->getControlDiario($equipo_id, $ids)
            ];
        } unset($i);

        return $array;
    }

    private function getControlDiario($equipo_id, $ids): array
    {
        $start_date = $this->start_date->format('Y-m-d');
        $end_date = $this->end_date->format('Y-m-d');

        $dbControl = Controldiario::select('fecha', DB::raw('SUM(hora_total) AS hora_total'))
                                ->where('equipo_id', '=', $equipo_id)
                                ->where(function ($query) use ($ids) {
                                    foreach ($ids as $id) $query->orWhere('tipohora_id', '=', $id);
                                })
                                ->where(function ($query) use ($start_date, $end_date) {
                                    $query->where('controldiario.fecha', '>=', $start_date)
                                        ->where('controldiario.fecha', '<=', $end_date);
                                })
                                ->groupBy('fecha')
                                ->orderBy('fecha', 'ASC')->get();
        
        $value = [];
        $total_general = 0;
        $date = new DateTime($start_date);
        
        while ( $date <= $this->end_date ) {
            $control = null;

            for ($i = 0; $i < count($dbControl); $i++) { 
                if ( $dbControl[$i]['fecha'] == $date->format('Y-m-d') ) {
                    $control = floatval($dbControl[$i]['hora_total']); break;
                }
            }

            $value[] = is_null($control) ? '' : number_format($control, 2);

            $total_general += is_null($control) ? 0 : $control;

            $date->modify('+1 day');
        }
        
        $value[] = number_format($total_general, 2);

        return [
            [
                'value' => $value,
                'trasposed' => true
            ]
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view():View
    {
        $this->loadData();

        return view('app.controldiario.exports.excelReports.MedicionEquipos', [
            'data' => $this->data,
            'max_row' => $this->max_row,
            'max_col' => $this->max_col,
            'span_value' => $this->span_value,
            'free_value' => $this->free_value
        ]);
    }
}
<?php

namespace App\Exports;

use DateTime;
use DB;
use App\Tipohora;
use App\Equipo;
use App\Controldiario;

class PdfReport_JyMP
{
    private $start_date, $end_date, $equipo_ids, $subtotal;

    public function __construct(DateTime $start_date, DateTime $end_date, array $equipo_ids) 
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->equipo_ids = $equipo_ids;
    }

    private function getSummaryEquipos(): array
    {
        // Traigo las fechas formateadas para uso rapido
        $startDate = $this->start_date->format('Y-m-d');
        $endDate = $this->end_date->format('Y-m-d');
        
        // Consigo todos los ids de tipos de hora mantenimiento
        $thMantenimiento_ids = Tipohora::select('id')->where('descripcion', 'like', '%mantenimiento%')->get();
        
        // variable de respuesta
        $table = []; $subtotal = 0;

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

            // Valor unitario
            $valorUnitario = 55;
            
            // Subtotal por equipo
            $subtotalEquipo = round($f * $valorUnitario, 2);

            // Responsable de equipo
            $responsable = 'Sin definir';

            // Calculo el subtotal general
            $subtotal += $subtotalEquipo;

            $table[] = [
                'codigo' => $codigo,
                'descripcion' => $descripcion,
                'cantidad' => number_format($f, 2),
                'valorUnitario' => number_format($valorUnitario, 2),
                'subtotal' => number_format($subtotalEquipo, 2),
                'responsable' => $responsable
            ];
        }
        
        $this->subtotal = number_format($subtotal, 2);

        return $table;
    }

    public function getData(): array
    {
        $data = [];


        $data['periodo'] = strtoupper("(" . $this->start_date->format('d-m-Y') . " AL " . $this->end_date->format('d-m-Y') . ")");
        $data['listSummaryEquipos'] = $this->getSummaryEquipos();

        $data['subtotal'] = $this->subtotal;

        return $data;
    }
}

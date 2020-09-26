<?php

namespace App\Exports;

use App\Ua;
use Maatwebsite\Excel\Concerns\FromCollection;

class ReportHrsEquiposUas implements FromCollection
{
    
	private $fecha1;
	private $fecha2;
	private $concesionaria;

	public function __construct($fecha1,$fecha2,$concesionaria)
    {
        $this->fecha1 = $fecha1;
        $this->fecha2 = $fecha2;
        $this->concesionaria = $concesionaria;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $fechaInicio = $this->fecha1;
        $fechaFin = $this->fecha2;
        $Info = Ua::where('concesionaria',$this->concesionaria)
        		->whereHas('controlesdiarios', function($q) use($fechaInicio, $fechaFin){
        			$q->whereBetween('fecha',[$fechaInicio,$fechaFin]);
        		})->select('id as "UA ID"','codigo as "UA CODIGO"','descripcion as "UA DESCRIPCION"')
        		->with(['equpos' => function($q) use($fechaInicio, $fechaFin){
        			$q->select('id as "EQUI ID"',' descripcion as "EQUI DESC"' , 'equipo_id')
        			->with(['controlesdiarios' => function($q) use($fechaInicio, $fechaFin){
        				$q->('id','fecha','hora_total','ua_Id')->where('ua_id','=','"UA ID"')
        				->whereBetween('fecha',[$fechaInicio,$fechaFin]);
        			}]);
        		}])->get();

        	
        return $info;

    }

    public function headings(): array{
        $base  = [
            'UA',
            'Descripción',
            'Código',
            'Descripción Equipo'
        ];

        $fechaInicio = $this->fecha1;
        $fechaFin = $this->fecha2;

        $fechas = [];

        while($fechaInicio != $fechaFin){
        	
        	$fechas[] = $fechaInicio;

        	$fechaInicio = date("Y-m-d",strtotime($fechaInicio."+ 1 day"));
        }
        $fechas[] = $fechaInicio;

        $head = array_merge($base,$fechas);

        return  $head;
    }
}

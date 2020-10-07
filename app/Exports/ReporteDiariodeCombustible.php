<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\AbastecimientoCombustible;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReporteDiariodeCombustible  implements FromCollection, WithHeadings
{	

	private $fecha;
	private $idgrifo;

	public function __construct($fecha,$grifo){
		$this->fecha = $fecha;
		$this->idgrifo = $grifo;
	}


    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
    	$fechaAbast = $this->fecha;
		$idGrifo = $this->idgrifo;
		
		$queryVehiculo = AbastecimientoCombustible::select(
			'abastecimiento_combustible.id as id',
			DB::raw('(CASE WHEN c.user_id IS NULL THEN us.name ELSE CONCAT(c.apellidos, " ", c.nombres) END) AS res'), 
            'c.dni as dni',
            'ua.codigo as code',
            DB::raw('(CASE WHEN vh.modelo IS NULL THEN "-" ELSE vh.modelo END) AS desceq'), 
            'mc.descripcion as descmc', 
			DB::raw('(CASE WHEN vh.placa IS NULL THEN "-" ELSE vh.placa END) AS eqpl'),
			'km', 'qtdgl', 'abastecimiento_combustible.hora_inicio', 'abastecimiento_combustible.hora_fin',
            DB::raw('(CASE WHEN ct.razonsocial IS NULL THEN "-" ELSE ct.razonsocial END) AS crza') )
            -> leftJoin('grifo as g', 'g.id', '=', 'grifo_id')
            -> leftJoin('users as us', 'us.id', '=', 'abastecimiento_combustible.user_id')
            -> leftJoin('conductor as c', 'c.user_id', '=', 'abastecimiento_combustible.user_id')
            -> leftjoin('ua', 'ua.id', '=', 'ua_id')
            -> leftJoin('vehiculo as vh', 'vh.id', '=', 'vehiculo_id')
            -> leftJoin('marca as mc', 'mc.id', '=', 'vh.marca_id')
            -> leftJoin('contratista as ct', 'ct.id', '=', 'vh.contratista_id')
            -> leftJoin('tipocombustible as tcom', 'tcom.id', '=', 'abastecimiento_combustible.tipocombustible_id')
            -> leftJoin('abastecimiento as abast', 'abast.id', '=', 'abastecimiento_combustible.abastecimiento_id')
			-> whereNull('abastecimiento_combustible.deleted_at')
			-> where([
				[ 'abastecimiento_combustible.fecha_abastecimiento', '=', $fechaAbast ],
				[ 'abastecimiento_combustible.grifo_id', '=', $idGrifo ]
			]);

        $resultQuery = AbastecimientoCombustible::select(
			'abastecimiento_combustible.id as id',
			DB::raw('(CASE WHEN c.user_id IS NULL THEN us.name ELSE CONCAT(c.apellidos, " ", c.nombres) END) AS res'),
            'c.dni as dni',
            'ua.codigo as code',
            DB::raw('(CASE WHEN eq.descripcion IS NULL THEN "-" ELSE eq.descripcion END) AS desceq'),
            'mc.descripcion as descmc', 
			DB::raw('(CASE WHEN eq.placa IS NULL THEN "-" ELSE eq.placa END) AS eqpl'), 
			'km', 'qtdgl', 'abastecimiento_combustible.hora_inicio', 'abastecimiento_combustible.hora_fin',
            DB::raw('(CASE WHEN ct.razonsocial IS NULL THEN "-" ELSE ct.razonsocial END) AS crza') )
            -> leftJoin('grifo as g', 'g.id', '=', 'grifo_id')
            -> leftJoin('users as us', 'us.id', '=', 'abastecimiento_combustible.user_id')
            -> leftJoin('conductor as c', 'c.user_id', '=', 'abastecimiento_combustible.user_id')
            -> leftjoin('ua', 'ua.id', '=', 'ua_id')
            -> leftJoin('equipo as eq', 'eq.id', '=', 'equipo_id')
            -> leftJoin('marca as mc', 'mc.id', '=', 'eq.marca_id')
            -> leftJoin('contratista as ct', 'ct.id', '=', 'eq.contratista_id')
            -> leftJoin('tipocombustible as tcom', 'tcom.id', '=', 'abastecimiento_combustible.tipocombustible_id')
            -> leftJoin('abastecimiento as abast', 'abast.id', '=', 'abastecimiento_combustible.abastecimiento_id')
            -> whereNull('abastecimiento_combustible.deleted_at')
			-> unionAll($queryVehiculo)
			-> where([
				[ 'abastecimiento_combustible.fecha_abastecimiento', '=', $fechaAbast ],
				[ 'abastecimiento_combustible.grifo_id', '=', $idGrifo ]
			])
            -> get();
		
        $newResult = [];
        $arrId = [];
       
        for($i = 0; $i < count($resultQuery); $i++) { 

            if(isset($arrId[0])){
                $isRepeat = false;
                foreach($arrId as $id){
                    if($resultQuery[$i] -> id === $id) $isRepeat = true;
                }
                if(!$isRepeat) array_push($newResult, $resultQuery[$i]);
                array_push($arrId, $resultQuery[$i] -> id);
            }else{
                $arrId = [ $resultQuery[0] -> id ];
                $newResult = [ $resultQuery[0] ];
            }
        }

        for($i = 0; $i < count($newResult); $i++) unset($newResult[$i] -> id);
        $collectionResult = collect($newResult);

        return $collectionResult;
    }

    public function headings(): array{
        $head  = [
            'NOMBRES Y APELLIDOS',
            'DNI',
            'UA',
			'VEHICULO',
			'MARCA',
            'PLACA',
            'HOROMETRO',
            'GALONES',
            'H - INICIO',
			'H - TERMINO',
			'EMPRESA'
        ];

        return  $head;
    }
}

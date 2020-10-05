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
    	$fecha = $this->fecha;
    	$idGrifo = $this->idgrifo;
/*
		$consulta1 = "SELECT us.name  , cond.dni, ua.codigo , 
					vh.modelo, vh.placa, combust.qtdgl , combust.hora_inicio , combust.hora_fin 
					FROM abastecimiento_combustible combust JOIN users us ON( combust.user_id = us.id)
					JOIN ua ON(combust.ua_Id = ua.id)
					JOIN vehiculo vh ON(combust.vehiculo_id = vh.id)
					JOIN conductor cond ON(cond.user_id = us.id)
					WHERE combust.fecha_abastecimiento = {$fecha} AND 
					combust.grifo_id = {$idGrifo} ";

		$colect1 = collect(DB::select($consulta1));


		$consulta2 = "SELECT us.name  , cond.dni, ua.codigo , 
					equi.modelo , '  ' as espacio , combust.qtdgl , combust.hora_inicio , combust.hora_fin 
					FROM abastecimiento_combustible combust JOIN users us ON( combust.user_id = us.id)
					JOIN ua ON(combust.ua_Id = ua.id)
					JOIN equipo equi ON(combust.equipo_id = equi.id)
					JOIN conductor cond ON(cond.user_id = us.id)
					WHERE combust.fecha_abastecimiento = {$fecha} AND 
					combust.grifo_id = {$idGrifo} ";

		$colect2 = collect(DB::select($consulta2));
*/
		return  $resultQuery;
    }

    public function headings(): array{
        $head  = [
            'NOMBRES Y APELLIDOS',
            'DNI',
            'UA',
            'VEHICULOS',
            'PLACA',
            'HOROMETRO',
            'GALONES',
            'H - INICIO',
            'H - TERMINO',
        ];

        
        return  $head;
    }
}

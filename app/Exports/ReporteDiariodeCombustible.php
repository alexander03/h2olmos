<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\AbastecimientoCombustible;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReporteDiariodeCombustible implements FromCollection
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
		$consulta = "CONCAT(cond.nombres, ' - ', cond.apellidos) as 'nombres' , cond.dni, ua.codigo , 
					vh.descripcion, vh.placa, combust.qtdgl , combust.hora_inicio , combust.hora_fin , contra.descripcion
					FROM abastecimiento_combustible combust join conductor cond ON(combust.conductor_id = cond.id)
					JOIN ua ON(combust.ua_Id = ua.id)
					JOIN vehiculo vh ON(vh.id = combust.vehiculo_id)
					JOIN contratista contra ON(contra.id = vh.contratista_id)
					WHERE combust.fecha_abastecimiento = {$this->fecha } AND 
					combust.grifo_id = {$this->idgrifo} ";

		return DB::select($consulta);
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
            'C ANTERIOR',
            'COD ACTUAL',
            'EMPRESA'
        ];

        
        return  $head;
    }
}

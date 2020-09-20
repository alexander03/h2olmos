<?php

namespace App\Exports;

use App\AbastecimientoCombustible;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AbastecimientoCombustibleExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection(){
        
        $queryVehiculo = AbastecimientoCombustible::select('abastecimiento_combustible.id as id', 'fecha_abastecimiento', 'g.descripcion as desc', 'tipo_combustible', 
            DB::raw('(CASE WHEN conductor_id IS NULL THEN conductor_fake ELSE c.nombres END) AS nom'), 'c.apellidos as ap', 
            'c.dni as dni', 'ua.codigo as code', 'ua.descripcion as descua', 
            DB::raw('(CASE WHEN vh.modelo IS NULL THEN "-" ELSE vh.modelo END) AS desceq'), 
            'mc.descripcion as descmc', 
            DB::raw('(CASE WHEN vh.modelo IS NULL THEN "-" ELSE vh.modelo END) AS eqmode'), 
            DB::raw('(CASE WHEN vh.placa IS NULL THEN "-" ELSE vh.placa END) AS eqpl'),
            DB::raw('(CASE WHEN ct.razonsocial IS NULL THEN "-" ELSE ct.razonsocial END) AS crza'), 
            'qtdgl', 'qtdl', 'km', 'abastecimiento_dia')
            -> leftJoin('grifo as g', 'g.id', '=', 'grifo_id')
            -> leftJoin('conductor as c', 'c.id', '=', 'conductor_id')
            -> leftjoin('ua', 'ua.id', '=', 'ua_id')
            -> leftJoin('vehiculo as vh', 'vh.id', '=', 'vehiculo_id')
            -> leftJoin('marca as mc', 'mc.id', '=', 'vh.marca_id')
            -> leftJoin('contratista as ct', 'ct.id', '=', 'vh.contratista_id')
            -> whereNull('abastecimiento_combustible.deleted_at');

        $resultQuery = AbastecimientoCombustible::select('abastecimiento_combustible.id as id', 'fecha_abastecimiento', 'g.descripcion as desc', 'tipo_combustible', 
            DB::raw('(CASE WHEN conductor_id IS NULL THEN conductor_fake ELSE c.nombres END) AS nom'), 'c.apellidos as ap', 
            'c.dni as dni', 'ua.codigo as code', 'ua.descripcion as descua',
            DB::raw('(CASE WHEN eq.descripcion IS NULL THEN "-" ELSE eq.descripcion END) AS desceq'),
            'mc.descripcion as descmc', 
            DB::raw('(CASE WHEN eq.modelo IS NULL THEN "-" ELSE eq.modelo END) AS eqmode'), 
            DB::raw('(CASE WHEN eq.placa IS NULL THEN "-" ELSE eq.placa END) AS eqpl'), 
            DB::raw('(CASE WHEN ct.razonsocial IS NULL THEN "-" ELSE ct.razonsocial END) AS crza'), 
            'qtdgl', 'qtdl', 'km', 'abastecimiento_dia')
            -> leftJoin('grifo as g', 'g.id', '=', 'grifo_id')
            -> leftJoin('conductor as c', 'c.id', '=', 'conductor_id')
            -> leftjoin('ua', 'ua.id', '=', 'ua_id')
            -> leftJoin('equipo as eq', 'eq.id', '=', 'equipo_id')
            -> leftJoin('marca as mc', 'mc.id', '=', 'eq.marca_id')
            -> leftJoin('contratista as ct', 'ct.id', '=', 'eq.contratista_id')
            -> whereNull('abastecimiento_combustible.deleted_at')
            -> unionAll($queryVehiculo)
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
        return [
            'Fecha de abastecimiento',
            'Grifo',
            'Tipo de combustible',
            'Nombres',
            'Apellidos',
            'DNI',
            'Codigo UA',
            'Descripcion UA',
            'Unidad',
            'Marca',
            'Modelo',
            'Placa/serie',
            'Empresa',
            'QTD(GL)',
            'QTD(L)',
            'KM',
            'Abastecimiento por día'
        ];
    }
}

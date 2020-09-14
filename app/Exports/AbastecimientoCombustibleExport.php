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
        
        //TODO: PEDIR FORMATO PARA ESTANDARIZAR EL CONDUCTOR FAKE
        $queryVehiculo = AbastecimientoCombustible::select('fecha_abastecimiento', 'g.descripcion as desc', 'tipo_combustible', 
            DB::raw('(CASE WHEN conductor_id IS NULL THEN conductor_fake ELSE c.nombres END) AS nom'), 'c.apellidos as ap', 
            'c.dni as dni', 'ua.codigo as code', 'ua.descripcion as descua', 
            'vh.modelo as desceq', 'mc.descripcion as descmc', 'vh.modelo as eqmode', 'vh.placa as eqpl', 
            'ct.razonsocial as crza', 'qtdgl', 'qtdl', 'km', 'abastecimiento_dia')
            -> join('grifo as g', 'g.id', '=', 'grifo_id')
            -> leftJoin('conductor as c', 'c.id', '=', 'conductor_id')
            -> join('ua', 'ua.id', '=', 'ua_id')
            -> join('vehiculo as vh', 'vh.id', '=', 'vehiculo_id')
            -> join('marca as mc', 'mc.id', '=', 'vh.marca_id')
            -> join('contratista as ct', 'ct.id', '=', 'vh.contratista_id')
            -> whereNull('abastecimiento_combustible.deleted_at');

        return AbastecimientoCombustible::select('fecha_abastecimiento', 'g.descripcion as desc', 'tipo_combustible', 
            DB::raw('(CASE WHEN conductor_id IS NULL THEN conductor_fake ELSE c.nombres END) AS nom'), 'c.apellidos as ap', 
            'c.dni as dni', 'ua.codigo as code', 'ua.descripcion as descua', 
            'eq.descripcion as desceq', 'mc.descripcion as descmc', 'eq.modelo as eqmode', 'eq.placa as eqpl', 
            'ct.razonsocial as crza', 'qtdgl', 'qtdl', 'km', 'abastecimiento_dia')
            -> join('grifo as g', 'g.id', '=', 'grifo_id')
            -> leftJoin('conductor as c', 'c.id', '=', 'conductor_id')
            -> join('ua', 'ua.id', '=', 'ua_id')
            -> join('equipo as eq', 'eq.id', '=', 'equipo_id')
            -> join('marca as mc', 'mc.id', '=', 'eq.marca_id')
            -> join('contratista as ct', 'ct.id', '=', 'eq.contratista_id')
            -> whereNull('abastecimiento_combustible.deleted_at')
            -> unionAll($queryVehiculo)
            -> get();
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

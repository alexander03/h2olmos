<?php

namespace App\Exports;

use App\Ua;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UaExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection(){
    
        $uaList = Ua::select('ua.codigo', 'ua.descripcion', 'ua.tipo', 'ua.fondos',
            'ua.responsable', 'ua.tipo_costo', 'un.descripcion as unidad', 
            'u_padre.codigo as padreCodigo', 'u_padre.descripcion as padreDesc', 'ua.situacion', 
            'ua.fecha_inicio', 'ua.fecha_fin') 
            -> join('unidad as un', 'un.id', '=', 'ua.unidad_id') 
            -> leftjoin('ua as u_padre', 'u_padre.id', '=', 'ua.ua_padre_id')
            -> whereNull('ua.deleted_at')
            -> get();         

        foreach($uaList as $ua) {
           ($ua->getOriginal('fondos') == 0) ? $ua->fondos = 'NO POSEE' : $ua->fondos = 'SI POSEE';
           if(!$ua->getOriginal('padreCodigo')) $ua->padreCodigo = 'SIN PADRE';
           if(!$ua->getOriginal('padreDesc')) $ua->padreDesc = 'SIN PADRE';
           ($ua->getOriginal('situacion') == 0) ? $ua->situacion = 'INHABILITADO' : $ua->situacion = 'HABILITADO';
        }

        return $uaList;
    }

    public function headings(): array{
        return [
            'Codigo',
            'Descripción',
            'Tipo',
            'Fondos',
            'Responsable',
            'Tipo de costo',
            'Descripción',
            'Código ua padre',
            'Descripción ua padre',
            'Situación',
            'Fecha de inicio',
            'Fecha de fin'
        ];
    }
}

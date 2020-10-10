<?php

namespace App\Exports;

use App\Concesionaria;
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
    
        $uaList = Ua::select('ua.codigo', 'ua.descripcion', 'ua.habilitada', 'ua.fecha_inicio', 'ua.fecha_fin',
            'u_padre.codigo as padreCodigo', 'u_padre.descripcion as padreDesc','c.razonsocial as concesionaria') 
            -> leftjoin('ua as u_padre', 'u_padre.id', '=', 'ua.ua_padre_id')
            -> join('concesionaria as c','c.id','=','ua.concesionaria_id')
            -> whereNull('ua.deleted_at')
            -> where('ua.concesionaria_id','=',$this -> getConsecionariaActual())
            -> get();         

        foreach($uaList as $ua) {
           if(!$ua->getOriginal('padreCodigo')) $ua->padreCodigo = 'SIN PADRE';
           if(!$ua->getOriginal('padreDesc')) $ua->padreDesc = 'SIN PADRE';
           ($ua->getOriginal('habilitada') == 0) ? $ua->habilitada = 'INHABILITADA' : $ua->habilitada = 'HABILITADA';
           if(!$ua->getOriginal('fecha_fin')){
               $ua->fecha_fin = 'ILIMITADA';
           }else{
               $ua->fecha_fin = date("d/m/Y",strtotime($ua->fecha_fin)); 
           }
           $ua->fecha_inicio = date("d/m/Y",strtotime($ua->fecha_inicio));
        }

        return $uaList;
    }

    public function headings(): array{
        return [
            'Codigo',
            'Descripción',
            'Habilitada',
            'Fecha de inicio',
            'Fecha de fin',
            'Código ua padre',
            'Descripción ua padre',
            'Concesionaria'
        ];
    }
    
    private function getConsecionariaActual(){

        $ConcesionariaActual = Concesionaria::join('userconcesionaria','userconcesionaria.concesionaria_id','=','concesionaria.id')
            ->join('users','users.id','=','userconcesionaria.user_id')
            ->where('userconcesionaria.estado','=',true)->where('userconcesionaria.user_id','=',auth()->user()->id)
            ->select('concesionaria.id','concesionaria.razonsocial')->get();
        $idConcAct=$ConcesionariaActual[0]->id;

        return $idConcAct;
    }
}

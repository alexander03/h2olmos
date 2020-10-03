<?php

namespace App\Exports;

use App\Concesionaria;
use App\Ua;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UaExport2 implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection(){
    
        $uaList = Ua::select('ua.codigo', 'ua.descripcion', 
            'u_padre.codigo as padreCodigo', 'u_padre.descripcion as padreDesc','c.razonsocial as concesionaria','u_padre.ua_padre_id') 
            -> leftjoin('ua as u_padre', 'u_padre.id', '=', 'ua.ua_padre_id')
            -> join('concesionaria as c','c.id','=','ua.concesionaria_id')
            -> whereNull('ua.deleted_at')
            -> where('ua.concesionaria_id','=',$this -> getConsecionariaActual())
            -> orderBy('ua.codigo','asc')
            -> get();         

        foreach($uaList as $ua) {
            if(!$ua->getOriginal('padreCodigo')){
                $ua->padreCodigo = 'SIN PADRE';
            }else{
                $ua->descripcion = '                  '.$ua->descripcion;
                if(!is_null($ua->ua_padre_id) && $ua->ua_padre_id>0){
                    $ua->descripcion = '                  '.$ua->descripcion;    
                }
            }
            $ua->ua_padre_id='';
            if(!$ua->getOriginal('padreDesc')) $ua->padreDesc = 'SIN PADRE';
        }

        return $uaList;
    }

    public function headings(): array{
        return [
            'Codigo',
            'Descripción',
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

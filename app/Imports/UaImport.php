<?php

namespace App\Imports;

use App\Concesionaria;
use App\Ua;
use App\Unidad;
use Carbon\Carbon;
use ErrorException;
use Exception;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Excel;

class UaImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row){
        //ESCAPAR FILA
        if($row[0] === 'CODIGO') return null; 
        //VALIDACIONES DE CAMPOS VACÍOS
        if($row[0] === null || $row[1] === null 
            || $row[2] === null || $row[3] === null) return null;
        //VALIDAR QUE EL CÓDIGO SEA 8 DIGITOS
        if(strlen($row[0]) > 8) throw new Exception('Error UA no cumple con el formato de máximo de 8 digitos');
        //CONVERSIÓN EXPLICITA DE HABILITADO
        (strtolower($row[2]) == 'si' ) ? $row[2] = 1 : $row[2] = 0; 
        //CONVERSIÓN EXPLICITA DE DATOS US PADRE
        if(isset($row[0])){
            $ua_id = Ua::select('id')
                -> where([
                    [ 'codigo', 'LIKE', $row[0] ],
                    [ 'concesionaria_id', $this -> getConsecionariaActual() ]
                    ])
                -> get();
            if(count($ua_id) > 0) throw new Exception('UA ya existe '.$row[0]." ".$row[1]);
        }
        if(isset($row[5])){
            $ua_padre_id = Ua::select('id')
                -> where([
                    [ 'codigo', 'LIKE', $row[5] ],
                    [ 'concesionaria_id', $this -> getConsecionariaActual() ]
                    ])
                -> get();
            if(count($ua_padre_id) > 0) $row[5] = $ua_padre_id[0] -> id;
            else throw new Exception('UA PADRE no existe <strong>'.$row[5]. "</strong> de la UA ".$row[0]." ".$row[1]);
        }else{$row[5] = null;}
        
        try{
            $fecha = Carbon::instance(Date::excelToDateTimeObject($row[3]))->format('Y-m-d');
        }catch(ErrorException $ex){
            $fecha = Carbon::createFromFormat('Y-m-d', $row[3]);
        }
        
        if($row[4]!==""){
            try{
                $fecha1 = Carbon::instance(Date::excelToDateTimeObject($row[4]))->format('Y-m-d');
            }catch(ErrorException $ex){
                $fecha1 = Carbon::createFromFormat('Y-m-d', $row[4]);
            }
        }else{
            $fecha1 = null;
        }
  
        return new Ua([
            'codigo' => $row[0],
            'descripcion' => strtoupper($row[1]),
            'habilitada' => $row[2],
            'fecha_inicio' => $fecha,
            'fecha_fin' => $fecha1,
            'ua_padre_id' => $row[5],
            'concesionaria_id' => $this -> getConsecionariaActual()
        ]);
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

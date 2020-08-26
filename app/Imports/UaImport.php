<?php

namespace App\Imports;

use App\Ua;
use App\Unidad;
use Exception;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;

class UaImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row){
        
        if($row[0] === 'CODIGO') return null; //ESCAPAR FILA

        //Conversión explicita de datos fondos
        (strtolower($row[4]) == 'si' ) ? $row[4] = 1 : $row[4] = 0; 
        //Conversión explicita de datos unidad
        $unidad_id = Unidad::select('id') 
            -> where('descripcion', 'LIKE', strtoupper($row[2]))
            -> get();
        $row[2] = $unidad_id[0] -> id;
        //Conversión explicita de datos ua padre
        if(isset($row[7])){
            $ua_padre_id = Ua::select('id')
                -> where('codigo', 'LIKE', $row[7])
                -> get();
            if(count($ua_padre_id) > 0) $row[7] = $ua_padre_id[0] -> id;
            else throw new Exception('error');
        }else $row[7] = null;
        
        return new Ua([
            'codigo' => $row[0],
            'descripcion' => strtoupper($row[1]),
            'unidad_id' => $row[2],
            'tipo' => $row[3],
            'fondos' => $row[4],
            'responsable' => $row[5],
            'tipo_costo' => $row[6],
            'ua_padre_id' => $row[7]
        ]);
    }
}

<?php

namespace App\Imports;

use App\Ua;
use App\Unidad;
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
        
        //Conversión explicita de datos fondos
        (strtolower($row[3]) == 'si' ) ? $row[3] = 1 : $row[3] = 0; 
        //Conversión explicita de datos unidad
        $unidad_id = Unidad::select('id') 
            -> where('descripcion', 'LIKE', strtoupper($row[6]))
            -> get();
        $row[6] = $unidad_id[0] -> id;
        //Conversión explicita de datos ua padre
        if(isset($row[7])){
            $ua_padre_id = Ua::select('id')
                -> where('codigo', 'LIKE', $row[7])
                -> get();
            (count($ua_padre_id) > 0) ? 
            $row[7] = $ua_padre_id[0] -> id :
            $row[7] = null;
        }
        
        return new Ua([
            'codigo' => $row[0],
            'descripcion' => strtoupper($row[1]),
            'tipo' => $row[2],
            'fondos' => $row[3],
            'responsable' => $row[4],
            'tipo_costo' => $row[5],
            'unidad_id' => $row[6],
            'ua_padre_id' => $row[7]
        ]);
    }
}

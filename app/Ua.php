<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Ua extends Model{
    use SoftDeletes;
    protected $table = 'ua';
    protected $dates = ['deleted_at'];
    protected $fillable = ['codigo', 'descripcion', 'habilitada', 
                            'ua_padre_id', 'concesionaria_id',
                            'fecha_inicio', 'fecha_fin'];
            
    public function unidad(){

        return $this->belongsTo(Unidad::class, 'unidad_id');		
    }

    public function uaPadre($id){

        return DB::select('select codigo, descripcion from ua where id = ?', [ $id ]);
    }

}

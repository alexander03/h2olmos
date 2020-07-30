<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Ua extends Model{
    use SoftDeletes;
    protected $table = 'ua';
    protected $dates = ['deleted_at'];
    protected $fillable = ['codigo', 'descripcion', 'tipo', 
                            'fondos', 'responsable', 'tipo_costo', 'unidad_id', 'ua_padre_id'];

    public function unidad(){

        return $this->belongsTo(Unidad::class, 'unidad_id');		
    }

    public function uaPadre($id){

        return DB::select('select codigo, descripcion from ua where id = ?', [ $id ]);
    }
    // public function propietarios(){

    //     return $this->hasMany(Propietario::class, 'unidad_id'); 				 		
    // }

    // public static function boot() {
    //     parent::boot();

    //     static::deleting(function($ua) {
    //          $ua->propietarios()->delete();
    //     });
    // }
}

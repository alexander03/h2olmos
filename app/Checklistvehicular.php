<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class Checklistvehicular extends Model
{
    protected $table = 'checklistvehicular';
    use SoftDeletes;
    protected $fillable = [
        'fecha_registro', 'equipo_id','vehiculo_id', 'k_inicial',
        'k_final', 'lider_area', 'conductor_id', 'sistema_electronico',
        'sistema_mecanico', 'accesorios', 'documentos', 'observaciones'
    ];

    protected $casts = [
        'sistema_electronico' => 'array'
    ];

    public function scopegetFilter($query, $filter) {
        return $query->leftjoin('equipo', 'equipo.id', '=', 'checklistvehicular.equipo_id')
            ->leftjoin('vehiculo', 'vehiculo.id', 'checklistvehicular.vehiculo_id')
            ->join('conductor', 'conductor.id', 'checklistvehicular.conductor_id')
            ->orderBy('checklistvehicular.id', 'DESC')->withTrashed()
            ->select('checklistvehicular.id', 'checklistvehicular.fecha_registro', 'equipo.placa as equipo_placa', 'equipo.descripcion as equipo_descripcion', 'vehiculo.placa as vehiculo_placa', 'checklistvehicular.k_inicial', 'checklistvehicular.k_final', 'checklistvehicular.lider_area', 'conductor.nombres as conductor_nombres', 'conductor.apellidos as conductor_apellidos', 'checklistvehicular.sistema_electronico');
    }

}

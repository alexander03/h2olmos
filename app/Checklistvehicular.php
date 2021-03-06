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
        'sistema_electrico' => 'array',
        'sistema_mecanico' => 'array',
        'accesorios' => 'array',
        'documentos' => 'array',
    ];

    public function scopegetFilter($query, $fecha_registro_inicial, $fecha_registro_final) {

        $concesionariaAct = Concesionaria::join('userconcesionaria','userconcesionaria.concesionaria_id','=','concesionaria.id')
                                ->join('users','users.id','=','userconcesionaria.user_id')
                                ->where('userconcesionaria.estado','=',true)->where('userconcesionaria.user_id','=',auth()->user()->id)
                                ->select('concesionaria.id','concesionaria.razonsocial')->first();
        $idConcAct = $concesionariaAct->id;

        return $query->leftjoin('equipo', 'equipo.id', '=', 'checklistvehicular.equipo_id')
            ->leftjoin('vehiculo', 'vehiculo.id', 'checklistvehicular.vehiculo_id')
            ->join('conductor', 'conductor.id', 'checklistvehicular.conductor_id')
            ->where(function($subquery) use ($fecha_registro_inicial, $fecha_registro_final) {
                if ( $fecha_registro_inicial !== null ) $subquery->where('checklistvehicular.fecha_registro', '>=', $fecha_registro_inicial);
                if ( $fecha_registro_final !== null ) $subquery->where('checklistvehicular.fecha_registro', '<=', $fecha_registro_final);
            })
            ->where(function($subquery) use ($idConcAct) {
                $subquery->where('checklistvehicular.concesionaria_id', $idConcAct);
            })
            ->orderBy('checklistvehicular.id', 'DESC')
            ->select('checklistvehicular.id', 'checklistvehicular.fecha_registro', 'equipo.placa as equipo_placa', 'equipo.descripcion as equipo_descripcion', 'vehiculo.placa as vehiculo_placa', 'vehiculo.modelo as vehiculo_modelo', 'checklistvehicular.k_inicial', 'checklistvehicular.k_final', 'checklistvehicular.lider_area', 'conductor.nombres as conductor_nombres', 'conductor.apellidos as conductor_apellidos', 'checklistvehicular.sistema_electrico');
    }

    public function vehiculo()
    {
        return $this->belongsTo('App\Vehiculo');
    }

}

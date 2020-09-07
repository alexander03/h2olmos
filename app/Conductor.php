<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Conductor extends Model
{
    protected $table = 'conductor';
    use SoftDeletes;
    protected $fillable = ['nombres', 'apellidos', 'dni', 'categoria', 'licencia', 'fechavencimiento', 'contratista_id'];

    public function scopegetFilter($query, $estado, $filter, $categoria, $contratista_id) {
        $concesionariaAct = Concesionaria::join('userconcesionaria','userconcesionaria.concesionaria_id','=','concesionaria.id')
                                ->join('users','users.id','=','userconcesionaria.user_id')
                                ->where('userconcesionaria.estado','=',true)->where('userconcesionaria.user_id','=',auth()->user()->id)
                                ->select('concesionaria.id','concesionaria.razonsocial')->first();
        $idConcAct = $concesionariaAct->id;
        
        return $query->join('contratista', 'conductor.contratista_id', '=', 'contratista.id')
            ->join('conductorconcesionaria', 'conductorconcesionaria.conductor_id', '=', 'conductor.id')
            ->where(function($subquery) use ($estado) {
                if($estado === 'activos') $subquery->where('conductorconcesionaria.estado', true);
                elseif($estado === 'desactivados') $subquery->where('conductorconcesionaria.estado', false);
            })
            ->where(function($subquery) use ($filter) {
                $subquery->where('conductor.dni', strtoupper($filter))
                    ->orWhere('conductor.licencia', strtoupper($filter))
                    ->orWhere(DB::raw("concat(conductor.apellidos , ' ', conductor.nombres)"), 'LIKE', strtoupper($filter).'%')
                    ->orWhere(DB::raw("concat(conductor.nombres , ' ', conductor.apellidos)"), 'LIKE', strtoupper($filter).'%');
            })
            ->where(function($subquery) use ($categoria) {
                if($categoria !== 'all') $subquery->where('conductor.categoria', $categoria);
            })
            ->where(function($subquery) use ($contratista_id) {
                if($contratista_id !== 'all') $subquery->where('conductor.contratista_id', $contratista_id);
            })
            ->where(function($subquery) use ($idConcAct) {
                $subquery->where('conductorconcesionaria.concesionaria_id', $idConcAct);
            })
            ->orderBy('conductor.apellidos', 'ASC')
            ->select('conductor.id','conductor.nombres', 'conductor.apellidos', 'conductor.dni', 'conductor.categoria', 'conductor.licencia', 'conductor.fechavencimiento', 'conductor.deleted_at', 'contratista.razonsocial as contratista_razonsocial', 'conductorconcesionaria.estado as conductor_estado');
    }

    public function scopegetAll($query) {
        return $query->select('id', 'nombres', 'apellidos')->orderBy('apellidos', 'ASC')->get();
    }


}

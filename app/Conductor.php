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

    public function scopegetFilter($query, $filter, $categoria, $contratista_id) {
        return $query->join('contratista', 'conductor.contratista_id', '=', 'contratista.id')
            ->where(function($subquery) use ($filter) {
                $subquery->where('conductor.dni', strtoupper($filter))
                    ->orWhere('conductor.licencia', strtoupper($filter))
                    // ->orWhere('conductor.apellidos', 'LIKE', strtoupper($filter).'%')
                    // ->orWhere('conductor.nombres', 'LIKE', strtoupper($filter).'%')
                    ->orWhere(DB::raw("concat(conductor.apellidos , ' ', conductor.nombres)"), 'LIKE', strtoupper($filter).'%')
                    ->orWhere(DB::raw("concat(conductor.nombres , ' ', conductor.apellidos)"), 'LIKE', strtoupper($filter).'%');
            })
            ->where(function($subquery) use ($categoria) {
                if($categoria !== 'all') $subquery->where('conductor.categoria', $categoria);
            })
            ->where(function($subquery) use ($contratista_id) {
                if($contratista_id !== 'all') $subquery->where('conductor.contratista_id', $contratista_id);
            })
            ->orderBy('conductor.apellidos', 'ASC')
            ->select('conductor.id','conductor.nombres', 'conductor.apellidos', 'conductor.dni', 'conductor.categoria', 'conductor.licencia', 'conductor.fechavencimiento', 'contratista.razonsocial as contratista_razonsocial');
    }
}

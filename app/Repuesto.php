<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Repuesto extends Model
{
    protected $table = 'repuesto';
    use SoftDeletes;
    protected $fillable = ['codigo', 'descripcion', 'unidad_id'];

    public function scopegetFilter($query, $estado, $filter, $unidad_id) {
        return $query->join('unidad', 'repuesto.unidad_id', '=', 'unidad.id')
            ->where(function($subquery) use ($estado) {
                if($estado === 'activos') $subquery->whereNull('repuesto.deleted_at');
                elseif($estado === 'desactivados') $subquery->whereNotNull('repuesto.deleted_at');
            })
            ->where(function($subquery) use ($filter) {
                $subquery->where('repuesto.codigo', strtoupper($filter))
                    ->orWhere('repuesto.descripcion', 'LIKE', '%'.strtoupper($filter).'%');
            })
            ->where(function($subquery) use ($unidad_id) {
                if($unidad_id !== 'all') $subquery->where('repuesto.unidad_id', $unidad_id);
            })
            ->orderBy('repuesto.codigo', 'ASC')->withTrashed()
            ->select('repuesto.id', 'repuesto.codigo', 'repuesto.descripcion', 'repuesto.deleted_at', 'unidad.descripcion as unidad_descripcion');
    }
}

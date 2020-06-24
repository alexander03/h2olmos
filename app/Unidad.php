<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unidad extends Model
{
    protected $table = 'unidad';
    use SoftDeletes;
    
    protected $fillable = ['descripcion'];

    public function scopegetAll($query) {
        return $query->select('id', 'descripcion')->orderBy('descripcion', 'ASC')->get();
    }
}

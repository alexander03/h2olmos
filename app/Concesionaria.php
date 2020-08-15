<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Concesionaria extends Model
{
    protected $table = 'concesionaria';
    //use SoftDeletes;
    protected $fillable = ['ruc', 'razonsocial'];

    public function scopegetAll($query) {
        return $query->select('id', 'razonsocial')->orderBy('razonsocial', 'ASC')->get();
    }
}
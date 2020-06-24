<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Repuesto extends Model
{
    protected $table = 'repuesto';
    use SoftDeletes;
    
    protected $fillable = ['codigo', 'descripcion', 'unidad_id'];
}

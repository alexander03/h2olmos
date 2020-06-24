<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unidad extends Model
{
    protected $table = 'unidad';
    use SoftDeletes;
    
    protected $fillable = ['descripcion'];
}

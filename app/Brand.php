<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    protected $table = 'marca';
    use SoftDeletes;
    
    protected $fillable = ['descripcion'];
}

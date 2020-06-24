<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conductor extends Model
{
    protected $table = 'conductor';
    use SoftDeletes;
    protected $fillable = ['nombres', 'apellidos', 'dni', 'categoria', 'licencia', 'fechavencimiento', 'contratista_id'];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DescripcionRegRepVeh extends Model
{
    protected $table = 'descripcionregrepveh';
    protected $fillable = ['id','regrepveh_id', 'cantidad','codigo','unidad','monto','descripcion'];

}


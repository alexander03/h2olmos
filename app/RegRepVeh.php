<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegRepVeh extends Model
{
    protected $table = 'regrepveh';
    protected $fillable = ['id','concesionaria_id', 'cliente','estado','ua_id','kmman','kminicial','kmfinal','fechaentrada','fechasalida','tipomantenimiento','telefono'];

}

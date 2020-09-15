<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegManVeh extends Model
{
    protected $table = 'regmanveh';
    protected $fillable = ['id','concesionaria_id', 'cliente','estado','ua_id','kmman','kminicial','kmfinal','fechaentrada','fechasalida','tipomantenimiento','telefono'];
}

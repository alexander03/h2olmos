<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RegRepVeh extends Model
{
    use SoftDeletes;
    protected $table = 'regrepveh';
    protected $fillable = ['id','concesionaria_id','ordencompra', 'cliente','estado','ua_id','kmman','kminicial','kmfinal','fechaentrada','fechasalida','tipomantenimiento','telefono'];
    protected $dates = ['deleted_at'];

    public function vehiculo()
    {
        return $this->belongsTo('App\Vehiculo','ua_id');
    }
}

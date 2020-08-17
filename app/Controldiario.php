<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Controldiario extends Model
{
    use SoftDeletes;
    protected $table = 'controldiario';
    protected $dates = ['deleted_at','fecha'];

    public function tipohora()
    {
        return $this->belongsTo('App\Tipohora');
    }
    public function equipo()
    {
        return $this->belongsTo('App\Equipo');
    }

    public function ua()
    {
        return $this->belongsTo('App\Ua');
    }

    public function ua_origen()
    {
        return $this->belongsTo('App\Ua','id','uaorigen_id');
    }

    public function ua_destino()
    {
        return $this->belongsTo('App\Ua','id','uadestino_id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipo extends Model
{
    use SoftDeletes;
    protected $table = 'equipo';
    protected $dates = ['deleted_at'];


    
	/*
	public function ua()
    {
        return $this->belongsTo('App\Ua');
    }
    */

    public function marca()
    {
        return $this->belongsTo('App\Brand');
    }
	
	public function contratista()
    {
        return $this->belongsTo('App\Contratista');
    }

    public function area()
    {
        return $this->belongsTo('App\Area');
    }

    public function ua()
    {
        return $this->belongsTo('App\Ua');
    }    
    
    public function controlesdiarios()
    {
        return $this->hasMany('App\Controldiario')->where('controldiario.deleted_at',null);
    }

}

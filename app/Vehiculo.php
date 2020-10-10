<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehiculo extends Model
{
    use SoftDeletes;
    protected $table = 'vehiculo';
    protected $dates = ['deleted_at'];

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
    
    public function carroceria()
    {
        return $this->belongsTo('App\Carroceria','carroceria_id');
    }
    
    public function ua()
    {
        return $this->belongsTo('App\Ua');
    }
    
    public function kilometraje2()
    {
        return $this->belongsTo('App\Kilometraje','kilometraje_id');
    }
    
    public function kilometraje()
    {
        return $this->belongsTo('App\Kilometraje','kilometraje_id');
    }
}

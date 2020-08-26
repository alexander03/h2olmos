<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tipouser extends Model
{
	use SoftDeletes;
    protected $table = 'tipouser';
    protected $dates = ['deleted_at'];

    public function permisos(){
    	return $this->hasMany('App\Permiso');
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conductordocument extends Model
{
    use SoftDeletes;
    protected $table = 'conductordocument';

    public function conductor() {
        return $this->belongsTo('App\Conductor');
    }
}

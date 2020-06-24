<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contratista extends Model
{
    protected $table = 'contratista';
    use SoftDeletes;
    protected $fillable = ['ruc', 'razonsocial'];
}

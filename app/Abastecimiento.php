<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Abastecimiento extends Model
{
    use SoftDeletes;
    protected $table = 'Abastecimiento';
    protected $dates = ['deleted_at'];
}

<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class Checklistvehicular extends Model
{
    protected $table = 'checklistvehicular';
    use SoftDeletes;
    protected $fillable = [
        'fecha_registro', 'equipo_id','vehiculo_id', 'k_inicial',
        'k_final', 'lider_area', 'conductor_id', 'sistema_electronico',
        'sistema_mecanico', 'accesorios', 'documentos', 'observaciones'
    ];

    protected $casts = [
        'sistema_electronico' => 'array'
    ];

}

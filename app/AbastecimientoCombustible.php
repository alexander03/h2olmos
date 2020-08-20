<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AbastecimientoCombustible extends Model{

    use SoftDeletes;
    protected $table = 'abastecimiento_combustible';
    protected $dates = [ 'deleted_at' ];
  
    protected $fillable = [ 'fecha_abastecimiento', 'grifo_id', 'tipo_combustible', 
                            'conductor_id', 'ua_id', 'equipo_id', 'qtdgl', 'qtdl',
                            'km', 'abastecimiento_dia' ];
    
    public function grifo(){

        return $this->belongsTo(Grifo::class, 'grifo_id');		
    }

    public function conductor(){

        return $this->belongsTo(Conductor::class, 'conductor_id');		
    }
    
    public function ua(){

        return $this->belongsTo(Ua::class, 'ua_id');		
    }

    public function equipo(){

        return $this->belongsTo(Equipo::class, 'equipo_id');		
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbastecimientoCombustiblesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abastecimiento_combustible', function (Blueprint $table) {
            $table -> bigIncrements('id');
            $table -> date('fecha_abastecimiento');
            $table -> unsignedBigInteger('grifo_id');
            $table -> string('tipo_combustible');
            $table -> unsignedBigInteger('conductor_id') -> nullable();
            $table -> string('conductor_fake') -> nullable();
            $table -> unsignedBigInteger('ua_id');
            $table -> unsignedBigInteger('equipo_id') -> nullable();
            $table -> unsignedBigInteger('vehiculo_id') -> nullable();
            $table -> float('qtdgl');
            $table -> float('qtdl');
            $table -> float('km');
            $table -> float('abastecimiento_dia');
            $table -> text('motivo');
            $table -> string('comprobante');
            $table -> unsignedBigInteger('numero_comprobante');
            $table -> date('fecha_inicio');
            $table -> date('fecha_fin');
            $table -> timestamps();
            $table -> softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){

        Schema::dropIfExists('abastecimiento_combustible');
    }
}

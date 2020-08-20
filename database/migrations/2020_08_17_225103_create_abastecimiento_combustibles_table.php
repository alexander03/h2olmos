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
            $table -> unsignedBigInteger('conductor_id');
            $table -> unsignedBigInteger('ua_id');
            $table -> unsignedBigInteger('equipo_id');
            $table -> float('qtdgl');
            $table -> float('qtdl');
            $table -> float('km');
            $table -> float('abastecimiento_dia');
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

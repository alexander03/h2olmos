<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipo', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('codigo',10);
            $table->string('descripcion',22);
            $table->string('modelo',20);
            $table->string('placa',15);
            $table->string('motor',20);
            $table->integer('asientos');
            $table->unsignedBigInteger('marca_id');
            $table->unsignedBigInteger('contratista_id');
            $table->year('anio');
            $table->unsignedBigInteger('ua_id');
            $table->unsignedBigInteger('area_id');
            $table->string('chasis',20);
            $table->string('carroceria',10);
            $table->string('color',20);
            $table->date('fechavencimientosoat');
            $table->date('fechavencimientosgps');
            $table->date('fechavencimientortv');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipo');
    }
}

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
        //    $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('codigo',10)->nullable();
            $table->string('descripcion',22);
            $table->string('modelo',20);

            $table->string('placa',15)->nullable();
        /*
            $table->string('motor',20)->nullable();
            $table->integer('asientos')->nullable();
        */
            $table->unsignedBigInteger('marca_id');
            $table->unsignedBigInteger('contratista_id');
            $table->year('anio')->nullable();
            $table->unsignedBigInteger('area_id');
            $table->unsignedBigInteger('concesionaria_id');
            
            $table->unsignedBigInteger('ua_id')->nullable();
            /*
            $table->string('chasis',20)->nullable();
            $table->string('carroceria',10)->nullable();
            $table->string('color',20)->nullable();
            $table->date('fechavencimientosoat')->nullable();
            $table->date('fechavencimientogps')->nullable();
            $table->date('fechavencimientortv')->nullable();
            */
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConductorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conductor', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('dni', 8)->unique();
            $table->string('categoria');
            $table->string('licencia', 10)->unique();
            $table->date('fechavencimiento');
            $table->unsignedBigInteger('contratista_id');
            $table->unsignedBigInteger('concesionaria_id');
            $table->foreign('contratista_id')->references('id')->on('contratista');
            $table->foreign('concesionaria_id')->references('id')->on('concesionaria');
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
        Schema::dropIfExists('conductor');
    }
}

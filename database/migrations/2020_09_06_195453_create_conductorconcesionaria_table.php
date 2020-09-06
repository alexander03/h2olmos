<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConductorconcesionariaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conductorconcesionaria', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('conductor_id');
            $table->unsignedBigInteger('concesionaria_id');
            $table->foreign('conductor_id')->references('id')->on('conductor');
            $table->foreign('concesionaria_id')->references('id')->on('concesionaria');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conductorconcesionaria');
    }
}

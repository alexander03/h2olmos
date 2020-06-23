<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccesoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acceso', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('tipousuario_id')->unsigned()->nullable();
            $table->bigInteger('opcionmenu_id')->unsigned()->nullable();
            $table->foreign('tipousuario_id')->references('id')->on('tipousuario')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('opcionmenu_id')->references('id')->on('opcionmenu')->onDelete('restrict')->onUpdate('restrict');
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
        Schema::dropIfExists('acceso');
    }
}

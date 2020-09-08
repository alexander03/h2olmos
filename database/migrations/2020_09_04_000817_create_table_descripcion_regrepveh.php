<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class  CreateTableDescripcionRegRepVeh extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('descripcionregrepveh', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('regrepveh_id');;
            $table->string('cantidad');
            $table->string('codigo');
            $table->string('unidad');
            $table->integer('monto');
            $table->string('descripcion');
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
        Schema::dropIfExists('descripcionregrepveh');
    }
}
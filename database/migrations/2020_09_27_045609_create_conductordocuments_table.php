<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConductordocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conductordocument', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tipo', 30); // imagen-firma, conformidad-firma
            $table->string('archivo')->nullable();
            $table->unsignedBigInteger('conductor_id');
            $table->foreign('conductor_id')->references('id')->on('conductor');
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
        Schema::dropIfExists('conductordocument');
    }
}

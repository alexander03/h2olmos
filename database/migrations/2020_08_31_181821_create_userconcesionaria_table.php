<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserconcesionariaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userconcesionaria', function (Blueprint $table) {
            $table->integer('user_id');//->onDelete('restrict')->onUpdate('restrict');
            $table->integer('concesionaria_id');//->onDelete('restrict')->onUpdate('restrict');
            $table->boolean('estado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('userconcesionaria');
    }
}

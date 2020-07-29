<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ua', function (Blueprint $table) {
            //$table -> engine = 'InnoDB';
            $table -> bigIncrements('id');
            $table -> bigInteger('codigo') -> unique();
            $table -> text('descripcion');
            $table -> string('tipo');
            $table -> boolean('fondos');
            $table -> string('responsable');
            $table -> string('tipo_costo');
            $table -> bigIncrements('ua_padre_id') -> unique();
            $table -> unsignedBigInteger('unidad_id');
            $table -> timestamps();
            $table -> softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('ua');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}

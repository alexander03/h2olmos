<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateViewEquipoVehiculo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

        $query = "CREATE VIEW view_equipo_vehiculo AS
            SELECT id, descripcion, modelo, codigo as 'placa-codigo', placa, marca_id, area_id, 
                contratista_id, anio, 'e' as 'tipo', deleted_at FROM equipo 
            UNION ALL 
            SELECT id, modelo as 'descripcion', modelo, placa as 'placa-codigo', placa, marca_id, area_id, 
                contratista_id, anio, 'v' as 'tipo', deleted_at FROM vehiculo;";

        DB::statement($query);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){

        DB::statement("DROP VIEW view_equipo_vehiculo");
    }
}

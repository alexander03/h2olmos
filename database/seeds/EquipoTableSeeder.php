<?php

use Illuminate\Database\Seeder;

class EquipoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('equipo')->insert([
            'codigo' => '1234567FD',
            'descripcion' => 'GRUPO GENERADOR',
            'modelo' => 'P33-1',
            'placa' => '172084TB',
            'marca_id' => 1,
            'contratista_id' => 1,
            'anio' => '2010',
            'area_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('equipo')->insert([
            'codigo' => '452SE1FG',
            'descripcion' => 'CAMIONETA',
            'modelo' => 'L200',
            'placa' => '456123FD',
            'marca_id' => 2,
            'contratista_id' => 2,
            'anio' => '2015',
            'area_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);        
    }
}

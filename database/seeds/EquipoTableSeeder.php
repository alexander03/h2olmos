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
            'marca_id' => 1,
            'contratista_id' => 1,
            'ua_id' => 1,
            'anio' => '2010',
            'area_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('equipo')->insert([
            'codigo' => '452SE1FG',
            'descripcion' => 'CAMIONETA',
            'modelo' => 'L200',
            'carroceria' => 'PICK UP',
            'motor' => '1FDFSDF',
            'placa' => '456123FD',
            'asientos' => 5,
            'color' => 'BLANCO',
            'marca_id' => 2,
            'contratista_id' => 2,
            'ua_id' => 1,
            'anio' => '2015',
            'area_id' => 1,
            'fechavencimientosoat' => '2017-05-04',
            'fechavencimientogps' => '2013-05-04',
            'fechavencimientortv' => '2015-05-04',
            'created_at' => now(),
            'updated_at' => now()
        ]);        
    }
}

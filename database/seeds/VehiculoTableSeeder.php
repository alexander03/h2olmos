<?php

use Illuminate\Database\Seeder;

class VehiculoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vehiculo')->insert([
            'ua' => '66015H01',
            'placa' => 'M6E-769',
            'motor' => '1GD0346765',
            'modelo' => 'HILUX',
            'asientos' => 5,
            'anio' => '2017',
            'area_id' => 1,
            'marca_id' => 2,
            'color' => 'BLANCO PERLA',
            'chasis' => '8AJHA8CD3J607589',
            'carroceria' => 'PICK UP',
            'contratista_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]); 

        DB::table('vehiculo')->insert([
            'ua' => '66015H01',
            'placa' => 'M6E-766',
            'motor' => '1GD0343626',
            'modelo' => 'HILUX',
            'asientos' => 5,
            'anio' => '2017',
            'area_id' => 1,
            'marca_id' => 2,
            'color' => 'BLANCO PERLA',
            'chasis' => '8AJHA8CD3J606784',
            'carroceria' => 'PICK UP',
            'contratista_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]); 
    }
}

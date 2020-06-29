<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ua')->insert([
            'codigo' => 1000,
            'descripcion' => 'Esta ua es prueba 01',
            'tipo' => 'tipo 01',
            'fondos' => true,
            'responsable' => 'Gultron Gulp',
            'tipo_costo' => 'flete anual',
            'unidad_id'=> 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('ua')->insert([
            'codigo' => 1001,
            'descripcion' => 'Esta ua es prueba 02',
            'tipo' => 'tipo 02',
            'fondos' => true,
            'responsable' => 'Juanito Alachofa',
            'tipo_costo' => 'flete anual',
            'unidad_id'=> 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('ua')->insert([
            'codigo' => 1002,
            'descripcion' => 'Esta ua es prueba 03',
            'tipo' => 'tipo 03',
            'fondos' => false,
            'responsable' => 'Jhon Doe',
            'tipo_costo' => 'flete anual',
            'unidad_id'=> 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('ua')->insert([
            'codigo' => 1003,
            'descripcion' => 'Esta ua es prueba 04',
            'tipo' => 'tipo 04',
            'fondos' => true,
            'responsable' => 'Pluck Asegura',
            'tipo_costo' => 'flete anual',
            'unidad_id'=> 3,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}

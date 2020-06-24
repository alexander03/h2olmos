<?php

use Illuminate\Database\Seeder;

class UnidadTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('unidad')->insert([
            'descripcion' => 'CAMIONETA',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('unidad')->insert([
            'descripcion' => 'CAMION',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('unidad')->insert([
            'descripcion' => 'VOLQUETE',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('unidad')->insert([
            'descripcion' => 'EXCAVADORA',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('unidad')->insert([
            'descripcion' => 'CARGADOR FRONTAL',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}

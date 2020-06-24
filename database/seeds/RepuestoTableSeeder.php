<?php

use Illuminate\Database\Seeder;

class RepuestoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('repuesto')->insert([
            'codigo' => '101',
            'descripcion' => 'FRENO DE MANO',
            'unidad_id' => '1',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('repuesto')->insert([
            'codigo' => '103',
            'descripcion' => 'FAROS DELANTEROS',
            'unidad_id' => '2',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('repuesto')->insert([
            'codigo' => '104',
            'descripcion' => 'ALARMA DE RETROCESO',
            'unidad_id' => '2',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('repuesto')->insert([
            'codigo' => '105',
            'descripcion' => 'PARACHOQUES',
            'unidad_id' => '2',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}

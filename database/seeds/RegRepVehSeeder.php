<?php

use Illuminate\Database\Seeder;

class RegRepVehSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('regrepveh')->insert([
            'concesionaria_id' => 1,
            'ua_id' => 1001,
            'cliente' => 'cliente de H2O',
            'kmman' => 10,
            'kminicial' => 12,
            'kmfinal' => 13,
            'fechaentrada' => now(),
            'fechasalida' => now(),
            'tipomantenimiento' => 1,
            'telefono' => 154251452
  		]);
        DB::table('regrepveh')->insert([
            'concesionaria_id' => 2,
            'ua_id' => 1000,
            'cliente' => 'cliente de CTO',
            'kmman' => 100,
            'kminicial' => 120,
            'kmfinal' => 130,
            'fechaentrada' => now(),
            'fechasalida' => now(),
            'tipomantenimiento' => 1,
            'telefono' => 22222222
        ]);
    }
}

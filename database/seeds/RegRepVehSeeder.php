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
        DB::table('descripcionregrepveh')->insert([
            'id' => 1,
            'regrepveh_id' => 1,
            'cantidad' => 20,
            'codigo' => 'gggg',
            'unidad' => '10',
            'monto' => 12,
            'descripcion' => 'descripcion 1',
        ]);
        DB::table('descripcionregrepveh')->insert([
            'id' => 2,
            'regrepveh_id' => 2,
            'cantidad' => 20,
            'codigo' => 'gggg',
            'unidad' => '10',
            'monto' => 12,
            'descripcion' => 'descripcion 2',
        ]);

DB::table('descripcionregrepveh')->insert([
            'id' => 3,
            'regrepveh_id' => 2,
            'cantidad' => 20,
            'codigo' => 'gggg',
            'unidad' => '10',
            'monto' => 12,
            'descripcion' => 'descripcion 3n',
        ]);

DB::table('descripcionregrepveh')->insert([
            'id' => 4,
            'regrepveh_id' => 2,
            'cantidad' => 20,
            'codigo' => 'gggg',
            'unidad' => '10',
            'monto' => 12,
            'descripcion' => 'descripcion 4',
        ]);
    }
}

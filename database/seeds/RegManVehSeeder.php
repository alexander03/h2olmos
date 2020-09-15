<?php

use Illuminate\Database\Seeder;

class RegManVehSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('regmanveh')->insert([
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

        DB::table('regmanveh')->insert([
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
        
        DB::table('descripcionregmanveh')->insert([
            'regmanveh_id' => 1,
            'cantidad' => 10,
            'monto' => 2504,
            'trabajo_id' => 1,
        ]);
        DB::table('descripcionregmanveh')->insert([
            'regmanveh_id' => 1,
            'cantidad' => 11,
            'monto' => 2503,
            'trabajo_id' => 2,
        ]);
        DB::table('descripcionregmanveh')->insert([
            'regmanveh_id' => 2,
            'cantidad' => 12,
            'monto' => 2502,
            'trabajo_id' => 2,
        ]);
        DB::table('descripcionregmanveh')->insert([
            'regmanveh_id' => 2,
            'cantidad' => 13,
            'monto' => 2501,
            'trabajo_id' => 1,
        ]);
        DB::table('descripcionregmanveh')->insert([
            'regmanveh_id' => 2,
            'cantidad' => 14,
            'monto' => 2500,
            'trabajo_id' => 2,
        ]);

    }
}

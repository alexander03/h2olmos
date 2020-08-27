<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AbastecimientoCombustibleTableSeeder extends Seeder{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

        DB::table('abastecimiento_combustible')->insert([
            'fecha_abastecimiento' => now(),
            'grifo_id' => 1,
            'tipo_combustible' => 'Diesel',
            'conductor_id' => 2,
            'ua_id' => 2,
            'equipo_id' => 2,
            'qtdgl' => 20.6,
            'qtdl' => 30.6,
            'km' => 128.5,
            'abastecimiento_dia' => 21.33,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('abastecimiento_combustible')->insert([
            'fecha_abastecimiento' => now(),
            'grifo_id' => 2,
            'tipo_combustible' => 'GLT',
            'conductor_id' => 1,
            'ua_id' => 3,
            'equipo_id' => 2,
            'qtdgl' => 10.6,
            'qtdl' => 320.6,
            'km' => 18.5,
            'abastecimiento_dia' => 21.21,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('abastecimiento_combustible')->insert([
            'fecha_abastecimiento' => now(),
            'grifo_id' => 1,
            'tipo_combustible' => 'Gas',
            'conductor_id' => 2,
            'ua_id' => 2,
            'equipo_id' => 2,
            'qtdgl' => 200.6,
            'qtdl' => 320.6,
            'km' => 128.5,
            'abastecimiento_dia' => 2.36,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}

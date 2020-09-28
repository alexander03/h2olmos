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
            'conductor_id' => 2,
            'conductor_fake' => null,
            'ua_id' => 2,
            'equipo_id' => 2,
            'vehiculo_id' => null,
            'qtdgl' => 20.6,
            'qtdl' => 30.6,
            'km' => 128.5,
            'abastecimiento_dia' => 21.33,
            'motivo' => 'Llenado de mi tanque que ya no poseía',
            'comprobante' => 'BOLETA',
            'numero_comprobante' => 1,
            'fecha_inicio' => now(),
            'fecha_fin' => '2021-09-12',
            'abastecimiento_id' => 1,
            'tipocombustible_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('abastecimiento_combustible')->insert([
            'fecha_abastecimiento' => now(),
            'grifo_id' => 2,
            'conductor_id' => 1,
            'conductor_fake' => null,
            'ua_id' => 3,
            'equipo_id' => 2,
            'vehiculo_id' => null,
            'qtdgl' => 10.6,
            'qtdl' => 320.6,
            'km' => 18.5,
            'abastecimiento_dia' => 21.21,
            'motivo' => 'Llenado de mi tanque que ya no poseía',
            'comprobante' => 'BOLETA',
            'numero_comprobante' => 2,
            'fecha_inicio' => now(),
            'fecha_fin' => '2021-09-12',
            'abastecimiento_id' => 1,
            'tipocombustible_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('abastecimiento_combustible')->insert([
            'fecha_abastecimiento' => now(),
            'grifo_id' => 1,
            'conductor_id' => 2,
            'conductor_fake' => null,
            'ua_id' => 2,
            'equipo_id' => 2,
            'vehiculo_id' => null,
            'qtdgl' => 200.6,
            'qtdl' => 320.6,
            'km' => 128.5,
            'abastecimiento_dia' => 2.36, 
            'motivo' => 'Llenado de mi tanque que ya no poseía',
            'comprobante' => 'BOLETA',
            'numero_comprobante' => 3,
            'fecha_inicio' => now(),
            'fecha_fin' => '2021-09-12',
            'abastecimiento_id' => 1,
            'tipocombustible_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}

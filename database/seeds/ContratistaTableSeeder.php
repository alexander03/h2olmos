<?php

use Illuminate\Database\Seeder;

class ContratistaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contratista')->insert([
            'ruc' => '12345678901',
            'razonsocial' => 'EMPRESA LAGARITA SAC',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('contratista')->insert([
            'ruc' => '74679823478',
            'razonsocial' => 'GRUPO MIMASCOT SRL',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('contratista')->insert([
            'ruc' => '92347859878',
            'razonsocial' => 'CONVENCIONES POLVOS ROSADOS SAA',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}

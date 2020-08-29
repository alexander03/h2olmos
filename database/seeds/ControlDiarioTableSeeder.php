<?php

use Illuminate\Database\Seeder;

class ControlDiarioTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('controldiario')->insert([
            'equipo_id' => 1,
            'ua_id' => 1,
            'turno' => 1,
            'tipohora_id' => 1,
            'fecha' => '2020-8-20',
            'hora_inicio' => '15:00',
            'hora_fin' => '17:00',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('controldiario')->insert([
            'equipo_id' => 1,
            'ua_id' => 1,
            'turno' => 1,
            'tipohora_id' => 2,
            'fecha' => '2020-8-20',
            'hora_inicio' => '15:00',
            'hora_fin' => '17:00',
            'created_at' => now(),
            'updated_at' => now()
        ]);        
    }
}

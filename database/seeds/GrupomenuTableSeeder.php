<?php

use Illuminate\Database\Seeder;

class GrupomenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('grupomenu')->insert([
            'descripcion' => 'MANTENIMIENTO',
            'icono' => 'myicon',
            'orden' => 1
        ]);
        DB::table('grupomenu')->insert([
            'descripcion' => 'SISTEMA',
            'icono' => 'myicon',
            'orden' => 2
        ]);
        DB::table('grupomenu')->insert([
            'descripcion' => 'PROCESOS',
            'icono' => 'myicon',
            'orden' => 3
        ]);
    }
}

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
            'descripcion' => 'Mantenimiento',
            'icono' => 'myicon',
            'orden' => 1
        ]);
    }
}

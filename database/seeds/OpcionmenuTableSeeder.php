<?php

use Illuminate\Database\Seeder;

class OpcionmenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('opcionmenu')->insert([
            'descripcion' => 'Marcas',
            'link' => 'marcas',
            'icono' => 'myicon',
            'orden' => 1,
            'grupomenu_id' => 1
        ]);
        DB::table('opcionmenu')->insert([
            'descripcion' => 'Repuestos',
            'link' => 'repuestos',
            'icono' => 'myicon',
            'orden' => 2,
            'grupomenu_id' => 1
        ]);
    }
}

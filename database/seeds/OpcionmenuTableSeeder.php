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
        DB::table('opcionmenu')->insert([
            'descripcion' => 'Conductores',
            'link' => 'conductores',
            'icono' => 'myicon',
            'orden' => 3,
            'grupomenu_id' => 1
        ]);
        DB::table('opcionmenu')->insert([
            ['descripcion' => 'Areas',
            'link' => 'areas',
            'icono' => 'myicon',
            'orden' => 4,
            'grupomenu_id' => 1],
            ['descripcion' => 'Contratistas',
            'link' => 'contratistas',
            'icono' => 'myicon',
            'orden' => 5,
            'grupomenu_id' => 1],
            ['descripcion' => 'Trabajos',
            'link' => 'trabajos',
            'icono' => 'myicon',
            'orden' => 6,
            'grupomenu_id' => 1],
        ]);
    }
}

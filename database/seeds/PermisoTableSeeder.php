<?php

use Illuminate\Database\Seeder;

class PermisoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permiso')->insert([
            'opcionmenu_id' => 10,
            'tipouser_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('permiso')->insert([
            'opcionmenu_id' => 1,
            'tipouser_id' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('permiso')->insert([
            'opcionmenu_id' => 2,
            'tipouser_id' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);        
    }
}

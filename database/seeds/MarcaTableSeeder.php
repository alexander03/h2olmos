<?php

use Illuminate\Database\Seeder;

class MarcaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('marca')->insert([
            'descripcion' => 'MITSUBISHI',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('marca')->insert([
            'descripcion' => 'TOYOTA',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('marca')->insert([
            'descripcion' => 'RELUX',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('marca')->insert([
            'descripcion' => 'PIRAMIDE',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('marca')->insert([
            'descripcion' => 'BERTOLINI',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}

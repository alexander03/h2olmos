<?php

use Illuminate\Database\Seeder;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('brands')->insert([
            'descripcion' => 'MITSUBISHI',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('brands')->insert([
            'descripcion' => 'TOYOTA',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('brands')->insert([
            'descripcion' => 'RELUX',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('brands')->insert([
            'descripcion' => 'PIRAMIDE',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('brands')->insert([
            'descripcion' => 'BERTOLINI',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}

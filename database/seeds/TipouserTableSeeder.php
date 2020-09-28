<?php

use Illuminate\Database\Seeder;

class TipouserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipouser')->insert([
            'descripcion' => 'ADMIN',
            'created_at' => now(),
            'updated_at' => now()
        ]);    

        DB::table('tipouser')->insert([
            'descripcion' => 'EMPLEADO',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('tipouser')->insert([
            'descripcion' => 'CONDUCTOR',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}

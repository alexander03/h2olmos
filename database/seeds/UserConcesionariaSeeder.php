<?php

use Illuminate\Database\Seeder;

class UserConcesionariaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('userconcesionaria')->insert([
            'user_id' => 1,
            'concesionaria_id' => 1,
            'estado'=>false
        ]);
        DB::table('userconcesionaria')->insert([
            'user_id' => 1,
            'concesionaria_id' => 2,
            'estado'=>true
        ]);
    }
}

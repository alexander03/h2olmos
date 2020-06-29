<?php

use Illuminate\Database\Seeder;

class AreaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('area')->insert([

	        ['descripcion' => 'O&M',
	        'created_at' => now(),
	        'updated_at' => now()],

        ]);
    }
}

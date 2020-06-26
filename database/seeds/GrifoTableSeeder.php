<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class GrifoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
     App\Grifo::create(['descripcion' => 'Mi grifo']);   
     App\Grifo::create(['descripcion' => 'Gran grifo']); 
     App\Grifo::create(['descripcion' => 'Buen grifo']);   
    }
}

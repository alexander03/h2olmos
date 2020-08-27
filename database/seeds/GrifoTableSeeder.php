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
     App\Grifo::create(['descripcion' => 'LEON DE ORO']);   
     App\Grifo::create(['descripcion' => 'PECSA']); 
     App\Grifo::create(['descripcion' => 'PRIMAX']);   
    }
}

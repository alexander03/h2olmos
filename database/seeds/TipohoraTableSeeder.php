<?php

use Illuminate\Database\Seeder;

class TipohoraTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
     App\Tipohora::create(['codigo' => 1 , 'descripcion' => 'Trabajo']);   
     App\Tipohora::create(['codigo' => 2 , 'descripcion' => 'Refrigerio']); 
     App\Tipohora::create(['codigo' => 3 , 'descripcion' => 'Abastecimiento']);       }
}

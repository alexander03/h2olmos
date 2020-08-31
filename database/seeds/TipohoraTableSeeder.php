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
     App\Tipohora::create(['codigo' => 1 , 'descripcion' => 'Abastecimiento']);   
     App\Tipohora::create(['codigo' => 2 , 'descripcion' => 'Reparación de llantas']); 
     App\Tipohora::create(['codigo' => 3 , 'descripcion' => 'Mantenimiento Mecanico']);   
     App\Tipohora::create(['codigo' => 4 , 'descripcion' => 'Parado Inoperativo']);       
 }
}

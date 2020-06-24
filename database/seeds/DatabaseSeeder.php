<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            MarcaTableSeeder::class,
            GrupomenuTableSeeder::class,
            OpcionmenuTableSeeder::class,
            UnidadTableSeeder::class,
            RepuestoTableSeeder::class,
            ContratistaTableSeeder::class,
            ConductorTableSeeder::class
        ]);
    }
}

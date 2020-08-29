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
            TipouserTableSeeder::class,
            UsersTableSeeder::class,
            MarcaTableSeeder::class,
            GrupomenuTableSeeder::class,
            OpcionmenuTableSeeder::class,
            UnidadTableSeeder::class,
            RepuestoTableSeeder::class,
            ContratistaTableSeeder::class,
            // ConcesionariaTableSeeder::class,
            ConductorTableSeeder::class,
            AreaTableSeeder::class,
            TrabajoTableSeeder::class,
            TipohoraTableSeeder::class,
            GrifoTableSeeder::class,
            UaTableSeeder::class,
            EquipoTableSeeder::class,
            PropietariosTableSeeder::class,
            PermisoTableSeeder::class,
            // ChecklistvehicularTableSeeder::class
        ]);
    }
}

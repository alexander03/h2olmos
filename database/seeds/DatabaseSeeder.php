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
            CarroceriaTableSeeder::class,
            ConcesionariaTableSeeder::class,
            TipouserTableSeeder::class,
            UsersTableSeeder::class,
            MarcaTableSeeder::class,
            GrupomenuTableSeeder::class,
            OpcionmenuTableSeeder::class,
            UnidadTableSeeder::class,
            RepuestoTableSeeder::class,
            ContratistaTableSeeder::class,
            ConductorTableSeeder::class,
            ConductorConcesionariaSeeder::class,
            AreaTableSeeder::class,
            TrabajoTableSeeder::class,
            TipohoraTableSeeder::class,
            GrifoTableSeeder::class,
            UaTableSeeder::class,
            EquipoTableSeeder::class,
            VehiculoTableSeeder::class,
            ControlDiarioTableSeeder::class,
            AccesoTableSeeder::class,
            VehiculoDocumentTableSeeder::class,
            ChecklistvehicularTableSeeder::class,
            AbastecimientoCombustibleTableSeeder::class,
            UserConcesionariaSeeder::class,
            RegRepVehSeeder::class
        ]);
    }
}

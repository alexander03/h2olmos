<?php

use Illuminate\Database\Seeder;
use App\Checklistvehicular;

class ChecklistvehicularTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon\Carbon::now('America/Lima')->toDateTimeString();
        Checklistvehicular::create([
            'fecha_registro' => $now,
            'equipo_id' => 1,
            'k_inicial' => 54.00,
            'k_final' => 80.00,
            'lider_area' => 'OSCAR MARIANO DEL PORTAL',
            'conductor_id' => 1,
            'sistema_electronico' => [
                [
                    'id' => 'freno_emergencia',
                    'title' => 'Freno de emergencia',
                    'estado' => true
                ],
                [
                    'id' => 'funcionamiento_tablero',
                    'title' => 'Funcionamiento de tablero',
                    'estado' => false
                ],
                [
                    'id' => 'estado_bateria_funcionamiento',
                    'title' => 'Estado de batería y funcionamiento',
                    'estado' => false
                ],
                [
                    'id' => 'funcionamiento_claxon',
                    'title' => 'Funcionamiento de claxon',
                    'estado' => false
                ],
                [
                    'id' => 'luces_retroceso_pirata',
                    'title' => 'Luces de retroceso pirata',
                    'estado' => false
                ],
                [
                    'id' => 'luz_direccional',
                    'title' => 'Luces direccional',
                    'estado' => false
                ],
                [
                    'id' => 'faros_neblineros',
                    'title' => 'Faros neblineros',
                    'estado' => false
                ],
                [
                    'id' => 'faros_delanteros',
                    'title' => 'Faros delanteros',
                    'estado' => false
                ],
                [
                    'id' => 'faros_posteriores',
                    'title' => 'Faros posteriores',
                    'estado' => false
                ],
                [
                    'id' => 'alarma_retroceso',
                    'title' => 'Alarma de retroceso',
                    'estado' => false
                ],
                
            ],
            'created_at' => $now,
        ]);
        Checklistvehicular::create([
            'fecha_registro' => $now,
            'equipo_id' => 2,
            'k_inicial' => 100.00,
            'k_final' => 220.00,
            'lider_area' => 'JOSE ESTEFAN HURTADO MONTERO',
            'conductor_id' => 2,
            'sistema_electronico' => [
                [
                    'id' => 'freno_emergencia',
                    'title' => 'Freno de emergencia',
                    'estado' => true
                ],
                [
                    'id' => 'funcionamiento_tablero',
                    'title' => 'Funcionamiento de tablero',
                    'estado' => false
                ],
                [
                    'id' => 'estado_bateria_funcionamiento',
                    'title' => 'Estado de batería y funcionamiento',
                    'estado' => false
                ],
                [
                    'id' => 'funcionamiento_claxon',
                    'title' => 'Funcionamiento de claxon',
                    'estado' => false
                ],
                [
                    'id' => 'luces_retroceso_pirata',
                    'title' => 'Luces de retroceso pirata',
                    'estado' => false
                ],
                [
                    'id' => 'luz_direccional',
                    'title' => 'Luces direccional',
                    'estado' => false
                ],
                [
                    'id' => 'faros_neblineros',
                    'title' => 'Faros neblineros',
                    'estado' => false
                ],
                [
                    'id' => 'faros_delanteros',
                    'title' => 'Faros delanteros',
                    'estado' => false
                ],
                [
                    'id' => 'faros_posteriores',
                    'title' => 'Faros posteriores',
                    'estado' => false
                ],
                [
                    'id' => 'alarma_retroceso',
                    'title' => 'Alarma de retroceso',
                    'estado' => false
                ],
                
            ],
            'created_at' => $now,
        ]);
    }
}

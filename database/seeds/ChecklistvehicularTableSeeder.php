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
                ['id' => 'freno_emergencia', 'titulo' => 'Freno de emergencia', 'estado' => true],
                ['id' => 'funcionamiento_tablero', 'titulo' => 'Funcionamiento de tablero','estado' => false],
                ['id' => 'estado_bateria_funcionamiento', 'titulo' => 'Estado de batería y funcionamiento', 'estado' => false],
                ['id' => 'funcionamiento_claxon', 'titulo' => 'Funcionamiento de claxon', 'estado' => false],
                ['id' => 'luces_retroceso_pirata', 'titulo' => 'Luces de retroceso pirata','estado' => false],
                ['id' => 'luces_direccional', 'titulo' => 'Luces direccional','estado' => false],
                ['id' => 'faros_neblineros', 'titulo' => 'Faros neblineros','estado' => false],
                ['id' => 'faros_delanteros', 'titulo' => 'Faros delanteros','estado' => false],
                ['id' => 'faros_posteriores', 'titulo' => 'Faros posteriores','estado' => false],
                ['id' => 'alarma_retroceso', 'titulo' => 'Alarma de retroceso','estado' => false],
            ],
            'sistema_mecanico' => [
                ['id' => 'nivel_liquido_freno', 'titulo' => 'Nivel liquido de freno', 'estado' => true],
                ['id' => 'sistema_direccion', 'titulo' => 'Sistema de dirección', 'estado' => true],
                ['id' => 'palancas_cambios', 'titulo' => 'Palancas de cambios', 'estado' => true],
                ['id' => 'estado_neumaticos', 'titulo' => 'Estado de neumáticos', 'estado' => true],
                ['id' => 'llantas_repuesto', 'titulo' => 'Llantas de repuesto', 'estado' => false],
                ['id' => 'ajustes_tuercas', 'titulo' => 'Ajustes de tuercas', 'estado' => false],
                ['id' => 'presion_llantas_libras', 'titulo' => 'Presion de llantas en libras', 'estado' => false],
                ['id' => 'cinturon_seguridad_conductor', 'titulo' => 'Cinturon de seguridad conductor', 'estado' => true],
                ['id' => 'cinturon_seguridad_pasajeros', 'titulo' => 'Cinturon de seguridad pasajeros', 'estado' => true],
                ['id' => 'suspension', 'titulo' => 'Suspensión', 'estado' => true],

                ['id' => 'sistema_freno', 'titulo' => 'Sistema de freno', 'estado' => true],
                ['id' => 'pernos_neumaticos', 'titulo' => 'Pernos de neumáticos', 'estado' => true],
                ['id' => 'nivel_aceite', 'titulo' => 'Nivel de aceite', 'estado' => true],
                ['id' => 'espejos_int_ext', 'titulo' => 'Espejos int y ext', 'estado' => true],
                ['id' => 'parachoques', 'titulo' => 'Parachoques', 'estado' => true],
                ['id' => 'parabrisas_ventanas', 'titulo' => 'Parabrisas y ventanas', 'estado' => true],
                ['id' => 'puertas_cabina', 'titulo' => 'Puertas de cabina', 'estado' => true],
                ['id' => 'puertas_tolva', 'titulo' => 'Puertas de tolva', 'estado' => true],
                ['id' => 'plumillas', 'titulo' => 'Plumillas', 'estado' => true],
                ['id' => 'estado_carroceria', 'titulo' => 'Estado de carrocería', 'estado' => true],

            ],
            'accesorios' => [
                ['id' => 'estuche_herramientas', 'titulo' => 'Estuche de herramientas', 'estado' => true],
                ['id' => 'estado_carga_extintor', 'titulo' => 'Estado y carga de extintor', 'estado' => true],
                ['id' => 'botiquin', 'titulo' => 'Botiquín', 'estado' => true],
                ['id' => 'cable_remolque', 'titulo' => 'Cable de remolque', 'estado' => true],
                ['id' => 'tacos_seguridad_cuña_2', 'titulo' => 'Tacos de seguridad cuña(2)', 'estado' => true],
                ['id' => 'llave_ruedas', 'titulo' => 'Llave de ruedas', 'estado' => true],
                ['id' => 'kit_antiderrames', 'titulo' => 'Kit antiderrames', 'estado' => true],
                ['id' => 'limpieza_unidad', 'titulo' => 'Limpieza de la unidad', 'estado' => true],
            ],
            'documentos' => [
                ['id' => 'tarjeta_propiedad', 'titulo' => 'Tarjeta de propiedad', 'estado' => true],
                ['id' => 'soat', 'titulo' => 'SOAT', 'estado' => true],
                ['id' => 'licencia_conducir', 'titulo' => 'Licencia de conducir', 'estado' => true],
                ['id' => 'revision_tecnica', 'titulo' => 'Revisión técnica', 'estado' => true],
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
                ['id' => 'freno_emergencia', 'titulo' => 'Freno de emergencia', 'estado' => true],
                ['id' => 'funcionamiento_tablero', 'titulo' => 'Funcionamiento de tablero','estado' => false],
                ['id' => 'estado_bateria_funcionamiento', 'titulo' => 'Estado de batería y funcionamiento', 'estado' => false],
                ['id' => 'funcionamiento_claxon', 'titulo' => 'Funcionamiento de claxon', 'estado' => false],
                ['id' => 'luces_retroceso_pirata', 'titulo' => 'Luces de retroceso pirata','estado' => false],
                ['id' => 'luces_direccional', 'titulo' => 'Luces direccional','estado' => false],
                ['id' => 'faros_neblineros', 'titulo' => 'Faros neblineros','estado' => false],
                ['id' => 'faros_delanteros', 'titulo' => 'Faros delanteros','estado' => false],
                ['id' => 'faros_posteriores', 'titulo' => 'Faros posteriores','estado' => false],
                ['id' => 'alarma_retroceso', 'titulo' => 'Alarma de retroceso','estado' => false],
            ],
            'created_at' => $now,
        ]);
    }
}

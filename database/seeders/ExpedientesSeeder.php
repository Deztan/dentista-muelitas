<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ExpedientesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('expedientes')->insert([
            [
                'paciente_id' => 3, // Roberto Mendoza
                'cita_id' => 3,
                'tratamiento_id' => 3, // Extracción simple
                'odontologo_id' => 1,
                'asistente_id' => 2,
                'fecha' => Carbon::today()->subDays(5),
                'diagnostico' => 'Pieza dental #16 con caries profunda no restaurable',
                'descripcion_tratamiento' => 'Se realizó extracción dental simple bajo anestesia local. Paciente diabético, se tomaron precauciones adicionales. Procedimiento sin complicaciones.',
                'pieza_dental' => '16',
                'archivos_adjuntos' => null,
                'observaciones' => 'Se indicó antibiótico profiláctico. Control en 7 días.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'paciente_id' => 1, // Juan Carlos Pérez
                'cita_id' => null,
                'tratamiento_id' => 1, // Limpieza dental
                'odontologo_id' => 1,
                'asistente_id' => 2,
                'fecha' => Carbon::today()->subDays(30),
                'diagnostico' => 'Acumulación de sarro moderado en sector anterior inferior',
                'descripcion_tratamiento' => 'Profilaxis completa con ultrasonido y pulido. Se realizó fluorización tópica.',
                'pieza_dental' => null,
                'archivos_adjuntos' => null,
                'observaciones' => 'Paciente con buena higiene oral. Control en 6 meses.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'paciente_id' => 6, // Carmen Mamani
                'cita_id' => null,
                'tratamiento_id' => 2, // Consulta general
                'odontologo_id' => 1,
                'asistente_id' => 5, // Enfermera Rosa
                'fecha' => Carbon::today()->subDays(15),
                'diagnostico' => 'Embarazo segundo trimestre. Gingivitis del embarazo leve.',
                'descripcion_tratamiento' => 'Evaluación general. Se indicó técnica de cepillado adecuada y enjuague bucal sin alcohol.',
                'pieza_dental' => null,
                'archivos_adjuntos' => null,
                'observaciones' => 'Solo tratamientos seguros durante embarazo. Control mensual.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

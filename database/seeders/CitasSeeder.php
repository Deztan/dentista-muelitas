<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CitasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('citas')->insert([
            [
                'paciente_id' => 1, // Juan Carlos Pérez
                'odontologo_id' => 1, // Dr. Limachi
                'asistente_id' => 2, // María Elena
                'fecha' => Carbon::today()->addDays(1),
                'hora' => '09:00:00',
                'duracion_minutos' => 30,
                'motivo' => 'Limpieza dental programada',
                'estado' => 'agendada',
                'recordatorio_enviado' => false,
                'recordatorio_fecha' => null,
                'observaciones' => 'Paciente regular',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'paciente_id' => 2, // Ana María Quispe
                'odontologo_id' => 1,
                'asistente_id' => 3, // Pedro Gutiérrez
                'fecha' => Carbon::today()->addDays(2),
                'hora' => '10:30:00',
                'duracion_minutos' => 60,
                'motivo' => 'Consulta general y evaluación',
                'estado' => 'agendada',
                'recordatorio_enviado' => false,
                'recordatorio_fecha' => null,
                'observaciones' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'paciente_id' => 3, // Roberto Mendoza
                'odontologo_id' => 1,
                'asistente_id' => 2,
                'fecha' => Carbon::today()->subDays(5),
                'hora' => '14:00:00',
                'duracion_minutos' => 45,
                'motivo' => 'Extracción dental simple',
                'estado' => 'completada',
                'recordatorio_enviado' => true,
                'recordatorio_fecha' => Carbon::today()->subDays(6)->setTime(10, 0),
                'observaciones' => 'Paciente diabético - se tomaron precauciones',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'paciente_id' => 4, // Patricia Rojas
                'odontologo_id' => 1,
                'asistente_id' => 2,
                'fecha' => Carbon::today()->addDays(3),
                'hora' => '15:30:00',
                'duracion_minutos' => 60,
                'motivo' => 'Resina dental en molar superior',
                'estado' => 'confirmada',
                'recordatorio_enviado' => false,
                'recordatorio_fecha' => null,
                'observaciones' => 'Primera vez en tratamiento con resina',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'paciente_id' => 5, // Luis Gutiérrez
                'odontologo_id' => 1,
                'asistente_id' => 3,
                'fecha' => Carbon::today(),
                'hora' => '11:00:00',
                'duracion_minutos' => 20,
                'motivo' => 'Consulta general',
                'estado' => 'en_curso',
                'recordatorio_enviado' => true,
                'recordatorio_fecha' => Carbon::yesterday()->setTime(18, 0),
                'observaciones' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'paciente_id' => 7, // Miguel Ángel Flores (niño)
                'odontologo_id' => 1,
                'asistente_id' => 2,
                'fecha' => Carbon::today()->addDays(4),
                'hora' => '16:00:00',
                'duracion_minutos' => 20,
                'motivo' => 'Selladores dentales preventivos',
                'estado' => 'agendada',
                'recordatorio_enviado' => false,
                'recordatorio_fecha' => null,
                'observaciones' => 'Paciente pediátrico - viene con madre',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'paciente_id' => 9, // Jorge Sánchez
                'odontologo_id' => 1,
                'asistente_id' => 3,
                'fecha' => Carbon::today()->subDays(2),
                'hora' => '08:30:00',
                'duracion_minutos' => 30,
                'motivo' => 'Limpieza dental',
                'estado' => 'no_asistio',
                'recordatorio_enviado' => true,
                'recordatorio_fecha' => Carbon::today()->subDays(3)->setTime(16, 0),
                'observaciones' => 'No asistió sin aviso previo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

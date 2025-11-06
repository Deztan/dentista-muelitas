<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TratamientosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tratamientos')->insert([
            [
                'nombre' => 'Limpieza dental (profilaxis)',
                'descripcion' => 'Limpieza profunda y eliminación de sarro',
                'precio_base' => 150.00,
                'duracion_minutos' => 30,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Consulta general',
                'descripcion' => 'Evaluación odontológica inicial',
                'precio_base' => 50.00,
                'duracion_minutos' => 20,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Extracción dental simple',
                'descripcion' => 'Extracción de pieza dental sin complicaciones',
                'precio_base' => 200.00,
                'duracion_minutos' => 45,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Extracción de muela del juicio',
                'descripcion' => 'Extracción quirúrgica de tercer molar',
                'precio_base' => 400.00,
                'duracion_minutos' => 90,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Resina dental (obturación)',
                'descripcion' => 'Restauración con resina compuesta fotocurada',
                'precio_base' => 180.00,
                'duracion_minutos' => 60,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Endodoncia (tratamiento de conducto)',
                'descripcion' => 'Tratamiento de conducto radicular',
                'precio_base' => 800.00,
                'duracion_minutos' => 90,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Corona dental de porcelana',
                'descripcion' => 'Corona completa de porcelana sobre metal',
                'precio_base' => 1200.00,
                'duracion_minutos' => 120,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Blanqueamiento dental',
                'descripcion' => 'Blanqueamiento con lámpara LED',
                'precio_base' => 600.00,
                'duracion_minutos' => 60,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Ortodoncia - Consulta inicial',
                'descripcion' => 'Evaluación ortodóncica y plan de tratamiento',
                'precio_base' => 100.00,
                'duracion_minutos' => 30,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Brackets metálicos (instalación completa)',
                'descripcion' => 'Instalación de brackets metálicos en ambas arcadas',
                'precio_base' => 3500.00,
                'duracion_minutos' => 180,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Ajuste de brackets mensual',
                'descripcion' => 'Control y ajuste mensual de ortodoncia',
                'precio_base' => 250.00,
                'duracion_minutos' => 30,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Implante dental',
                'descripcion' => 'Implante de titanio para reemplazo dental',
                'precio_base' => 2500.00,
                'duracion_minutos' => 120,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Radiografía panorámica',
                'descripcion' => 'Radiografía digital de toda la boca',
                'precio_base' => 80.00,
                'duracion_minutos' => 15,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Selladores dentales (por pieza)',
                'descripcion' => 'Sellado de fisuras en molares',
                'precio_base' => 60.00,
                'duracion_minutos' => 20,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Urgencia dental',
                'descripcion' => 'Atención de emergencia fuera de horario',
                'precio_base' => 300.00,
                'duracion_minutos' => 45,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

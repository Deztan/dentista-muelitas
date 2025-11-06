<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MovimientosInventarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('movimientos_inventario')->insert([
            [
                'material_id' => 1, // Resina A2
                'usuario_id' => 1,
                'tipo' => 'entrada',
                'cantidad' => 20.00,
                'costo_unitario' => 85.00,
                'motivo' => 'Compra inicial de stock',
                'referencia' => 'FACTURA-DS-2024-001',
                'fecha' => Carbon::today()->subDays(60),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'material_id' => 1, // Resina A2
                'usuario_id' => 1,
                'tipo' => 'salida',
                'cantidad' => 5.00,
                'costo_unitario' => null,
                'motivo' => 'Uso en tratamientos del mes',
                'referencia' => null,
                'fecha' => Carbon::today()->subDays(30),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'material_id' => 2, // Anestesia
                'usuario_id' => 2,
                'tipo' => 'entrada',
                'cantidad' => 100.00,
                'costo_unitario' => 8.00,
                'motivo' => 'Reposición de stock',
                'referencia' => 'FACTURA-PD-2024-015',
                'fecha' => Carbon::today()->subDays(45),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'material_id' => 2, // Anestesia
                'usuario_id' => 4,
                'tipo' => 'salida',
                'cantidad' => 50.00,
                'costo_unitario' => null,
                'motivo' => 'Consumo en procedimientos',
                'referencia' => null,
                'fecha' => Carbon::today()->subDays(15),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'material_id' => 3, // Guantes látex
                'usuario_id' => 4,
                'tipo' => 'entrada',
                'cantidad' => 10.00,
                'costo_unitario' => 45.00,
                'motivo' => 'Compra mensual',
                'referencia' => 'FACTURA-MP-2024-032',
                'fecha' => Carbon::today()->subDays(20),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'material_id' => 3, // Guantes látex
                'usuario_id' => 5,
                'tipo' => 'salida',
                'cantidad' => 2.00,
                'costo_unitario' => null,
                'motivo' => 'Uso diario en consultorio',
                'referencia' => null,
                'fecha' => Carbon::today()->subDays(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'material_id' => 13, // Brackets
                'usuario_id' => 1,
                'tipo' => 'entrada',
                'cantidad' => 30.00,
                'costo_unitario' => 250.00,
                'motivo' => 'Stock inicial ortodoncia',
                'referencia' => 'FACTURA-OD-2024-008',
                'fecha' => Carbon::today()->subDays(50),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'material_id' => 13, // Brackets
                'usuario_id' => 1,
                'tipo' => 'salida',
                'cantidad' => 10.00,
                'costo_unitario' => null,
                'motivo' => 'Instalación de ortodoncia en pacientes',
                'referencia' => null,
                'fecha' => Carbon::today()->subDays(25),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'material_id' => 5, // Gasas
                'usuario_id' => 2,
                'tipo' => 'ajuste',
                'cantidad' => -1.00,
                'costo_unitario' => null,
                'motivo' => 'Ajuste por inventario físico (paquete dañado)',
                'referencia' => 'AJUSTE-INV-001',
                'fecha' => Carbon::today()->subDays(5),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

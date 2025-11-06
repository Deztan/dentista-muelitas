<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FacturasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('facturas')->insert([
            [
                'paciente_id' => 3, // Roberto Mendoza
                'cita_id' => 3,
                'numero_factura' => 'FACT-2024-001',
                'fecha_emision' => Carbon::today()->subDays(5),
                'fecha_vencimiento' => Carbon::today()->addDays(10),
                'concepto' => 'Extracción dental simple - Pieza #16',
                'subtotal' => 200.00,
                'descuento' => 0.00,
                'total' => 200.00,
                'monto_pagado' => 200.00,
                'estado' => 'pagada',
                'metodo_pago' => 'efectivo',
                'fecha_pago' => Carbon::today()->subDays(5),
                'observaciones' => 'Pago completo en efectivo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'paciente_id' => 1, // Juan Carlos Pérez
                'cita_id' => null,
                'numero_factura' => 'FACT-2024-002',
                'fecha_emision' => Carbon::today()->subDays(30),
                'fecha_vencimiento' => Carbon::today()->subDays(15),
                'concepto' => 'Limpieza dental (profilaxis)',
                'subtotal' => 150.00,
                'descuento' => 0.00,
                'total' => 150.00,
                'monto_pagado' => 150.00,
                'estado' => 'pagada',
                'metodo_pago' => 'tarjeta',
                'fecha_pago' => Carbon::today()->subDays(30),
                'observaciones' => 'Pago con tarjeta de débito',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'paciente_id' => 4, // Patricia Rojas
                'cita_id' => 4,
                'numero_factura' => 'FACT-2024-003',
                'fecha_emision' => Carbon::today(),
                'fecha_vencimiento' => Carbon::today()->addDays(15),
                'concepto' => 'Resina dental en molar superior',
                'subtotal' => 180.00,
                'descuento' => 0.00,
                'total' => 180.00,
                'monto_pagado' => 0.00,
                'estado' => 'pendiente',
                'metodo_pago' => null,
                'fecha_pago' => null,
                'observaciones' => 'Tratamiento programado para próxima semana',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'paciente_id' => 8, // Sofía Vargas
                'cita_id' => null,
                'numero_factura' => 'FACT-2024-004',
                'fecha_emision' => Carbon::today()->subDays(10),
                'fecha_vencimiento' => Carbon::today()->addDays(5),
                'concepto' => 'Blanqueamiento dental con lámpara LED',
                'subtotal' => 600.00,
                'descuento' => 60.00,
                'total' => 540.00,
                'monto_pagado' => 300.00,
                'estado' => 'parcial',
                'metodo_pago' => 'transferencia',
                'fecha_pago' => Carbon::today()->subDays(10),
                'observaciones' => 'Pago parcial (300 Bs). Saldo pendiente: 240 Bs. Descuento por promoción 10%.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

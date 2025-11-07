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
                'tratamiento_id' => 1, // Limpieza dental
                'fecha_emision' => Carbon::today()->subDays(5),
                'monto_total' => 200.00,
                'monto_pagado' => 200.00,
                'saldo_pendiente' => 0.00,
                'metodo_pago' => 'efectivo',
                'estado' => 'pagada',
                'observaciones' => 'Pago completo en efectivo. Tratamiento completado satisfactoriamente.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'paciente_id' => 1, // Juan Carlos Pérez
                'tratamiento_id' => 2, // Extracción dental
                'fecha_emision' => Carbon::today()->subDays(30),
                'monto_total' => 150.00,
                'monto_pagado' => 150.00,
                'saldo_pendiente' => 0.00,
                'metodo_pago' => 'tarjeta',
                'estado' => 'pagada',
                'observaciones' => 'Pago con tarjeta de débito. Sin complicaciones.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'paciente_id' => 4, // Patricia Rojas
                'tratamiento_id' => 3, // Resina dental
                'fecha_emision' => Carbon::today(),
                'monto_total' => 180.00,
                'monto_pagado' => 0.00,
                'saldo_pendiente' => 180.00,
                'metodo_pago' => null,
                'estado' => 'pendiente',
                'observaciones' => 'Tratamiento programado. Pendiente de pago.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'paciente_id' => 8, // Sofía Vargas
                'tratamiento_id' => 4, // Blanqueamiento dental
                'fecha_emision' => Carbon::today()->subDays(10),
                'monto_total' => 540.00,
                'monto_pagado' => 300.00,
                'saldo_pendiente' => 240.00,
                'metodo_pago' => 'transferencia',
                'estado' => 'pendiente',
                'observaciones' => 'Pago parcial de 300 Bs por transferencia bancaria. Saldo pendiente: 240 Bs.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'paciente_id' => 2, // María García
                'tratamiento_id' => 5, // Endodoncia
                'fecha_emision' => Carbon::today()->subDays(15),
                'monto_total' => 800.00,
                'monto_pagado' => 400.00,
                'saldo_pendiente' => 400.00,
                'metodo_pago' => 'qr',
                'estado' => 'pendiente',
                'observaciones' => 'Pago inicial de 400 Bs mediante QR. Próximo pago acordado para fin de mes.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'paciente_id' => 6, // Ana Martínez
                'tratamiento_id' => 6, // Ortodoncia mensual
                'fecha_emision' => Carbon::today()->subDays(2),
                'monto_total' => 350.00,
                'monto_pagado' => 350.00,
                'saldo_pendiente' => 0.00,
                'metodo_pago' => 'efectivo',
                'estado' => 'pagada',
                'observaciones' => 'Cuota mensual de ortodoncia. Próxima cita en 30 días.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

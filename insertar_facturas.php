<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

// Limpiar tabla de facturas
DB::table('facturas')->truncate();

// Insertar facturas relacionadas con tratamientos
$facturas = [
    [
        'paciente_id' => 3, // Roberto Mendoza
        'tratamiento_id' => 1, // Limpieza dental
        'fecha_emision' => Carbon::today()->subDays(5)->format('Y-m-d'),
        'monto_total' => 200.00,
        'monto_pagado' => 200.00,
        'saldo_pendiente' => 0.00,
        'metodo_pago' => 'efectivo',
        'estado' => 'pagada',
        'observaciones' => 'Pago completo en efectivo. Limpieza dental completada satisfactoriamente.',
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'paciente_id' => 1, // Juan Carlos Pérez
        'tratamiento_id' => 2, // Extracción dental
        'fecha_emision' => Carbon::today()->subDays(30)->format('Y-m-d'),
        'monto_total' => 150.00,
        'monto_pagado' => 150.00,
        'saldo_pendiente' => 0.00,
        'metodo_pago' => 'tarjeta',
        'estado' => 'pagada',
        'observaciones' => 'Pago con tarjeta de débito. Extracción sin complicaciones.',
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'paciente_id' => 4, // Patricia Rojas
        'tratamiento_id' => 3, // Resina dental
        'fecha_emision' => Carbon::today()->format('Y-m-d'),
        'monto_total' => 250.00,
        'monto_pagado' => 0.00,
        'saldo_pendiente' => 250.00,
        'metodo_pago' => null,
        'estado' => 'pendiente',
        'observaciones' => 'Tratamiento de resina programado. Pendiente de pago.',
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'paciente_id' => 8, // Sofía Vargas
        'tratamiento_id' => 4, // Blanqueamiento dental
        'fecha_emision' => Carbon::today()->subDays(10)->format('Y-m-d'),
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
        'fecha_emision' => Carbon::today()->subDays(15)->format('Y-m-d'),
        'monto_total' => 800.00,
        'monto_pagado' => 400.00,
        'saldo_pendiente' => 400.00,
        'metodo_pago' => 'qr',
        'estado' => 'pendiente',
        'observaciones' => 'Pago inicial de 400 Bs mediante QR. Tratamiento de conducto en progreso. Próximo pago acordado para fin de mes.',
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'paciente_id' => 6, // Ana Martínez
        'tratamiento_id' => 6, // Ortodoncia mensual
        'fecha_emision' => Carbon::today()->subDays(2)->format('Y-m-d'),
        'monto_total' => 350.00,
        'monto_pagado' => 350.00,
        'saldo_pendiente' => 0.00,
        'metodo_pago' => 'efectivo',
        'estado' => 'pagada',
        'observaciones' => 'Cuota mensual de ortodoncia pagada. Ajuste de brackets realizado. Próxima cita en 30 días.',
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'paciente_id' => 5, // Luis Ramírez
        'tratamiento_id' => 7, // Corona dental
        'fecha_emision' => Carbon::today()->subDays(7)->format('Y-m-d'),
        'monto_total' => 1200.00,
        'monto_pagado' => 600.00,
        'saldo_pendiente' => 600.00,
        'metodo_pago' => 'tarjeta',
        'estado' => 'pendiente',
        'observaciones' => 'Anticipo del 50% para corona de porcelana. Molde tomado, en espera de fabricación.',
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'paciente_id' => 7, // Carmen Flores
        'tratamiento_id' => 8, // Implante dental
        'fecha_emision' => Carbon::today()->subDays(20)->format('Y-m-d'),
        'monto_total' => 3500.00,
        'monto_pagado' => 1500.00,
        'saldo_pendiente' => 2000.00,
        'metodo_pago' => 'transferencia',
        'estado' => 'pendiente',
        'observaciones' => 'Primera fase del implante completada. Pago inicial de 1500 Bs. Siguiente fase en 3 meses.',
        'created_at' => now(),
        'updated_at' => now(),
    ],
];

DB::table('facturas')->insert($facturas);

echo "✅ Se insertaron " . count($facturas) . " facturas exitosamente.\n";

// Mostrar las facturas insertadas
$facturasInsertadas = DB::table('facturas')
    ->join('pacientes', 'facturas.paciente_id', '=', 'pacientes.id')
    ->join('tratamientos', 'facturas.tratamiento_id', '=', 'tratamientos.id')
    ->select(
        'facturas.id',
        'pacientes.nombre_completo as paciente',
        'tratamientos.nombre as tratamiento',
        'facturas.monto_total',
        'facturas.monto_pagado',
        'facturas.saldo_pendiente',
        'facturas.estado'
    )
    ->get();

echo "\n📋 Facturas insertadas:\n";
echo str_repeat('-', 100) . "\n";
foreach ($facturasInsertadas as $f) {
    echo sprintf(
        "#%04d | %s | %s | Total: Bs %.2f | Pagado: Bs %.2f | Saldo: Bs %.2f | %s\n",
        $f->id,
        str_pad(substr($f->paciente, 0, 25), 25),
        str_pad(substr($f->tratamiento, 0, 20), 20),
        $f->monto_total,
        $f->monto_pagado,
        $f->saldo_pendiente,
        strtoupper($f->estado)
    );
}
echo str_repeat('-', 100) . "\n";

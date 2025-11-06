<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Orden de ejecución de seeders (respetando relaciones de llaves foráneas)
        $this->call([
            UsuariosSeeder::class,        // 1. Usuarios (sin dependencias)
            PacientesSeeder::class,        // 2. Pacientes (sin dependencias)
            TratamientosSeeder::class,     // 3. Tratamientos (sin dependencias)
            MaterialesSeeder::class,       // 4. Materiales (sin dependencias)
            CitasSeeder::class,            // 5. Citas (depende de pacientes y usuarios)
            ExpedientesSeeder::class,      // 6. Expedientes (depende de pacientes, usuarios, citas, tratamientos)
            FacturasSeeder::class,         // 7. Facturas (depende de pacientes y citas)
            MovimientosInventarioSeeder::class, // 8. Movimientos inventario (depende de materiales y usuarios)
        ]);
    }
}

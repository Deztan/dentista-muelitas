<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('usuarios')->insert([
            // GERENTE Y DUEÑO - Dr. Limachi (único con acceso a administrar usuarios)
            [
                'nombre_completo' => 'Dr. Carlos Limachi Quispe',
                'email' => 'dr.limachi@muelitas.com',
                'password' => Hash::make('DrLimachi2024!'),
                'telefono' => '70123457',
                'rol' => 'gerente',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // ODONTÓLOGO - Doctor contratado que atiende pacientes
            [
                'nombre_completo' => 'Dr. Pedro Vargas Rojas',
                'email' => 'dr.vargas@muelitas.com',
                'password' => Hash::make('PedroVargas2024!'),
                'telefono' => '71345678',
                'rol' => 'odontologo',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // ASISTENTES DIRECTOS
            [
                'nombre_completo' => 'María Elena Condori Mamani',
                'email' => 'asistente1@muelitas.com',
                'password' => Hash::make('Maria2024*'),
                'telefono' => '72345678',
                'rol' => 'asistente_directo',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_completo' => 'Juan Carlos Quispe López',
                'email' => 'asistente2@muelitas.com',
                'password' => Hash::make('JuanCarlos2024*'),
                'telefono' => '73456789',
                'rol' => 'asistente_directo',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // RECEPCIONISTA
            [
                'nombre_completo' => 'Ana Patricia Flores Choque',
                'email' => 'recepcion@muelitas.com',
                'password' => Hash::make('Recepcion2024$'),
                'telefono' => '75678901',
                'rol' => 'recepcionista',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // ENFERMERA
            [
                'nombre_completo' => 'Rosa Maritza Ticona López',
                'email' => 'enfermera@muelitas.com',
                'password' => Hash::make('Enfermera2024%'),
                'telefono' => '76789012',
                'rol' => 'enfermera',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

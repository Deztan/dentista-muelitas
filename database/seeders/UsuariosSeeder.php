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
            [
                'nombre_completo' => 'Dr. Carlos Limachi Quispe',
                'email' => 'dr.limachi@muelitas.com',
                'password' => Hash::make('password123'),
                'telefono' => '70123456',
                'rol' => 'gerente_odontologo',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_completo' => 'María Elena Condori Mamani',
                'email' => 'asistente1@muelitas.com',
                'password' => Hash::make('password123'),
                'telefono' => '72345678',
                'rol' => 'asistente_directo',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_completo' => 'Pedro Gutiérrez Ramos',
                'email' => 'asistente2@muelitas.com',
                'password' => Hash::make('password123'),
                'telefono' => '73456789',
                'rol' => 'asistente_directo',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_completo' => 'Ana Patricia Flores Choque',
                'email' => 'recepcion@muelitas.com',
                'password' => Hash::make('password123'),
                'telefono' => '75678901',
                'rol' => 'recepcionista',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre_completo' => 'Rosa Maritza Ticona López',
                'email' => 'enfermera@muelitas.com',
                'password' => Hash::make('password123'),
                'telefono' => '76789012',
                'rol' => 'enfermera',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

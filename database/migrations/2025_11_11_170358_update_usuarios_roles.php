<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Primero agregamos temporalmente los nuevos valores al ENUM existente
        DB::statement("ALTER TABLE usuarios MODIFY COLUMN rol ENUM('gerente_odontologo', 'gerente', 'odontologo', 'asistente_directo', 'recepcionista', 'enfermera') DEFAULT 'recepcionista'");
        
        // Actualizamos los registros existentes de gerente_odontologo a gerente
        DB::table('usuarios')
            ->where('rol', 'gerente_odontologo')
            ->update(['rol' => 'gerente']);
            
        // Ahora eliminamos el valor antiguo del ENUM
        DB::statement("ALTER TABLE usuarios MODIFY COLUMN rol ENUM('gerente', 'odontologo', 'asistente_directo', 'recepcionista', 'enfermera') DEFAULT 'recepcionista'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revertir los cambios
        DB::table('usuarios')
            ->where('rol', 'gerente')
            ->update(['rol' => 'gerente_odontologo']);
            
        DB::statement("ALTER TABLE usuarios MODIFY COLUMN rol ENUM('gerente_odontologo', 'asistente_directo', 'recepcionista', 'enfermera') DEFAULT 'recepcionista'");
    }
};

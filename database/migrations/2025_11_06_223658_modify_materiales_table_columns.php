<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('materiales', function (Blueprint $table) {
            // Renombrar columnas a nombres más descriptivos y semánticos
            $table->renameColumn('unidad', 'unidad_medida');
            $table->renameColumn('costo_unitario', 'precio_unitario');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('materiales', function (Blueprint $table) {
            // Revertir los cambios
            $table->renameColumn('unidad_medida', 'unidad');
            $table->renameColumn('precio_unitario', 'costo_unitario');
        });
    }
};

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
        Schema::create('expedientes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->constrained('pacientes')->onDelete('cascade');
            $table->foreignId('cita_id')->nullable()->constrained('citas')->onDelete('set null');
            $table->foreignId('tratamiento_id')->nullable()->constrained('tratamientos')->onDelete('set null');
            $table->foreignId('odontologo_id')->nullable()->constrained('usuarios')->onDelete('set null')->comment('Odontólogo que realizó el tratamiento');
            $table->foreignId('asistente_id')->nullable()->constrained('usuarios')->onDelete('set null')->comment('Asistente o enfermera presente');
            $table->date('fecha');
            $table->text('diagnostico')->nullable();
            $table->text('descripcion_tratamiento')->nullable();
            $table->string('pieza_dental', 10)->nullable()->comment('Número de diente');
            $table->text('archivos_adjuntos')->nullable()->comment('JSON con rutas de radiografías/fotos');
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expedientes');
    }
};

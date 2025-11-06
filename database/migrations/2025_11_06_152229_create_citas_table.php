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
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->constrained('pacientes')->onDelete('cascade');
            $table->foreignId('odontologo_id')->nullable()->constrained('usuarios')->onDelete('set null')->comment('Usuario gerente/odontólogo');
            $table->foreignId('asistente_id')->nullable()->constrained('usuarios')->onDelete('set null')->comment('Asistente directo asignado');
            $table->date('fecha');
            $table->time('hora');
            $table->unsignedInteger('duracion_minutos')->default(30);
            $table->text('motivo')->nullable();
            $table->enum('estado', ['agendada', 'confirmada', 'en_curso', 'completada', 'cancelada', 'no_asistio'])->default('agendada');
            $table->boolean('recordatorio_enviado')->default(false);
            $table->timestamp('recordatorio_fecha')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();

            $table->index(['fecha', 'hora']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};

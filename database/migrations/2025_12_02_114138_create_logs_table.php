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
        Schema::create('logs', function (Blueprint $table) {
            $table->id();

            // RFC 5424: Severity Levels (0=Emergency, 7=Debug)
            $table->enum('level', ['EMERGENCY', 'ALERT', 'CRITICAL', 'ERROR', 'WARNING', 'NOTICE', 'INFO', 'DEBUG'])->default('INFO');

            // Timestamp ISO 8601 con microsegundos
            $table->timestamp('timestamp', 6);

            // Información del usuario (quien ejecuta la acción)
            $table->foreignId('usuario_id')->nullable()->constrained('usuarios')->onDelete('set null');
            $table->string('usuario_nombre')->nullable(); // Cache del nombre por si se elimina
            $table->string('usuario_rol')->nullable();

            // Información de la sesión
            $table->string('session_id')->nullable();
            $table->string('ip_address', 45)->nullable(); // IPv6 support
            $table->string('user_agent')->nullable();

            // Acción ejecutada (CRUD + custom)
            $table->enum('action', ['CREATE', 'READ', 'UPDATE', 'DELETE', 'LOGIN', 'LOGOUT', 'EXPORT', 'IMPORT', 'PRINT', 'SEND', 'OTHER'])->default('OTHER');

            // Módulo/Recurso afectado
            $table->string('module', 50); // pacientes, citas, usuarios, etc.
            $table->string('resource_type', 50)->nullable(); // Tipo de recurso (model name)
            $table->string('resource_id')->nullable(); // ID del recurso afectado

            // Página/Ruta donde ocurrió
            $table->string('page', 255)->nullable(); // URL/ruta
            $table->string('method', 10)->nullable(); // GET, POST, PUT, DELETE

            // Mensaje descriptivo
            $table->text('message'); // Descripción legible de la acción
            $table->text('detail')->nullable(); // Detalles adicionales

            // Datos del cambio (para auditoría)
            $table->json('old_data')->nullable(); // Estado anterior
            $table->json('new_data')->nullable(); // Estado nuevo
            $table->json('metadata')->nullable(); // Datos adicionales contextuales

            // Resultado de la operación
            $table->enum('status', ['SUCCESS', 'FAILED', 'PENDING'])->default('SUCCESS');
            $table->text('error_message')->nullable(); // Si falló, qué error

            // Performance monitoring
            $table->integer('execution_time_ms')->nullable(); // Tiempo de ejecución en ms

            // Compliance & Security
            $table->boolean('is_sensitive')->default(false); // Marca datos sensibles
            $table->string('compliance_tag')->nullable(); // GDPR, HIPAA, etc.

            // Índices para optimizar búsquedas
            $table->index(['level', 'timestamp']);
            $table->index(['usuario_id', 'timestamp']);
            $table->index(['module', 'action', 'timestamp']);
            $table->index(['resource_type', 'resource_id']);
            $table->index(['session_id']);
            $table->index('timestamp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};

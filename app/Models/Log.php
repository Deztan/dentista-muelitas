<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class Log extends Model
{
    // RFC 5424 Severity Levels
    const EMERGENCY = 'EMERGENCY'; // Sistema inutilizable
    const ALERT     = 'ALERT';     // Se debe tomar acción inmediatamente
    const CRITICAL  = 'CRITICAL';  // Condiciones críticas
    const ERROR     = 'ERROR';     // Errores
    const WARNING   = 'WARNING';   // Advertencias
    const NOTICE    = 'NOTICE';    // Normal pero significativo
    const INFO      = 'INFO';      // Informacional
    const DEBUG     = 'DEBUG';     // Debugging

    // Acciones estándar CRUD
    const ACTION_CREATE = 'CREATE';
    const ACTION_READ   = 'READ';
    const ACTION_UPDATE = 'UPDATE';
    const ACTION_DELETE = 'DELETE';
    const ACTION_LOGIN  = 'LOGIN';
    const ACTION_LOGOUT = 'LOGOUT';
    const ACTION_EXPORT = 'EXPORT';
    const ACTION_IMPORT = 'IMPORT';
    const ACTION_PRINT  = 'PRINT';
    const ACTION_SEND   = 'SEND';
    const ACTION_OTHER  = 'OTHER';

    public $timestamps = false; // Desactivar created_at y updated_at

    protected $fillable = [
        'level',
        'timestamp',
        'usuario_id',
        'usuario_nombre',
        'usuario_rol',
        'session_id',
        'ip_address',
        'user_agent',
        'action',
        'module',
        'resource_type',
        'resource_id',
        'page',
        'method',
        'message',
        'detail',
        'old_data',
        'new_data',
        'metadata',
        'status',
        'error_message',
        'execution_time_ms',
        'is_sensitive',
        'compliance_tag'
    ];

    protected $casts = [
        'timestamp' => 'datetime',
        'old_data' => 'array',
        'new_data' => 'array',
        'metadata' => 'array',
        'is_sensitive' => 'boolean',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    /**
     * Registrar una acción en el log siguiendo RFC 5424 y estándares de la industria
     * 
     * @param string $action Acción ejecutada (CREATE, UPDATE, DELETE, etc.)
     * @param string $module Módulo del sistema (pacientes, citas, etc.)
     * @param string $message Mensaje descriptivo
     * @param array $options Opciones adicionales
     * @return self
     */
    public static function registrar(
        string $action,
        string $module,
        string $message,
        array $options = []
    ) {
        $startTime = microtime(true);

        $usuario = Auth::user();

        $logData = [
            // Timestamp ISO 8601 con microsegundos
            'timestamp' => now()->format('Y-m-d H:i:s.u'),

            // Level (default INFO)
            'level' => $options['level'] ?? self::INFO,

            // Usuario
            'usuario_id' => $usuario?->id,
            'usuario_nombre' => $usuario?->nombre_completo,
            'usuario_rol' => $usuario?->rol,

            // Sesión
            'session_id' => session()->getId(),
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),

            // Acción
            'action' => strtoupper($action),
            'module' => $module,
            'resource_type' => $options['resource_type'] ?? null,
            'resource_id' => $options['resource_id'] ?? null,

            // Página
            'page' => Request::fullUrl(),
            'method' => Request::method(),

            // Mensaje
            'message' => $message,
            'detail' => $options['detail'] ?? null,

            // Datos
            'old_data' => $options['old_data'] ?? null,
            'new_data' => $options['new_data'] ?? null,
            'metadata' => array_merge([
                'environment' => app()->environment(),
                'app_version' => config('app.version', '1.0.0'),
            ], $options['metadata'] ?? []),

            // Estado
            'status' => $options['status'] ?? 'SUCCESS',
            'error_message' => $options['error_message'] ?? null,

            // Performance
            'execution_time_ms' => null, // Se calcula después

            // Compliance
            'is_sensitive' => $options['is_sensitive'] ?? false,
            'compliance_tag' => $options['compliance_tag'] ?? null,
        ];

        $log = self::create($logData);

        // Calcular tiempo de ejecución
        $executionTime = (microtime(true) - $startTime) * 1000;
        $log->update(['execution_time_ms' => round($executionTime, 2)]);

        return $log;
    }

    /**
     * Logs específicos por tipo de acción (helpers)
     */
    public static function crear($module, $resourceId, $message, $newData = null, $options = [])
    {
        return self::registrar(
            self::ACTION_CREATE,
            $module,
            $message,
            array_merge($options, [
                'resource_id' => $resourceId,
                'new_data' => $newData,
                'level' => self::INFO,
            ])
        );
    }

    public static function editar($module, $resourceId, $message, $oldData = null, $newData = null, $options = [])
    {
        return self::registrar(
            self::ACTION_UPDATE,
            $module,
            $message,
            array_merge($options, [
                'resource_id' => $resourceId,
                'old_data' => $oldData,
                'new_data' => $newData,
                'level' => self::NOTICE,
            ])
        );
    }

    public static function eliminar($module, $resourceId, $message, $oldData = null, $options = [])
    {
        return self::registrar(
            self::ACTION_DELETE,
            $module,
            $message,
            array_merge($options, [
                'resource_id' => $resourceId,
                'old_data' => $oldData,
                'level' => self::WARNING,
            ])
        );
    }

    public static function error($module, $message, $errorMessage, $options = [])
    {
        return self::registrar(
            self::ACTION_OTHER,
            $module,
            $message,
            array_merge($options, [
                'level' => self::ERROR,
                'status' => 'FAILED',
                'error_message' => $errorMessage,
            ])
        );
    }

    public static function login($usuario)
    {
        return self::registrar(
            self::ACTION_LOGIN,
            'auth',
            "Usuario {$usuario->nombre_completo} inició sesión",
            [
                'resource_id' => $usuario->id,
                'level' => self::INFO,
                'metadata' => [
                    'login_method' => 'password',
                ],
            ]
        );
    }

    public static function logout($usuario)
    {
        return self::registrar(
            self::ACTION_LOGOUT,
            'auth',
            "Usuario {$usuario->nombre_completo} cerró sesión",
            [
                'resource_id' => $usuario->id,
                'level' => self::INFO,
            ]
        );
    }
}

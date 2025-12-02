<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use App\Models\Log;
use ZipArchive;

class BackupController extends Controller
{
    /**
     * Listar todos los backups disponibles
     */
    public function index()
    {
        $backupPath = storage_path('app/backups');
        $backups = [];

        if (is_dir($backupPath)) {
            $files = array_diff(scandir($backupPath), ['.', '..']);

            foreach ($files as $file) {
                $filepath = $backupPath . '/' . $file;
                if (is_file($filepath) && (str_ends_with($file, '.sql') || str_ends_with($file, '.zip'))) {
                    $backups[] = [
                        'filename' => $file,
                        'size' => filesize($filepath),
                        'size_mb' => number_format(filesize($filepath) / 1024 / 1024, 2),
                        'date' => date('Y-m-d H:i:s', filemtime($filepath)),
                        'compressed' => str_ends_with($file, '.zip')
                    ];
                }
            }

            // Ordenar por fecha descendente
            usort($backups, function ($a, $b) {
                return strtotime($b['date']) - strtotime($a['date']);
            });
        }

        // Registrar acceso a lista de backups
        Log::registrar(
            'READ',
            'backups',
            'Acceso a lista de backups',
            [
                'level' => Log::INFO,
                'resource_type' => 'DatabaseBackup',
                'metadata' => [
                    'total_backups' => count($backups)
                ]
            ]
        );

        return view('backups.index', compact('backups'));
    }

    /**
     * Crear nuevo backup
     */
    public function store(Request $request)
    {
        $compress = $request->input('compress', false);

        try {
            // Registrar inicio de creación
            Log::registrar(
                'CREATE',
                'backups',
                'Iniciando creación de backup',
                [
                    'level' => Log::NOTICE,
                    'resource_type' => 'DatabaseBackup',
                    'metadata' => [
                        'compressed' => $compress,
                        'database' => config('database.connections.mysql.database')
                    ]
                ]
            );

            if ($compress) {
                Artisan::call('db:backup', ['--compress' => true]);
            } else {
                Artisan::call('db:backup');
            }

            // Registrar éxito
            Log::registrar(
                'CREATE',
                'backups',
                'Backup creado exitosamente',
                [
                    'level' => Log::INFO,
                    'resource_type' => 'DatabaseBackup',
                    'metadata' => [
                        'compressed' => $compress,
                        'output' => Artisan::output()
                    ]
                ]
            );

            return redirect()->route('backups.index')
                ->with('success', 'Backup creado exitosamente');
        } catch (\Exception $e) {
            Log::registrar(
                'CREATE',
                'backups',
                'Error al crear backup',
                [
                    'level' => Log::ERROR,
                    'resource_type' => 'DatabaseBackup',
                    'status' => 'FAILED',
                    'error_message' => $e->getMessage(),
                    'metadata' => [
                        'compressed' => $compress,
                        'exception' => get_class($e)
                    ]
                ]
            );

            return redirect()->route('backups.index')
                ->with('error', 'Error al crear backup: ' . $e->getMessage());
        }
    }

    /**
     * Descargar backup
     */
    public function download($filename)
    {
        $filepath = storage_path('app/backups/' . $filename);

        if (!file_exists($filepath)) {
            // Registrar intento fallido
            Log::registrar(
                'EXPORT',
                'backups',
                "Intento de descarga de backup inexistente: {$filename}",
                [
                    'level' => Log::WARNING,
                    'resource_type' => 'DatabaseBackup',
                    'status' => 'FAILED',
                    'metadata' => ['filename' => $filename]
                ]
            );

            abort(404, 'Backup no encontrado');
        }

        // Registrar descarga exitosa
        Log::registrar(
            'EXPORT',
            'backups',
            "Backup descargado: {$filename}",
            [
                'level' => Log::INFO,
                'resource_type' => 'DatabaseBackup',
                'metadata' => [
                    'filename' => $filename,
                    'size_mb' => number_format(filesize($filepath) / 1024 / 1024, 2),
                    'compressed' => str_ends_with($filename, '.zip')
                ],
                'is_sensitive' => true
            ]
        );

        return response()->download($filepath);
    }

    /**
     * Restaurar desde backup
     */
    public function restore(Request $request, $filename)
    {
        $filepath = storage_path('app/backups/' . $filename);

        if (!file_exists($filepath)) {
            // Registrar intento fallido
            Log::registrar(
                'IMPORT',
                'backups',
                "Intento de restaurar backup inexistente: {$filename}",
                [
                    'level' => Log::WARNING,
                    'resource_type' => 'DatabaseBackup',
                    'status' => 'FAILED',
                    'metadata' => ['filename' => $filename]
                ]
            );

            return redirect()->route('backups.index')
                ->with('error', 'Backup no encontrado');
        }

        try {
            // Registrar inicio de restauración
            Log::registrar(
                'IMPORT',
                'backups',
                "Iniciando restauración desde backup: {$filename}",
                [
                    'level' => Log::WARNING,
                    'resource_type' => 'DatabaseBackup',
                    'metadata' => [
                        'filename' => $filename,
                        'size_mb' => number_format(filesize($filepath) / 1024 / 1024, 2),
                        'database' => config('database.connections.mysql.database')
                    ],
                    'is_sensitive' => true,
                    'compliance_tag' => 'DATA_RESTORATION'
                ]
            );

            // Ejecutar comando de restauración
            Artisan::call('db:restore', ['file' => $filename]);

            // Registrar éxito
            Log::registrar(
                'IMPORT',
                'backups',
                "Base de datos restaurada exitosamente desde: {$filename}",
                [
                    'level' => Log::NOTICE,
                    'resource_type' => 'DatabaseBackup',
                    'metadata' => [
                        'filename' => $filename,
                        'output' => Artisan::output()
                    ],
                    'is_sensitive' => true,
                    'compliance_tag' => 'DATA_RESTORATION'
                ]
            );

            return redirect()->route('backups.index')
                ->with('success', 'Base de datos restaurada exitosamente');
        } catch (\Exception $e) {
            Log::registrar(
                'IMPORT',
                'backups',
                "Error al restaurar backup: {$filename}",
                [
                    'level' => Log::CRITICAL,
                    'resource_type' => 'DatabaseBackup',
                    'status' => 'FAILED',
                    'error_message' => $e->getMessage(),
                    'metadata' => [
                        'filename' => $filename,
                        'exception' => get_class($e)
                    ],
                    'is_sensitive' => true
                ]
            );

            return redirect()->route('backups.index')
                ->with('error', 'Error al restaurar backup: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar backup
     */
    public function destroy($filename)
    {
        $filepath = storage_path('app/backups/' . $filename);

        if (!file_exists($filepath)) {
            // Registrar intento fallido
            Log::registrar(
                'DELETE',
                'backups',
                "Intento de eliminar backup inexistente: {$filename}",
                [
                    'level' => Log::WARNING,
                    'resource_type' => 'DatabaseBackup',
                    'status' => 'FAILED',
                    'metadata' => ['filename' => $filename]
                ]
            );

            return redirect()->route('backups.index')
                ->with('error', 'Backup no encontrado');
        }

        try {
            $size_mb = number_format(filesize($filepath) / 1024 / 1024, 2);

            unlink($filepath);

            // Registrar eliminación exitosa
            Log::registrar(
                'DELETE',
                'backups',
                "Backup eliminado: {$filename}",
                [
                    'level' => Log::WARNING,
                    'resource_type' => 'DatabaseBackup',
                    'metadata' => [
                        'filename' => $filename,
                        'size_mb' => $size_mb,
                        'compressed' => str_ends_with($filename, '.zip')
                    ]
                ]
            );

            return redirect()->route('backups.index')
                ->with('success', 'Backup eliminado exitosamente');
        } catch (\Exception $e) {
            Log::registrar(
                'DELETE',
                'backups',
                "Error al eliminar backup: {$filename}",
                [
                    'level' => Log::ERROR,
                    'resource_type' => 'DatabaseBackup',
                    'status' => 'FAILED',
                    'error_message' => $e->getMessage(),
                    'metadata' => [
                        'filename' => $filename,
                        'exception' => get_class($e)
                    ]
                ]
            );

            return redirect()->route('backups.index')
                ->with('error', 'Error al eliminar backup: ' . $e->getMessage());
        }
    }
}

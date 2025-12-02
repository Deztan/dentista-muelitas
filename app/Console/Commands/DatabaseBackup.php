<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\Log;

class DatabaseBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup {--compress : Comprimir el backup en .zip}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crear backup de la base de datos MySQL';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔄 Iniciando backup de la base de datos...');

        $database = config('database.connections.mysql.database');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        $host = config('database.connections.mysql.host');
        $port = config('database.connections.mysql.port', 3306);

        // Crear directorio de backups si no existe
        $backupPath = storage_path('app/backups');
        if (!file_exists($backupPath)) {
            mkdir($backupPath, 0755, true);
        }

        // Nombre del archivo con timestamp
        $timestamp = now()->format('Y-m-d_His');
        $filename = "backup_{$database}_{$timestamp}.sql";
        $filepath = $backupPath . '/' . $filename;

        // Ruta de mysqldump (XAMPP)
        $mysqldumpPath = 'C:\xampp\mysql\bin\mysqldump.exe';

        // Si no existe en XAMPP, buscar en PATH
        if (!file_exists($mysqldumpPath)) {
            $mysqldumpPath = 'mysqldump';
        }

        // Construir comando mysqldump
        $command = sprintf(
            '"%s" --user=%s --password=%s --host=%s --port=%s --single-transaction --routines --triggers --events %s > "%s"',
            $mysqldumpPath,
            $username,
            $password,
            $host,
            $port,
            $database,
            $filepath
        );

        // Ejecutar backup
        $this->info('📦 Exportando base de datos...');
        exec($command, $output, $return);

        if ($return !== 0 || !file_exists($filepath)) {
            $this->error('❌ Error al crear el backup');

            // Log del error
            Log::error('backups', 'Error al crear backup de base de datos', 'No se pudo ejecutar mysqldump');

            return Command::FAILURE;
        }

        $filesize = number_format(filesize($filepath) / 1024 / 1024, 2);
        $this->info("✅ Backup creado exitosamente: {$filename}");
        $this->info("📊 Tamaño: {$filesize} MB");

        // Comprimir si se solicita
        if ($this->option('compress')) {
            $this->info('🗜️ Comprimiendo backup...');

            $zipFilename = "backup_{$database}_{$timestamp}.zip";
            $zipFilepath = $backupPath . '/' . $zipFilename;

            $zip = new \ZipArchive();
            if ($zip->open($zipFilepath, \ZipArchive::CREATE) === TRUE) {
                $zip->addFile($filepath, $filename);
                $zip->close();

                // Eliminar archivo SQL sin comprimir
                unlink($filepath);

                $zipSize = number_format(filesize($zipFilepath) / 1024 / 1024, 2);
                $this->info("✅ Backup comprimido: {$zipFilename}");
                $this->info("📊 Tamaño comprimido: {$zipSize} MB");

                $finalFile = $zipFilename;
            } else {
                $this->warn('⚠️ No se pudo comprimir el backup');
                $finalFile = $filename;
            }
        } else {
            $finalFile = $filename;
        }

        // Registrar en logs
        Log::registrar(
            'EXPORT',
            'backups',
            "Backup de base de datos creado: {$finalFile}",
            [
                'level' => Log::INFO,
                'resource_type' => 'DatabaseBackup',
                'resource_id' => $timestamp,
                'metadata' => [
                    'filename' => $finalFile,
                    'size_mb' => $filesize,
                    'database' => $database,
                    'compressed' => $this->option('compress')
                ]
            ]
        );

        $this->newLine();
        $this->info("📁 Ubicación: storage/app/backups/{$finalFile}");
        $this->newLine();

        return Command::SUCCESS;
    }
}

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

        // Determinar ruta de mysqldump
        // En Railway/Linux usará mysqldump del PATH
        // En Windows local intentará usar XAMPP primero
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            // Windows - intentar XAMPP primero
            $possiblePaths = [
                'D:\\Aplicaciones\\xampp\\mysql\\bin\\mysqldump.exe',
                'C:\\xampp\\mysql\\bin\\mysqldump.exe',
            ];

            $mysqldumpPath = 'mysqldump';
            foreach ($possiblePaths as $path) {
                if (file_exists($path)) {
                    $mysqldumpPath = $path;
                    break;
                }
            }
        } else {
            // Linux/Railway - usar del PATH
            $mysqldumpPath = 'mysqldump';
        }

        // Construir comando mysqldump sin redirección (lo haremos con file_put_contents)
        $commandArgs = [
            '--user=' . $username,
            '--host=' . $host,
            '--port=' . $port,
            '--single-transaction',
            '--routines',
            '--triggers',
            '--events',
            '--skip-comments',
        ];

        // Agregar password si existe
        if (!empty($password)) {
            $commandArgs[] = '--password=' . $password;
        }

        // Agregar nombre de base de datos
        $commandArgs[] = $database;

        // Ejecutar backup
        $this->info('📦 Exportando base de datos...');

        // Usar proc_open para capturar la salida directamente
        $descriptorspec = [
            0 => ['pipe', 'r'],  // stdin
            1 => ['pipe', 'w'],  // stdout
            2 => ['pipe', 'w']   // stderr
        ];

        $process = proc_open(
            $mysqldumpPath . ' ' . implode(' ', array_map('escapeshellarg', $commandArgs)),
            $descriptorspec,
            $pipes
        );

        if (is_resource($process)) {
            // Capturar la salida del dump
            $dumpOutput = stream_get_contents($pipes[1]);
            $errorOutput = stream_get_contents($pipes[2]);

            fclose($pipes[0]);
            fclose($pipes[1]);
            fclose($pipes[2]);

            $return = proc_close($process);

            // Guardar el dump en el archivo
            if ($return === 0 && !empty($dumpOutput)) {
                file_put_contents($filepath, $dumpOutput);
            }
        } else {
            $return = 1;
            $errorOutput = 'No se pudo iniciar el proceso mysqldump';
        }

        if ($return !== 0 || !file_exists($filepath) || filesize($filepath) === 0) {
            $this->error('❌ Error al crear el backup');
            $this->error("Return code: {$return}");

            if (isset($errorOutput) && !empty($errorOutput)) {
                $this->error('Error output: ' . $errorOutput);
            }

            // Verificar si el archivo existe pero está vacío
            if (file_exists($filepath) && filesize($filepath) === 0) {
                $this->error('El archivo de backup está vacío (0 bytes)');
                unlink($filepath); // Eliminar archivo vacío
            }

            // Log del error
            Log::error('backups', 'Error al crear backup de base de datos', 'mysqldump falló o generó archivo vacío. Return code: ' . $return . '. Error: ' . ($errorOutput ?? 'Unknown'));

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

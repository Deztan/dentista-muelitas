<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Log;

class DatabaseRestore extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:restore {file? : Nombre del archivo de backup}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restaurar base de datos desde un backup';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->warn('⚠️  ADVERTENCIA: Esta operación sobrescribirá la base de datos actual');
        $this->newLine();

        $backupPath = storage_path('app/backups');

        // Listar backups disponibles
        if (!is_dir($backupPath)) {
            $this->error('❌ No hay backups disponibles');
            return Command::FAILURE;
        }

        $backups = array_diff(scandir($backupPath), ['.', '..']);
        $backups = array_filter($backups, function ($file) use ($backupPath) {
            return is_file($backupPath . '/' . $file) && (str_ends_with($file, '.sql') || str_ends_with($file, '.zip'));
        });
        $backups = array_values($backups);

        if (empty($backups)) {
            $this->error('❌ No hay backups disponibles');
            return Command::FAILURE;
        }

        // Obtener archivo a restaurar
        $filename = $this->argument('file');

        if (!$filename) {
            $this->info('📋 Backups disponibles:');
            $this->newLine();

            foreach ($backups as $index => $backup) {
                $size = number_format(filesize($backupPath . '/' . $backup) / 1024 / 1024, 2);
                $this->line(($index + 1) . ". {$backup} ({$size} MB)");
            }

            $this->newLine();
            $choice = $this->ask('Selecciona el número del backup a restaurar (o 0 para cancelar)');

            if ($choice == 0 || !isset($backups[$choice - 1])) {
                $this->info('Operación cancelada');
                return Command::SUCCESS;
            }

            $filename = $backups[$choice - 1];
        }

        $filepath = $backupPath . '/' . $filename;

        if (!file_exists($filepath)) {
            $this->error("❌ El archivo {$filename} no existe");
            return Command::FAILURE;
        }

        // Confirmar restauración
        $confirmed = $this->confirm("¿Estás seguro de restaurar el backup '{$filename}'? Esto sobrescribirá todos los datos actuales", false);

        if (!$confirmed) {
            $this->info('Operación cancelada');
            return Command::SUCCESS;
        }

        // Descomprimir si es ZIP
        $sqlFile = $filepath;
        if (str_ends_with($filename, '.zip')) {
            $this->info('🗜️ Descomprimiendo backup...');

            $zip = new \ZipArchive();
            if ($zip->open($filepath) === TRUE) {
                $zip->extractTo($backupPath);
                $sqlFilename = str_replace('.zip', '.sql', $filename);
                $sqlFile = $backupPath . '/' . $sqlFilename;
                $zip->close();
            } else {
                $this->error('❌ No se pudo descomprimir el backup');
                return Command::FAILURE;
            }
        }

        $this->info('🔄 Restaurando base de datos...');

        $database = config('database.connections.mysql.database');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        $host = config('database.connections.mysql.host');
        $port = config('database.connections.mysql.port', 3306);

        // Determinar ruta de mysql
        // En Railway/Linux usará mysql del PATH
        // En Windows local intentará usar XAMPP primero
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            // Windows - intentar XAMPP primero
            $possiblePaths = [
                'D:\\Aplicaciones\\xampp\\mysql\\bin\\mysql.exe',
                'C:\\xampp\\mysql\\bin\\mysql.exe',
            ];

            $mysqlPath = 'mysql';
            foreach ($possiblePaths as $path) {
                if (file_exists($path)) {
                    $mysqlPath = $path;
                    break;
                }
            }
        } else {
            // Linux/Railway - usar del PATH
            $mysqlPath = 'mysql';
        }

        // Construir comando mysql
        $commandArgs = [
            '--user=' . $username,
            '--host=' . $host,
            '--port=' . $port,
        ];

        // Agregar password si existe
        if (!empty($password)) {
            $commandArgs[] = '--password=' . $password;
        }

        // Agregar nombre de base de datos
        $commandArgs[] = $database;

        // Leer el contenido del archivo SQL
        $sqlContent = file_get_contents($sqlFile);

        if ($sqlContent === false) {
            $this->error('❌ No se pudo leer el archivo de backup');
            return Command::FAILURE;
        }

        // Ejecutar restauración usando proc_open
        $descriptorspec = [
            0 => ['pipe', 'r'],  // stdin
            1 => ['pipe', 'w'],  // stdout
            2 => ['pipe', 'w']   // stderr
        ];

        $process = proc_open(
            $mysqlPath . ' ' . implode(' ', array_map('escapeshellarg', $commandArgs)),
            $descriptorspec,
            $pipes
        );

        $return = 1;
        $errorOutput = '';

        if (is_resource($process)) {
            // Enviar el SQL al stdin
            fwrite($pipes[0], $sqlContent);
            fclose($pipes[0]);

            // Capturar la salida
            stream_get_contents($pipes[1]); // stdout (no lo necesitamos)
            $errorOutput = stream_get_contents($pipes[2]);

            fclose($pipes[1]);
            fclose($pipes[2]);

            $return = proc_close($process);
        }

        // Limpiar archivo SQL temporal si era ZIP
        if (str_ends_with($filename, '.zip') && file_exists($sqlFile)) {
            unlink($sqlFile);
        }

        if ($return !== 0) {
            $this->error('❌ Error al restaurar el backup');

            if (!empty($errorOutput)) {
                $this->error('Error: ' . $errorOutput);
            }

            Log::error('backups', 'Error al restaurar backup', 'No se pudo ejecutar la restauración. Error: ' . $errorOutput);

            return Command::FAILURE;
        }

        $this->newLine();
        $this->info('✅ Base de datos restaurada exitosamente');
        $this->newLine();

        // Registrar en logs
        Log::registrar(
            'IMPORT',
            'backups',
            "Base de datos restaurada desde: {$filename}",
            [
                'level' => Log::WARNING,
                'resource_type' => 'DatabaseRestore',
                'metadata' => [
                    'filename' => $filename,
                    'database' => $database
                ],
                'is_sensitive' => true
            ]
        );

        return Command::SUCCESS;
    }
}

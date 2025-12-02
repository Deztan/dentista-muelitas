<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\TratamientoController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\ExpedienteController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ReportesController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\BackupController;

// ============================================
// RUTAS DE AUTENTICACIÓN (públicas)
// ============================================
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ============================================
// RUTAS PROTEGIDAS (requieren autenticación)
// ============================================
Route::middleware(['auth'])->group(function () {

    // Ruta principal - Página de inicio
    Route::get('/', function () {
        return view('home');
    })->name('home');

    // Rutas CRUD para Pacientes
    Route::resource('pacientes', PacienteController::class);

    // Rutas CRUD para Tratamientos
    Route::resource('tratamientos', TratamientoController::class);

    // Rutas CRUD para Materiales
    Route::resource('materiales', MaterialController::class);

    // Rutas CRUD para Citas
    Route::resource('citas', CitaController::class);

    // Rutas CRUD para Facturas
    Route::resource('facturas', FacturaController::class);
    Route::get('/facturas/{id}/print', [FacturaController::class, 'print'])->name('facturas.print');

    // Rutas CRUD para Expedientes
    Route::resource('expedientes', ExpedienteController::class);

    // Rutas CRUD para Usuarios (solo accesible para gerente_odontologo)
    Route::resource('usuarios', UsuarioController::class);

    // Reportes
    Route::get('/reportes', [ReportesController::class, 'index'])->name('reportes.index');
    Route::get('/reportes/facturas', [ReportesController::class, 'facturas'])->name('reportes.facturas');
    Route::get('/reportes/facturas/pdf', [ReportesController::class, 'facturasPdf'])->name('reportes.facturas.pdf');
    Route::get('/reportes/tratamientos', [ReportesController::class, 'tratamientos'])->name('reportes.tratamientos');
    Route::get('/reportes/tratamientos/pdf', [ReportesController::class, 'tratamientosPdf'])->name('reportes.tratamientos.pdf');
    Route::get('/reportes/ingresos', [ReportesController::class, 'ingresos'])->name('reportes.ingresos');
    Route::get('/reportes/ingresos/pdf', [ReportesController::class, 'ingresosPdf'])->name('reportes.ingresos.pdf');
    Route::get('/reportes/pacientes', [ReportesController::class, 'pacientes'])->name('reportes.pacientes');
    Route::get('/reportes/pacientes/pdf', [ReportesController::class, 'pacientesPdf'])->name('reportes.pacientes.pdf');
    Route::get('/reportes/inventario', [ReportesController::class, 'inventario'])->name('reportes.inventario');
    Route::get('/reportes/inventario/pdf', [ReportesController::class, 'inventarioPdf'])->name('reportes.inventario.pdf');

    // Logs (solo para gerente)
    Route::get('/logs', [LogController::class, 'index'])->name('logs.index');
    Route::get('/logs/{id}', [LogController::class, 'show'])->name('logs.show');

    // Backups (solo para gerente)
    Route::get('/backups', [BackupController::class, 'index'])->name('backups.index');
    Route::post('/backups', [BackupController::class, 'store'])->name('backups.store');
    Route::get('/backups/{filename}/download', [BackupController::class, 'download'])->name('backups.download');
    Route::post('/backups/{filename}/restore', [BackupController::class, 'restore'])->name('backups.restore');
    Route::delete('/backups/{filename}', [BackupController::class, 'destroy'])->name('backups.destroy');
});

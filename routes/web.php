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

    // Rutas CRUD para Expedientes
    Route::resource('expedientes', ExpedienteController::class);

    // Rutas CRUD para Usuarios (solo accesible para gerente_odontologo)
    Route::resource('usuarios', UsuarioController::class);

    // Reportes
    Route::get('/reportes/facturas', [ReportesController::class, 'facturas'])
        ->name('reportes.facturas');

    // Configuración
    Route::get('/configuracion', function () {
        return view('configuracion');
    })->name('configuracion');
});

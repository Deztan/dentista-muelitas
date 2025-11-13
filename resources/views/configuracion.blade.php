@extends('layouts.app')

@section('title', 'Configuración - Dentista Muelitas')

@section('content')
<div class="mb-4">
    <h1 class="h2">
        <i class="bi bi-gear text-primary"></i>
        Configuración del Sistema
    </h1>
    <p class="text-muted">Administra las opciones y preferencias del sistema</p>
</div>

<div class="row g-3">
    <!-- Información del Sistema -->
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-info-circle"></i> Información del Sistema</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tbody>
                        <tr>
                            <td class="fw-bold">Nombre del Sistema:</td>
                            <td>Dentista Muelitas</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Versión:</td>
                            <td>1.0.0</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Framework:</td>
                            <td>Laravel 11</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">PHP:</td>
                            <td>{{ phpversion() }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Base de Datos:</td>
                            <td>MySQL</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Perfil de Usuario -->
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-person-circle"></i> Mi Perfil</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tbody>
                        <tr>
                            <td class="fw-bold">Nombre:</td>
                            <td>{{ Auth::user()->nombre_completo }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Email:</td>
                            <td>{{ Auth::user()->email }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Rol:</td>
                            <td>
                                <span class="badge bg-info">
                                    {{ ucfirst(str_replace('_', ' ', Auth::user()->rol)) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold">Teléfono:</td>
                            <td>{{ Auth::user()->telefono ?? 'No registrado' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Estadísticas del Sistema -->
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="bi bi-graph-up"></i> Estadísticas Generales</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <div class="text-center p-3 bg-light rounded">
                            <i class="bi bi-people text-primary" style="font-size: 2rem;"></i>
                            <h3 class="mt-2">{{ \App\Models\Paciente::count() }}</h3>
                            <p class="text-muted mb-0">Total Pacientes</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center p-3 bg-light rounded">
                            <i class="bi bi-calendar-check text-success" style="font-size: 2rem;"></i>
                            <h3 class="mt-2">{{ \App\Models\Cita::count() }}</h3>
                            <p class="text-muted mb-0">Total Citas</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center p-3 bg-light rounded">
                            <i class="bi bi-file-medical text-info" style="font-size: 2rem;"></i>
                            <h3 class="mt-2">{{ \App\Models\Expediente::count() }}</h3>
                            <p class="text-muted mb-0">Total Expedientes</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center p-3 bg-light rounded">
                            <i class="bi bi-receipt text-warning" style="font-size: 2rem;"></i>
                            <h3 class="mt-2">{{ \App\Models\Factura::count() }}</h3>
                            <p class="text-muted mb-0">Total Facturas</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Accesos Rápidos -->
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="bi bi-lightning-fill"></i> Accesos Rápidos</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <a href="{{ route('pacientes.index') }}" class="btn btn-outline-primary w-100 py-3">
                            <i class="bi bi-people d-block" style="font-size: 2rem;"></i>
                            <span class="d-block mt-2">Ver Pacientes</span>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('citas.index') }}" class="btn btn-outline-success w-100 py-3">
                            <i class="bi bi-calendar-check d-block" style="font-size: 2rem;"></i>
                            <span class="d-block mt-2">Ver Citas</span>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('tratamientos.index') }}" class="btn btn-outline-info w-100 py-3">
                            <i class="bi bi-clipboard2-pulse d-block" style="font-size: 2rem;"></i>
                            <span class="d-block mt-2">Ver Tratamientos</span>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('facturas.index') }}" class="btn btn-outline-danger w-100 py-3">
                            <i class="bi bi-receipt d-block" style="font-size: 2rem;"></i>
                            <span class="d-block mt-2">Ver Facturas</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Administración de Usuarios (solo para gerentes) -->
    @if(Auth::user()->rol === 'gerente' || Auth::user()->rol === 'odontologo')
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0"><i class="bi bi-shield-lock-fill"></i> Administración</h5>
            </div>
            <div class="card-body">
                <p class="mb-3">Accesos para personal autorizado:</p>
                <div class="row g-3">
                    <div class="col-md-6">
                        <a href="{{ route('usuarios.index') }}" class="btn btn-outline-danger w-100">
                            <i class="bi bi-people-fill"></i> Gestionar Usuarios del Sistema
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('reportes.facturas') }}" class="btn btn-outline-warning w-100">
                            <i class="bi bi-graph-up"></i> Ver Reportes Financieros
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

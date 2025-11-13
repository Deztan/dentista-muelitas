@extends('layouts.app')

@section('title', 'Inicio - Dentista Muelitas')

@section('content')
<div class="mb-4">
    <h1 class="h2">
        <i class="bi bi-house-door text-primary"></i>
        Bienvenido al Sistema Dentista Muelitas
    </h1>
    <p class="text-muted">Panel de control y gestión del consultorio dental</p>
</div>

<!-- Tarjetas de estadísticas -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card shadow-sm border-start border-primary border-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Total Pacientes</h6>
                        <h3 class="mb-0">{{ \App\Models\Paciente::count() }}</h3>
                    </div>
                    <div class="text-primary">
                        <i class="bi bi-people" style="font-size: 2.5rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm border-start border-success border-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Citas Hoy</h6>
                        <h3 class="mb-0">{{ \App\Models\Cita::whereDate('fecha', today())->count() }}</h3>
                    </div>
                    <div class="text-success">
                        <i class="bi bi-calendar-check" style="font-size: 2.5rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm border-start border-info border-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Tratamientos</h6>
                        <h3 class="mb-0">{{ \App\Models\Tratamiento::count() }}</h3>
                    </div>
                    <div class="text-info">
                        <i class="bi bi-clipboard2-pulse" style="font-size: 2.5rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card shadow-sm border-start border-warning border-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-1">Materiales</h6>
                        <h3 class="mb-0">{{ \App\Models\Material::count() }}</h3>
                    </div>
                    <div class="text-warning">
                        <i class="bi bi-box-seam" style="font-size: 2.5rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Acciones rápidas -->
<div class="row g-3 mb-4">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="bi bi-lightning"></i> Acciones Rápidas</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <a href="{{ route('pacientes.create') }}" class="btn btn-outline-primary w-100 py-3">
                            <i class="bi bi-person-plus d-block" style="font-size: 2rem;"></i>
                            Nuevo Paciente
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('citas.create') }}" class="btn btn-outline-success w-100 py-3">
                            <i class="bi bi-calendar-plus d-block" style="font-size: 2rem;"></i>
                            Nueva Cita
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('expedientes.create') }}" class="btn btn-outline-info w-100 py-3">
                            <i class="bi bi-file-earmark-medical d-block" style="font-size: 2rem;"></i>
                            Nuevo Expediente
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('facturas.create') }}" class="btn btn-outline-warning w-100 py-3">
                            <i class="bi bi-receipt d-block" style="font-size: 2rem;"></i>
                            Nueva Factura
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Últimos pacientes registrados -->
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-clock-history"></i> Últimos Pacientes Registrados</h5>
                <a href="{{ route('pacientes.index') }}" class="btn btn-sm btn-outline-primary">Ver todos</a>
            </div>
            <div class="card-body">
                @php
                    $ultimosPacientes = \App\Models\Paciente::orderBy('created_at', 'desc')->take(5)->get();
                @endphp

                @if($ultimosPacientes->isEmpty())
                    <p class="text-muted text-center py-3">No hay pacientes registrados</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Nombre</th>
                                    <th>Teléfono</th>
                                    <th>Ciudad</th>
                                    <th>Registrado</th>
                                    <th class="text-center">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ultimosPacientes as $paciente)
                                    <tr>
                                        <td>
                                            <i class="bi bi-person-circle text-primary me-2"></i>
                                            {{ $paciente->nombre_completo }}
                                        </td>
                                        <td>{{ $paciente->telefono }}</td>
                                        <td>{{ $paciente->ciudad }}</td>
                                        <td>{{ $paciente->created_at->diffForHumans() }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('pacientes.show', $paciente->id) }}" class="btn btn-sm btn-info">
                                                <i class="bi bi-eye"></i> Ver
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

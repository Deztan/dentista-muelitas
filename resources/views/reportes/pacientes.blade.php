@extends('layouts.app')

@section('title', 'Reporte de Pacientes')

@section('content')
<div class="container-fluid py-4">
    <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            @foreach($breadcrumbs as $breadcrumb)
                @if(isset($breadcrumb['url']))
                    <li class="breadcrumb-item"><a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['name'] }}</a></li>
                @else
                    <li class="breadcrumb-item active">{{ $breadcrumb['name'] }}</li>
                @endif
            @endforeach
        </ol>
    </nav>

    <!-- Título y acciones -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">
            <i class="bi bi-people text-primary"></i> Reporte de Pacientes
        </h1>
        <div>
            <a href="{{ route('reportes.pacientes.pdf', request()->query()) }}" class="btn btn-danger me-2" target="_blank">
                <i class="bi bi-file-pdf"></i> Exportar PDF
            </a>
            <a href="{{ route('reportes.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0"><i class="bi bi-funnel"></i> Filtros</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('reportes.pacientes') }}" class="row g-3">
                <div class="col-md-4">
                    <label for="desde" class="form-label">Desde</label>
                    <input type="date" class="form-control" id="desde" name="desde" 
                           value="{{ $desde?->format('Y-m-d') }}">
                </div>
                <div class="col-md-4">
                    <label for="hasta" class="form-label">Hasta</label>
                    <input type="date" class="form-control" id="hasta" name="hasta" 
                           value="{{ $hasta?->format('Y-m-d') }}">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bi bi-search"></i> Filtrar
                    </button>
                    <a href="{{ route('reportes.pacientes') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle"></i> Limpiar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Estadísticas generales -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card border-primary">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Total Pacientes</h6>
                    <h3 class="text-primary mb-0">{{ $totalPacientes }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-success">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Pacientes Nuevos</h6>
                    <h3 class="text-success mb-0">{{ $totalPacientesNuevos }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-info">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Citas Completadas</h6>
                    <h3 class="text-info mb-0">{{ $totalCitasCompletadas }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card border-danger">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Citas Canceladas</h6>
                    <h3 class="text-danger mb-0">{{ $totalCitasCanceladas }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Listado de pacientes atendidos -->
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="bi bi-person-check"></i> Pacientes Atendidos
            </h5>
        </div>
        <div class="card-body">
            @if($pacientesAtendidos->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Paciente</th>
                                <th>CI</th>
                                <th>Teléfono</th>
                                <th class="text-center">Total Citas</th>
                                <th class="text-center">Completadas</th>
                                <th class="text-center">Canceladas</th>
                                <th class="text-end">Última Cita</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pacientesAtendidos as $paciente)
                                <tr>
                                    <td>
                                        <strong>{{ $paciente->nombre }} {{ $paciente->apellido }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $paciente->email }}</small>
                                    </td>
                                    <td>{{ $paciente->ci ?? 'N/A' }}</td>
                                    <td>
                                        @if($paciente->telefono)
                                            <i class="bi bi-telephone"></i> {{ $paciente->telefono }}
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-primary">{{ $paciente->total_citas }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-success">{{ $paciente->citas_completadas }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-danger">{{ $paciente->citas_canceladas }}</span>
                                    </td>
                                    <td class="text-end">
                                        @if($paciente->ultima_cita)
                                            @php
                                                $fecha = \Carbon\Carbon::parse($paciente->ultima_cita);
                                            @endphp
                                            <small>{{ $fecha->format('d/m/Y') }}</small>
                                            <br>
                                            <small class="text-muted">{{ $fecha->diffForHumans() }}</small>
                                        @else
                                            <span class="text-muted">Sin citas</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Mostrando {{ $pacientesAtendidos->firstItem() ?? 0 }} a {{ $pacientesAtendidos->lastItem() ?? 0 }} 
                        de {{ $pacientesAtendidos->total() }} pacientes
                    </div>
                    <div>
                        {{ $pacientesAtendidos->links() }}
                    </div>
                </div>
            @else
                <p class="text-muted mb-0">No se encontraron pacientes en el período seleccionado.</p>
            @endif
        </div>
    </div>
</div>
@endsection

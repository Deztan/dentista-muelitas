@extends('layouts.app')

@section('title', 'Reporte de Tratamientos')

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
            <i class="bi bi-bandaid text-success"></i> Reporte de Tratamientos
        </h1>
        <div>
            <a href="{{ route('reportes.tratamientos.pdf', request()->query()) }}" class="btn btn-danger me-2" target="_blank">
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
            <form method="GET" action="{{ route('reportes.tratamientos') }}" class="row g-3">
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
                    <a href="{{ route('reportes.tratamientos') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle"></i> Limpiar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-bar-chart"></i> Total de Tratamientos Realizados: 
                        <span class="text-primary">{{ $totalTratamientos }}</span>
                    </h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Tratamientos más realizados -->
    <div class="card mb-4">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">
                <i class="bi bi-trophy"></i> Top 10 Tratamientos Más Realizados
            </h5>
        </div>
        <div class="card-body">
            @if($tratamientosMasRealizados->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Posición</th>
                                <th>Tratamiento</th>
                                <th>Precio</th>
                                <th class="text-center">Cantidad Realizada</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tratamientosMasRealizados as $index => $item)
                                <tr>
                                    <td>
                                        @if($index == 0)
                                            <span class="badge bg-warning text-dark">🥇 1°</span>
                                        @elseif($index == 1)
                                            <span class="badge bg-secondary">🥈 2°</span>
                                        @elseif($index == 2)
                                            <span class="badge bg-danger">🥉 3°</span>
                                        @else
                                            <span class="badge bg-light text-dark">{{ $index + 1 }}°</span>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $item->tratamiento->nombre ?? 'Sin especificar' }}</strong>
                                        @if($item->tratamiento)
                                            <br><small class="text-muted">{{ Str::limit($item->tratamiento->descripcion, 60) }}</small>
                                        @endif
                                    </td>
                                    <td>Bs {{ number_format($item->tratamiento->precio ?? 0, 2) }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-primary" style="font-size: 1rem;">{{ $item->total }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted mb-0">No hay datos para mostrar.</p>
            @endif
        </div>
    </div>

    <!-- Historial de tratamientos -->
    <div class="card">
        <div class="card-header bg-light">
            <h5 class="mb-0">
                <i class="bi bi-list-ul"></i> Historial de Tratamientos Realizados
            </h5>
        </div>
        <div class="card-body">
            @if($expedientes->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Paciente</th>
                                <th>Tratamiento</th>
                                <th>Odontólogo</th>
                                <th>Diagnóstico</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($expedientes as $expediente)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($expediente->fecha)->format('d/m/Y') }}</td>
                                    <td>
                                        <strong>{{ $expediente->paciente->nombre }} {{ $expediente->paciente->apellido }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">
                                            {{ $expediente->tratamiento->nombre ?? 'No especificado' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($expediente->odontologo)
                                            {{ $expediente->odontologo->nombre_completo }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ Str::limit($expediente->diagnostico ?? 'Sin diagnóstico', 50) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="mt-3">
                    {{ $expedientes->links() }}
                </div>
            @else
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> No se encontraron tratamientos realizados en el período seleccionado.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

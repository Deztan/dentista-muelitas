@extends('layouts.app')

@section('title', 'Reporte de Ingresos')

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
            <i class="bi bi-graph-up-arrow text-info"></i> Reporte de Ingresos
        </h1>
        <div>
            <a href="{{ route('reportes.ingresos.pdf', request()->query()) }}" class="btn btn-danger me-2" target="_blank">
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
            <form method="GET" action="{{ route('reportes.ingresos') }}" class="row g-3">
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
                    <a href="{{ route('reportes.ingresos') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle"></i> Limpiar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Totales generales -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card border-primary">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Total Facturado</h6>
                    <h3 class="text-primary mb-0">Bs {{ number_format($totalFacturado, 2) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-success">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Total Cobrado</h6>
                    <h3 class="text-success mb-0">Bs {{ number_format($totalCobrado, 2) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-danger">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Total Pendiente</h6>
                    <h3 class="text-danger mb-0">Bs {{ number_format($totalPendiente, 2) }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Ingresos por método de pago -->
    <div class="card mb-4">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">
                <i class="bi bi-credit-card"></i> Ingresos por Método de Pago
            </h5>
        </div>
        <div class="card-body">
            @if($ingresosPorMetodo->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Método de Pago</th>
                                <th class="text-end">Total Cobrado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ingresosPorMetodo as $metodo)
                                <tr>
                                    <td>
                                        @switch($metodo->metodo_pago)
                                            @case('efectivo')
                                                <i class="bi bi-cash-stack text-success"></i> Efectivo
                                                @break
                                            @case('tarjeta')
                                                <i class="bi bi-credit-card text-primary"></i> Tarjeta
                                                @break
                                            @case('transferencia')
                                                <i class="bi bi-bank text-info"></i> Transferencia
                                                @break
                                            @case('qr')
                                                <i class="bi bi-qr-code text-warning"></i> QR
                                                @break
                                            @default
                                                <i class="bi bi-question-circle"></i> {{ ucfirst($metodo->metodo_pago) }}
                                        @endswitch
                                    </td>
                                    <td class="text-end">
                                        <strong>Bs {{ number_format($metodo->total, 2) }}</strong>
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

    <!-- Ingresos por tratamiento -->
    <div class="card mb-4">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">
                <i class="bi bi-trophy"></i> Top 10 Tratamientos por Ingresos
            </h5>
        </div>
        <div class="card-body">
            @if($ingresosPorTratamiento->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Tratamiento</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-end">Total Ingreso</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ingresosPorTratamiento as $item)
                                <tr>
                                    <td>
                                        <strong>{{ $item->tratamiento->nombre ?? 'Sin especificar' }}</strong>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-primary">{{ $item->cantidad }}</span>
                                    </td>
                                    <td class="text-end">
                                        <strong class="text-success">Bs {{ number_format($item->total, 2) }}</strong>
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

    <!-- Evolución mensual de ingresos -->
    @if($ingresosPorMes->count() > 0)
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="bi bi-calendar3"></i> Evolución Mensual de Ingresos (Últimos 6 Meses)
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Mes</th>
                            <th class="text-end">Ingresos</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ingresosPorMes as $mes)
                            <tr>
                                <td>
                                    @php
                                        $fecha = \Carbon\Carbon::parse($mes->mes . '-01');
                                    @endphp
                                    <i class="bi bi-calendar-month"></i> {{ $fecha->translatedFormat('F Y') }}
                                </td>
                                <td class="text-end">
                                    <strong class="text-success">Bs {{ number_format($mes->total, 2) }}</strong>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@extends('layouts.app')

@section('title', 'Reportes')

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

    <!-- Título -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">
            <i class="bi bi-graph-up text-primary"></i> Reportes y Estadísticas
        </h1>
    </div>

    <!-- Tarjetas de reportes -->
    <h5 class="mb-3">Reportes Disponibles</h5>
    <div class="row">
        <!-- Reporte de Facturas -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm hover-card">
                <div class="card-body">
                    <div class="text-center mb-3">
                        <i class="bi bi-receipt text-primary" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="card-title">Facturas y Cobros</h5>
                    <p class="card-text text-muted">
                        Consulta facturas emitidas, estados de pago, métodos de cobro y totales por período.
                    </p>
                    <a href="{{ route('reportes.facturas') }}" class="btn btn-primary w-100">
                        <i class="bi bi-eye"></i> Ver Reporte
                    </a>
                </div>
            </div>
        </div>

        <!-- Reporte de Tratamientos -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm hover-card">
                <div class="card-body">
                    <div class="text-center mb-3">
                        <i class="bi bi-clipboard2-pulse text-success" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="card-title">Tratamientos Realizados</h5>
                    <p class="card-text text-muted">
                        Estadísticas de tratamientos más realizados, frecuencia y detalles por paciente.
                    </p>
                    <a href="{{ route('reportes.tratamientos') }}" class="btn btn-success w-100">
                        <i class="bi bi-eye"></i> Ver Reporte
                    </a>
                </div>
            </div>
        </div>

        <!-- Reporte de Ingresos -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm hover-card">
                <div class="card-body">
                    <div class="text-center mb-3">
                        <i class="bi bi-graph-up-arrow text-info" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="card-title">Ingresos</h5>
                    <p class="card-text text-muted">
                        Análisis de ingresos por tratamiento, método de pago y evolución mensual.
                    </p>
                    <a href="{{ route('reportes.ingresos') }}" class="btn btn-info w-100">
                        <i class="bi bi-eye"></i> Ver Reporte
                    </a>
                </div>
            </div>
        </div>

        <!-- Reporte de Pacientes -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm hover-card">
                <div class="card-body">
                    <div class="text-center mb-3">
                        <i class="bi bi-people text-warning" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="card-title">Pacientes Atendidos</h5>
                    <p class="card-text text-muted">
                        Estadísticas de pacientes, nuevos registros, citas completadas y canceladas.
                    </p>
                    <a href="{{ route('reportes.pacientes') }}" class="btn btn-warning w-100">
                        <i class="bi bi-eye"></i> Ver Reporte
                    </a>
                </div>
            </div>
        </div>

        <!-- Reporte de Inventario -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm hover-card">
                <div class="card-body">
                    <div class="text-center mb-3">
                        <i class="bi bi-box-seam text-danger" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="card-title">Inventario de Materiales</h5>
                    <p class="card-text text-muted">
                        Control de stock, materiales con bajo inventario y valor total del inventario.
                    </p>
                    <a href="{{ route('reportes.inventario') }}" class="btn btn-danger w-100">
                        <i class="bi bi-eye"></i> Ver Reporte
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hover-card {
    transition: transform 0.2s, box-shadow 0.2s;
}
.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.2) !important;
}
</style>
@endsection

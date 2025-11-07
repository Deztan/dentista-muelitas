@extends('layouts.app')

@section('title', 'Detalle de Factura - Dentista Muelitas')

@section('content')
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('facturas.index') }}">Facturas</a></li>
        <li class="breadcrumb-item active">Factura #{{ str_pad($factura->id, 4, '0', STR_PAD_LEFT) }}</li>
    </ol>
</nav>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">
        <i class="bi bi-receipt text-primary"></i>
        Factura #{{ str_pad($factura->id, 4, '0', STR_PAD_LEFT) }}
    </h1>
    <div>
        <a href="{{ route('facturas.edit', $factura->id) }}" class="btn btn-warning">
            <i class="bi bi-pencil"></i> Editar
        </a>
        <form action="{{ route('facturas.destroy', $factura->id) }}" 
              method="POST" 
              class="d-inline"
              onsubmit="return confirm('¿Estás seguro de eliminar esta factura?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <i class="bi bi-trash"></i> Eliminar
            </button>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Información de la Factura -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="bi bi-receipt-cutoff"></i> Información de la Factura
                </h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Nº de Factura</h6>
                        <p class="h4">#{{ str_pad($factura->id, 4, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Fecha de Emisión</h6>
                        <p class="h5">
                            <i class="bi bi-calendar3 text-primary"></i>
                            {{ \Carbon\Carbon::parse($factura->fecha_emision)->format('d/m/Y') }}
                        </p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <h6 class="text-muted mb-2">Estado</h6>
                        <p>
                            @if($factura->estado == 'pendiente')
                                <span class="badge bg-warning text-dark fs-6">
                                    <i class="bi bi-clock-history"></i> Pendiente de Pago
                                </span>
                            @elseif($factura->estado == 'pagada')
                                <span class="badge bg-success fs-6">
                                    <i class="bi bi-check-circle-fill"></i> Pagada
                                </span>
                            @else
                                <span class="badge bg-danger fs-6">
                                    <i class="bi bi-x-circle-fill"></i> Cancelada
                                </span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información del Paciente -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">
                    <i class="bi bi-person-fill"></i> Información del Paciente
                </h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Paciente</h6>
                        <p>
                            <i class="bi bi-person-circle text-primary"></i>
                            <a href="{{ route('pacientes.show', $factura->paciente->id) }}">
                                {{ $factura->paciente->nombre_completo }}
                            </a>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Teléfono</h6>
                        <p>
                            <i class="bi bi-telephone text-success"></i>
                            {{ $factura->paciente->telefono }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detalles del Tratamiento -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">
                    <i class="bi bi-clipboard2-pulse"></i> Tratamiento Realizado
                </h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <h6 class="text-muted mb-2">Tratamiento</h6>
                        <p>
                            <i class="bi bi-clipboard2-check text-success"></i>
                            <a href="{{ route('tratamientos.show', $factura->tratamiento->id) }}">
                                {{ $factura->tratamiento->nombre }}
                            </a>
                        </p>
                    </div>
                </div>

                @if($factura->tratamiento->descripcion)
                <div class="row">
                    <div class="col-md-12">
                        <h6 class="text-muted mb-2">Descripción</h6>
                        <p class="border-start border-success border-4 ps-3">
                            {{ $factura->tratamiento->descripcion }}
                        </p>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Detalles Financieros -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">
                    <i class="bi bi-cash-coin"></i> Detalles Financieros
                </h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <h6 class="text-muted mb-2">Monto Total</h6>
                        <p class="h4 text-primary">
                            <i class="bi bi-currency-dollar"></i>
                            Bs {{ number_format($factura->monto_total, 2) }}
                        </p>
                    </div>
                    <div class="col-md-4">
                        <h6 class="text-muted mb-2">Monto Pagado</h6>
                        <p class="h4 text-success">
                            <i class="bi bi-check-circle"></i>
                            Bs {{ number_format($factura->monto_pagado, 2) }}
                        </p>
                    </div>
                    <div class="col-md-4">
                        <h6 class="text-muted mb-2">Saldo Pendiente</h6>
                        <p class="h4 {{ $factura->saldo_pendiente > 0 ? 'text-danger' : 'text-success' }}">
                            <i class="bi {{ $factura->saldo_pendiente > 0 ? 'bi-exclamation-triangle' : 'bi-check-all' }}"></i>
                            Bs {{ number_format($factura->saldo_pendiente, 2) }}
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Método de Pago</h6>
                        <p>
                            @if($factura->metodo_pago == 'efectivo')
                                <i class="bi bi-cash-stack text-success"></i> Efectivo
                            @elseif($factura->metodo_pago == 'tarjeta')
                                <i class="bi bi-credit-card text-primary"></i> Tarjeta
                            @elseif($factura->metodo_pago == 'transferencia')
                                <i class="bi bi-bank text-info"></i> Transferencia
                            @else
                                <i class="bi bi-qr-code text-warning"></i> Código QR
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Porcentaje Pagado</h6>
                        <div class="progress" style="height: 25px;">
                            @php
                                $porcentaje = ($factura->monto_total > 0) ? ($factura->monto_pagado / $factura->monto_total) * 100 : 0;
                            @endphp
                            <div class="progress-bar {{ $porcentaje == 100 ? 'bg-success' : 'bg-warning' }}" 
                                 role="progressbar" 
                                 style="width: {{ $porcentaje }}%">
                                {{ number_format($porcentaje, 1) }}%
                            </div>
                        </div>
                    </div>
                </div>

                @if($factura->observaciones)
                <div class="row mt-3">
                    <div class="col-md-12">
                        <h6 class="text-muted mb-2">Observaciones</h6>
                        <p class="border-start border-info border-4 ps-3 text-muted">
                            {{ $factura->observaciones }}
                        </p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Acciones Rápidas -->
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h6 class="card-title">
                    <i class="bi bi-lightning-charge text-warning"></i> Acciones Rápidas
                </h6>
                <div class="d-grid gap-2">
                    <a href="{{ route('facturas.edit', $factura->id) }}" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-pencil"></i> Editar Factura
                    </a>
                    <a href="{{ route('pacientes.show', $factura->paciente->id) }}" class="btn btn-outline-info btn-sm">
                        <i class="bi bi-person-fill"></i> Ver Paciente
                    </a>
                    <a href="{{ route('tratamientos.show', $factura->tratamiento->id) }}" class="btn btn-outline-success btn-sm">
                        <i class="bi bi-clipboard2-pulse"></i> Ver Tratamiento
                    </a>
                    <a href="{{ route('facturas.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left"></i> Volver al Listado
                    </a>
                </div>
            </div>
        </div>

        <!-- Información del Sistema -->
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h6 class="card-title">
                    <i class="bi bi-gear text-secondary"></i> Información del Sistema
                </h6>
                <p class="small mb-1"><strong>ID de Factura:</strong> {{ $factura->id }}</p>
                <p class="small mb-1"><strong>Registrada:</strong> {{ $factura->created_at->format('d/m/Y H:i') }}</p>
                <p class="small mb-0"><strong>Última actualización:</strong> {{ $factura->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        <!-- Estadísticas del Paciente -->
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="card-title">
                    <i class="bi bi-bar-chart text-info"></i> Estadísticas del Paciente
                </h6>
                <p class="small mb-1">
                    <strong>Total de facturas:</strong> 
                    {{ $factura->paciente->facturas->count() }}
                </p>
                <p class="small mb-1">
                    <strong>Facturas pagadas:</strong> 
                    {{ $factura->paciente->facturas->where('estado', 'pagada')->count() }}
                </p>
                <p class="small mb-0">
                    <strong>Facturas pendientes:</strong> 
                    {{ $factura->paciente->facturas->where('estado', 'pendiente')->count() }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

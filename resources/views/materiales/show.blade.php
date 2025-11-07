@extends('layouts.app')

@section('title', 'Detalle Material - Dentista Muelitas')

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('materiales.index') }}">Materiales</a></li>
            <li class="breadcrumb-item active">{{ $material->nombre }}</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="h3">
            <i class="bi bi-box text-primary"></i>
            {{ $material->nombre }}
        </h1>
        <div>
            <a href="{{ route('materiales.edit', $material->id) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Editar
            </a>
            <form action="{{ route('materiales.destroy', $material->id) }}" 
                  method="POST" 
                  class="d-inline"
                  onsubmit="return confirm('¿Estás seguro de eliminar este material?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-trash"></i> Eliminar
                </button>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <!-- Información Principal -->
    <div class="col-lg-8">
        <!-- Información del Material -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <i class="bi bi-info-circle"></i> Información del Material
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="text-muted small">Nombre</label>
                        <h5 class="mb-0">{{ $material->nombre }}</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="text-muted small">Descripción</label>
                        <p class="mb-0">
                            @if($material->descripcion)
                                {{ $material->descripcion }}
                            @else
                                <span class="text-muted">Sin descripción</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stock e Inventario -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-warning">
                <i class="bi bi-clipboard-check"></i> Control de Inventario
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="text-muted small">Unidad de Medida</label>
                        <p class="mb-0"><strong>{{ $material->unidad_medida }}</strong></p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="text-muted small">Stock Actual</label>
                        <h4 class="mb-0 
                            @if($material->stock_actual <= 0) text-danger
                            @elseif($material->stock_actual <= $material->stock_minimo) text-warning
                            @else text-success
                            @endif">
                            {{ $material->stock_actual }}
                        </h4>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="text-muted small">Stock Mínimo</label>
                        <p class="mb-0"><strong>{{ $material->stock_minimo }}</strong></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información Económica -->
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <i class="bi bi-currency-dollar"></i> Información Económica
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Precio Unitario</label>
                        <h4 class="mb-0 text-success">Bs {{ number_format($material->precio_unitario, 2) }}</h4>
                        <small class="text-muted">Por {{ $material->unidad_medida }}</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Valor Total del Stock</label>
                        <h4 class="mb-0 text-info">Bs {{ number_format($material->precio_unitario * $material->stock_actual, 2) }}</h4>
                        <small class="text-muted">Stock actual × Precio unitario</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Panel Lateral -->
    <div class="col-lg-4">
        <!-- Estado del Stock -->
        <div class="card shadow-sm mb-3">
            <div class="card-header bg-dark text-white">
                <i class="bi bi-info-circle"></i> Estado del Stock
            </div>
            <div class="card-body text-center">
                @if($material->stock_actual <= 0)
                    <i class="bi bi-x-circle text-danger" style="font-size: 3rem;"></i>
                    <h5 class="mt-3 text-danger">Sin Stock</h5>
                    <p class="text-muted small">Este material no está disponible</p>
                @elseif($material->stock_actual <= $material->stock_minimo)
                    <i class="bi bi-exclamation-triangle text-warning" style="font-size: 3rem;"></i>
                    <h5 class="mt-3 text-warning">Stock Bajo</h5>
                    <p class="text-muted small">Considera reabastecer pronto</p>
                @else
                    <i class="bi bi-check-circle text-success" style="font-size: 3rem;"></i>
                    <h5 class="mt-3 text-success">Stock Disponible</h5>
                    <p class="text-muted small">Inventario en buen nivel</p>
                @endif
            </div>
        </div>

        <!-- Información del Registro -->
        <div class="card shadow-sm mb-3">
            <div class="card-header bg-secondary text-white">
                <i class="bi bi-calendar"></i> Información del Registro
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <strong><i class="bi bi-hash"></i> ID:</strong><br>
                        <span class="text-muted">#{{ $material->id }}</span>
                    </li>
                    <li class="mb-2">
                        <strong><i class="bi bi-calendar-plus"></i> Registrado:</strong><br>
                        <span class="text-muted">{{ $material->created_at->format('d/m/Y H:i') }}</span>
                    </li>
                    <li class="mb-2">
                        <strong><i class="bi bi-calendar-check"></i> Última Modificación:</strong><br>
                        <span class="text-muted">{{ $material->updated_at->format('d/m/Y H:i') }}</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Acciones Rápidas -->
        <div class="card shadow-sm border-success">
            <div class="card-header bg-success text-white">
                <i class="bi bi-lightning"></i> Acciones Rápidas
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('materiales.edit', $material->id) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Editar Material
                    </a>
                    <a href="{{ route('materiales.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Volver al Listado
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

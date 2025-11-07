@extends('layouts.app')

@section('title', 'Editar Material - Dentista Muelitas')

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('materiales.index') }}">Materiales</a></li>
            <li class="breadcrumb-item active">Editar: {{ $material->nombre }}</li>
        </ol>
    </nav>
    <h1 class="h3">
        <i class="bi bi-pencil text-warning"></i>
        Editar Material: {{ $material->nombre }}
    </h1>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('materiales.update', $material->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Información General -->
                    <h5 class="mb-3 text-primary">
                        <i class="bi bi-box-seam"></i> Información del Material
                    </h5>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="nombre" class="form-label">Nombre del Material <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('nombre') is-invalid @enderror" 
                                   id="nombre" 
                                   name="nombre" 
                                   value="{{ old('nombre', $material->nombre) }}" 
                                   required>
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                      id="descripcion" 
                                      name="descripcion" 
                                      rows="3">{{ old('descripcion', $material->descripcion) }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Stock e Inventario -->
                    <h5 class="mb-3 text-warning">
                        <i class="bi bi-clipboard-check"></i> Control de Inventario
                    </h5>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="unidad_medida" class="form-label">Unidad de Medida <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('unidad_medida') is-invalid @enderror" 
                                   id="unidad_medida" 
                                   name="unidad_medida" 
                                   value="{{ old('unidad_medida', $material->unidad_medida) }}" 
                                   required>
                            @error('unidad_medida')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="precio_unitario" class="form-label">Precio Unitario (Bs) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Bs</span>
                                <input type="number" 
                                       class="form-control @error('precio_unitario') is-invalid @enderror" 
                                       id="precio_unitario" 
                                       name="precio_unitario" 
                                       value="{{ old('precio_unitario', $material->precio_unitario) }}" 
                                       step="0.01" 
                                       min="0" 
                                       required>
                                @error('precio_unitario')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="stock_actual" class="form-label">Stock Actual <span class="text-danger">*</span></label>
                            <input type="number" 
                                   class="form-control @error('stock_actual') is-invalid @enderror" 
                                   id="stock_actual" 
                                   name="stock_actual" 
                                   value="{{ old('stock_actual', $material->stock_actual) }}" 
                                   min="0" 
                                   required>
                            @error('stock_actual')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="stock_minimo" class="form-label">Stock Mínimo <span class="text-danger">*</span></label>
                            <input type="number" 
                                   class="form-control @error('stock_minimo') is-invalid @enderror" 
                                   id="stock_minimo" 
                                   name="stock_minimo" 
                                   value="{{ old('stock_minimo', $material->stock_minimo) }}" 
                                   min="0" 
                                   required>
                            @error('stock_minimo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <hr class="my-4">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('materiales.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-warning text-white">
                            <i class="bi bi-save"></i> Actualizar Material
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Panel de información -->
    <div class="col-lg-4">
        <div class="card shadow-sm border-warning mb-3">
            <div class="card-header bg-warning text-dark">
                <i class="bi bi-info-circle"></i> Información del Registro
            </div>
            <div class="card-body">
                <ul class="small mb-0">
                    <li><strong>ID:</strong> #{{ $material->id }}</li>
                    <li><strong>Registrado:</strong> {{ $material->created_at->format('d/m/Y H:i') }}</li>
                    <li><strong>Última modificación:</strong> {{ $material->updated_at->format('d/m/Y H:i') }}</li>
                </ul>
            </div>
        </div>

        <div class="card shadow-sm border-info">
            <div class="card-header bg-info text-white">
                <i class="bi bi-lightbulb"></i> Estado del Stock
            </div>
            <div class="card-body">
                @if($material->stock_actual <= 0)
                    <div class="alert alert-danger mb-0">
                        <i class="bi bi-exclamation-triangle"></i> <strong>Sin Stock</strong><br>
                        <small>Este material no está disponible</small>
                    </div>
                @elseif($material->stock_actual <= $material->stock_minimo)
                    <div class="alert alert-warning mb-0">
                        <i class="bi bi-exclamation-circle"></i> <strong>Stock Bajo</strong><br>
                        <small>Considera reabastecer pronto</small>
                    </div>
                @else
                    <div class="alert alert-success mb-0">
                        <i class="bi bi-check-circle"></i> <strong>Stock Suficiente</strong><br>
                        <small>El inventario está en buen nivel</small>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

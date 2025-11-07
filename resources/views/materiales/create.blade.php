@extends('layouts.app')

@section('title', 'Nuevo Material - Dentista Muelitas')

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('materiales.index') }}">Materiales</a></li>
            <li class="breadcrumb-item active">Nuevo Material</li>
        </ol>
    </nav>
    <h1 class="h3">
        <i class="bi bi-plus-circle text-primary"></i>
        Registrar Nuevo Material
    </h1>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('materiales.store') }}" method="POST">
                    @csrf

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
                                   value="{{ old('nombre') }}" 
                                   required 
                                   placeholder="Ej: Guantes de látex, Jeringa, Anestesia...">
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
                                      rows="3" 
                                      placeholder="Describe el material, marca, características especiales...">{{ old('descripcion') }}</textarea>
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
                                   value="{{ old('unidad_medida') }}" 
                                   required 
                                   placeholder="Ej: Unidad, Caja, Paquete, ml, mg...">
                            @error('unidad_medida')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">¿Cómo se mide este material?</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="precio_unitario" class="form-label">Precio Unitario (Bs) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Bs</span>
                                <input type="number" 
                                       class="form-control @error('precio_unitario') is-invalid @enderror" 
                                       id="precio_unitario" 
                                       name="precio_unitario" 
                                       value="{{ old('precio_unitario') }}" 
                                       step="0.01" 
                                       min="0" 
                                       required 
                                       placeholder="0.00">
                                @error('precio_unitario')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="text-muted">Precio por unidad</small>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="stock_actual" class="form-label">Stock Actual <span class="text-danger">*</span></label>
                            <input type="number" 
                                   class="form-control @error('stock_actual') is-invalid @enderror" 
                                   id="stock_actual" 
                                   name="stock_actual" 
                                   value="{{ old('stock_actual', 0) }}" 
                                   min="0" 
                                   required>
                            @error('stock_actual')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Cantidad disponible actualmente</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="stock_minimo" class="form-label">Stock Mínimo <span class="text-danger">*</span></label>
                            <input type="number" 
                                   class="form-control @error('stock_minimo') is-invalid @enderror" 
                                   id="stock_minimo" 
                                   name="stock_minimo" 
                                   value="{{ old('stock_minimo', 0) }}" 
                                   min="0" 
                                   required>
                            @error('stock_minimo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Alerta cuando llegue a esta cantidad</small>
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <hr class="my-4">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('materiales.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Guardar Material
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Panel de información -->
    <div class="col-lg-4">
        <div class="card shadow-sm border-info">
            <div class="card-header bg-info text-white">
                <i class="bi bi-info-circle"></i> Información
            </div>
            <div class="card-body">
                <h6 class="card-title">Campos Obligatorios</h6>
                <ul class="small">
                    <li>Nombre del material</li>
                    <li>Unidad de medida</li>
                    <li>Stock actual</li>
                    <li>Stock mínimo</li>
                    <li>Precio unitario</li>
                </ul>

                <hr>

                <h6 class="card-title">Consejos</h6>
                <ul class="small text-muted">
                    <li>Define un stock mínimo realista para recibir alertas</li>
                    <li>El stock actual se puede actualizar luego</li>
                    <li>Usa unidades de medida consistentes</li>
                    <li>Actualiza el precio cuando cambien los proveedores</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Nuevo Tratamiento - Dentista Muelitas')

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('tratamientos.index') }}">Tratamientos</a></li>
            <li class="breadcrumb-item active">Nuevo Tratamiento</li>
        </ol>
    </nav>
    <h1 class="h3">
        <i class="bi bi-plus-circle text-primary"></i>
        Registrar Nuevo Tratamiento
    </h1>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('tratamientos.store') }}" method="POST">
                    @csrf

                    <!-- Información General -->
                    <h5 class="mb-3 text-primary">
                        <i class="bi bi-clipboard2-pulse"></i> Información del Tratamiento
                    </h5>

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="nombre" class="form-label">Nombre del Tratamiento <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('nombre') is-invalid @enderror" 
                                   id="nombre" 
                                   name="nombre" 
                                   value="{{ old('nombre') }}" 
                                   required 
                                   placeholder="Ej: Limpieza Dental, Ortodoncia, Implante...">
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
                                      rows="4" 
                                      placeholder="Describe el procedimiento, sus beneficios, recomendaciones...">{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Proporciona información detallada sobre el tratamiento</small>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Información Económica y Temporal -->
                    <h5 class="mb-3 text-success">
                        <i class="bi bi-currency-dollar"></i> Precio y Duración
                    </h5>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="precio_base" class="form-label">Precio Base (Bs) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Bs</span>
                                <input type="number" 
                                       class="form-control @error('precio_base') is-invalid @enderror" 
                                       id="precio_base" 
                                       name="precio_base" 
                                       value="{{ old('precio_base') }}" 
                                       step="0.01" 
                                       min="0" 
                                       required 
                                       placeholder="0.00">
                                @error('precio_base')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="text-muted">Precio estándar del tratamiento</small>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="duracion_minutos" class="form-label">Duración (minutos) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" 
                                       class="form-control @error('duracion_minutos') is-invalid @enderror" 
                                       id="duracion_minutos" 
                                       name="duracion_minutos" 
                                       value="{{ old('duracion_minutos') }}" 
                                       min="1" 
                                       required 
                                       placeholder="60">
                                <span class="input-group-text">min</span>
                                @error('duracion_minutos')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="text-muted">Tiempo aproximado del procedimiento</small>
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <hr class="my-4">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('tratamientos.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Guardar Tratamiento
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
                    <li>Nombre del tratamiento</li>
                    <li>Precio base</li>
                    <li>Duración en minutos</li>
                </ul>

                <hr>

                <h6 class="card-title">Consejos</h6>
                <ul class="small text-muted">
                    <li>Usa nombres descriptivos y claros</li>
                    <li>El precio base puede ajustarse por paciente</li>
                    <li>La duración ayuda a planificar citas</li>
                    <li>Una buena descripción ayuda al personal</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

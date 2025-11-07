@extends('layouts.app')

@section('title', 'Editar Cita - Dentista Muelitas')

@section('content')
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('citas.index') }}">Citas</a></li>
        <li class="breadcrumb-item active">Editar Cita #{{ $cita->id }}</li>
    </ol>
</nav>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header bg-warning">
                <h5 class="mb-0">
                    <i class="bi bi-pencil-square"></i> Editar Cita #{{ $cita->id }}
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('citas.update', $cita->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Información del Paciente -->
                    <h6 class="border-bottom pb-2 mb-3">
                        <i class="bi bi-person-fill text-primary"></i> Paciente
                    </h6>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="paciente_id" class="form-label">Paciente <span class="text-danger">*</span></label>
                            <select class="form-select @error('paciente_id') is-invalid @enderror" 
                                    id="paciente_id" 
                                    name="paciente_id" 
                                    required>
                                <option value="">Seleccione un paciente</option>
                                @foreach($pacientes as $paciente)
                                    <option value="{{ $paciente->id }}" 
                                        {{ old('paciente_id', $cita->paciente_id) == $paciente->id ? 'selected' : '' }}>
                                        {{ $paciente->nombre_completo }} - {{ $paciente->telefono }}
                                    </option>
                                @endforeach
                            </select>
                            @error('paciente_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Información de la Cita -->
                    <h6 class="border-bottom pb-2 mb-3 mt-4">
                        <i class="bi bi-calendar-event text-info"></i> Fecha y Hora
                    </h6>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="fecha" class="form-label">Fecha <span class="text-danger">*</span></label>
                            <input type="date" 
                                   class="form-control @error('fecha') is-invalid @enderror" 
                                   id="fecha" 
                                   name="fecha" 
                                   value="{{ old('fecha', $cita->fecha) }}"
                                   required>
                            @error('fecha')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="hora" class="form-label">Hora <span class="text-danger">*</span></label>
                            <input type="time" 
                                   class="form-control @error('hora') is-invalid @enderror" 
                                   id="hora" 
                                   name="hora" 
                                   value="{{ old('hora', $cita->hora) }}"
                                   required>
                            @error('hora')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Información del Tratamiento -->
                    <h6 class="border-bottom pb-2 mb-3 mt-4">
                        <i class="bi bi-clipboard2-pulse text-success"></i> Detalles del Servicio
                    </h6>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="usuario_id" class="form-label">Odontólogo <span class="text-danger">*</span></label>
                            <select class="form-select @error('usuario_id') is-invalid @enderror" 
                                    id="usuario_id" 
                                    name="usuario_id" 
                                    required>
                                <option value="">Seleccione un odontólogo</option>
                                @foreach($usuarios as $usuario)
                                    <option value="{{ $usuario->id }}" 
                                        {{ old('usuario_id', $cita->usuario_id) == $usuario->id ? 'selected' : '' }}>
                                        {{ $usuario->nombre_completo }}
                                    </option>
                                @endforeach
                            </select>
                            @error('usuario_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="tratamiento_id" class="form-label">Tratamiento</label>
                            <select class="form-select @error('tratamiento_id') is-invalid @enderror" 
                                    id="tratamiento_id" 
                                    name="tratamiento_id">
                                <option value="">Sin tratamiento específico</option>
                                @foreach($tratamientos as $tratamiento)
                                    <option value="{{ $tratamiento->id }}" 
                                        {{ old('tratamiento_id', $cita->tratamiento_id) == $tratamiento->id ? 'selected' : '' }}>
                                        {{ $tratamiento->nombre }} - Bs {{ number_format($tratamiento->precio_base, 2) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tratamiento_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="estado" class="form-label">Estado <span class="text-danger">*</span></label>
                            <select class="form-select @error('estado') is-invalid @enderror" 
                                    id="estado" 
                                    name="estado" 
                                    required>
                                <option value="pendiente" {{ old('estado', $cita->estado) == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="confirmada" {{ old('estado', $cita->estado) == 'confirmada' ? 'selected' : '' }}>Confirmada</option>
                                <option value="completada" {{ old('estado', $cita->estado) == 'completada' ? 'selected' : '' }}>Completada</option>
                                <option value="cancelada" {{ old('estado', $cita->estado) == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                            </select>
                            @error('estado')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="motivo" class="form-label">Motivo de la Consulta <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('motivo') is-invalid @enderror" 
                                  id="motivo" 
                                  name="motivo" 
                                  rows="3" 
                                  required>{{ old('motivo', $cita->motivo) }}</textarea>
                        @error('motivo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="observaciones" class="form-label">Observaciones</label>
                        <textarea class="form-control @error('observaciones') is-invalid @enderror" 
                                  id="observaciones" 
                                  name="observaciones" 
                                  rows="3">{{ old('observaciones', $cita->observaciones) }}</textarea>
                        @error('observaciones')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('citas.show', $cita->id) }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-check-circle"></i> Actualizar Cita
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h6 class="card-title">
                    <i class="bi bi-info-circle text-primary"></i> Información del Registro
                </h6>
                <p class="small mb-1"><strong>ID:</strong> {{ $cita->id }}</p>
                <p class="small mb-1"><strong>Creado:</strong> {{ $cita->created_at->format('d/m/Y H:i') }}</p>
                <p class="small mb-0"><strong>Última actualización:</strong> {{ $cita->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="card-title">
                    <i class="bi bi-exclamation-triangle text-warning"></i> Importante
                </h6>
                <p class="small text-muted mb-0">
                    Al cambiar la fecha u hora de la cita, asegúrese de notificar al paciente sobre el cambio.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

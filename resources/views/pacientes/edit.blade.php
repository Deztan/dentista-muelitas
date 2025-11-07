@extends('layouts.app')

@section('title', 'Editar Paciente - Dentista Muelitas')

@section('content')
<div class="mb-4">
    <h1 class="h3">
        <i class="bi bi-pencil-square text-warning"></i>
        Editar Paciente
    </h1>
    <p class="text-muted">Modifica la información del paciente <strong>{{ $paciente->nombre_completo }}</strong></p>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('pacientes.update', $paciente->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Información Personal -->
                    <h5 class="mb-3"><i class="bi bi-person"></i> Información Personal</h5>
                    
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="nombre_completo" class="form-label">Nombre Completo <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('nombre_completo') is-invalid @enderror" 
                                   id="nombre_completo" 
                                   name="nombre_completo" 
                                   value="{{ old('nombre_completo', $paciente->nombre_completo) }}" 
                                   required>
                            @error('nombre_completo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento <span class="text-danger">*</span></label>
                            <input type="date" 
                                   class="form-control @error('fecha_nacimiento') is-invalid @enderror" 
                                   id="fecha_nacimiento" 
                                   name="fecha_nacimiento" 
                                   value="{{ old('fecha_nacimiento', $paciente->fecha_nacimiento->format('Y-m-d')) }}" 
                                   required>
                            @error('fecha_nacimiento')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="genero" class="form-label">Género <span class="text-danger">*</span></label>
                            <select class="form-select @error('genero') is-invalid @enderror" 
                                    id="genero" 
                                    name="genero" 
                                    required>
                                <option value="">Seleccionar...</option>
                                <option value="masculino" {{ old('genero', $paciente->genero) == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                <option value="femenino" {{ old('genero', $paciente->genero) == 'femenino' ? 'selected' : '' }}>Femenino</option>
                                <option value="otro" {{ old('genero', $paciente->genero) == 'otro' ? 'selected' : '' }}>Otro</option>
                            </select>
                            @error('genero')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Información de Contacto -->
                    <h5 class="mb-3 mt-4"><i class="bi bi-telephone"></i> Información de Contacto</h5>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="telefono" class="form-label">Teléfono <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('telefono') is-invalid @enderror" 
                                   id="telefono" 
                                   name="telefono" 
                                   value="{{ old('telefono', $paciente->telefono) }}" 
                                   required>
                            @error('telefono')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', $paciente->email) }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-8">
                            <label for="direccion" class="form-label">Dirección <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('direccion') is-invalid @enderror" 
                                   id="direccion" 
                                   name="direccion" 
                                   value="{{ old('direccion', $paciente->direccion) }}" 
                                   required>
                            @error('direccion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="ciudad" class="form-label">Ciudad <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('ciudad') is-invalid @enderror" 
                                   id="ciudad" 
                                   name="ciudad" 
                                   value="{{ old('ciudad', $paciente->ciudad) }}" 
                                   required>
                            @error('ciudad')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Información Médica -->
                    <h5 class="mb-3 mt-4"><i class="bi bi-heart-pulse"></i> Información Médica</h5>

                    <div class="mb-3">
                        <label for="alergias" class="form-label">Alergias</label>
                        <textarea class="form-control @error('alergias') is-invalid @enderror" 
                                  id="alergias" 
                                  name="alergias" 
                                  rows="2">{{ old('alergias', $paciente->alergias) }}</textarea>
                        @error('alergias')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="condiciones_medicas" class="form-label">Condiciones Médicas</label>
                        <textarea class="form-control @error('condiciones_medicas') is-invalid @enderror" 
                                  id="condiciones_medicas" 
                                  name="condiciones_medicas" 
                                  rows="2">{{ old('condiciones_medicas', $paciente->condiciones_medicas) }}</textarea>
                        @error('condiciones_medicas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Contacto de Emergencia -->
                    <h5 class="mb-3 mt-4"><i class="bi bi-exclamation-triangle"></i> Contacto de Emergencia</h5>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="contacto_emergencia" class="form-label">Nombre de Contacto</label>
                            <input type="text" 
                                   class="form-control @error('contacto_emergencia') is-invalid @enderror" 
                                   id="contacto_emergencia" 
                                   name="contacto_emergencia" 
                                   value="{{ old('contacto_emergencia', $paciente->contacto_emergencia) }}"
                                   placeholder="Nombre del familiar">
                            @error('contacto_emergencia')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="telefono_emergencia" class="form-label">Teléfono de Emergencia</label>
                            <input type="text" 
                                   class="form-control @error('telefono_emergencia') is-invalid @enderror" 
                                   id="telefono_emergencia" 
                                   name="telefono_emergencia" 
                                   value="{{ old('telefono_emergencia', $paciente->telefono_emergencia) }}"
                                   placeholder="70123456">
                            @error('telefono_emergencia')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Botones -->
                    <hr class="my-4">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('pacientes.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-save"></i> Actualizar Paciente
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="card-title"><i class="bi bi-info-circle"></i> Información</h6>
                <p class="small text-muted mb-2">
                    <strong>ID:</strong> #{{ $paciente->id }}
                </p>
                <p class="small text-muted mb-2">
                    <strong>Registrado:</strong> {{ $paciente->created_at->format('d/m/Y H:i') }}
                </p>
                <p class="small text-muted">
                    <strong>Última actualización:</strong> {{ $paciente->updated_at->diffForHumans() }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

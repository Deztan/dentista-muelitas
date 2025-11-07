@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2><i class="bi bi-pencil-square text-warning me-2"></i>Editar Expediente Médico</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('expedientes.index') }}">Expedientes</a></li>
                <li class="breadcrumb-item active">Editar</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="bi bi-file-earmark-medical me-2"></i>Datos del Expediente</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('expedientes.update', $expediente->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Sección: Información del Paciente --}}
                        <div class="mb-4">
                            <h6 class="border-bottom pb-2 mb-3">
                                <i class="bi bi-person-fill text-primary me-2"></i>Información del Paciente
                            </h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="paciente_id" class="form-label">Paciente <span class="text-danger">*</span></label>
                                    <select class="form-select @error('paciente_id') is-invalid @enderror" 
                                            id="paciente_id" name="paciente_id" required>
                                        <option value="">Seleccione un paciente</option>
                                        @foreach($pacientes as $paciente)
                                            <option value="{{ $paciente->id }}" {{ old('paciente_id', $expediente->paciente_id) == $paciente->id ? 'selected' : '' }}>
                                                {{ $paciente->nombre_completo }} - {{ $paciente->telefono }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('paciente_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="fecha" class="form-label">Fecha de Atención <span class="text-danger">*</span></label>
                                    <input type="date" 
                                           class="form-control @error('fecha') is-invalid @enderror" 
                                           id="fecha" 
                                           name="fecha" 
                                           value="{{ old('fecha', $expediente->fecha) }}"
                                           max="{{ date('Y-m-d') }}"
                                           required>
                                    @error('fecha')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="cita_id" class="form-label">Cita Relacionada</label>
                                    <select class="form-select @error('cita_id') is-invalid @enderror" 
                                            id="cita_id" name="cita_id">
                                        <option value="">Sin cita asociada</option>
                                        @foreach($citas as $cita)
                                            <option value="{{ $cita->id }}" {{ old('cita_id', $expediente->cita_id) == $cita->id ? 'selected' : '' }}>
                                                {{ $cita->paciente->nombre_completo }} - {{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cita_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Solo se muestran citas completadas</small>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="pieza_dental" class="form-label">Pieza Dental</label>
                                    <input type="text" 
                                           class="form-control @error('pieza_dental') is-invalid @enderror" 
                                           id="pieza_dental" 
                                           name="pieza_dental" 
                                           value="{{ old('pieza_dental', $expediente->pieza_dental) }}"
                                           placeholder="Ej: 16, 21, 38"
                                           maxlength="10">
                                    @error('pieza_dental')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Número o código del diente</small>
                                </div>
                            </div>
                        </div>

                        {{-- Sección: Personal Médico --}}
                        <div class="mb-4">
                            <h6 class="border-bottom pb-2 mb-3">
                                <i class="bi bi-person-badge text-success me-2"></i>Personal Médico
                            </h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="odontologo_id" class="form-label">Odontólogo <span class="text-danger">*</span></label>
                                    <select class="form-select @error('odontologo_id') is-invalid @enderror" 
                                            id="odontologo_id" name="odontologo_id" required>
                                        <option value="">Seleccione odontólogo</option>
                                        @foreach($odontologos as $odontologo)
                                            <option value="{{ $odontologo->id }}" {{ old('odontologo_id', $expediente->odontologo_id) == $odontologo->id ? 'selected' : '' }}>
                                                {{ $odontologo->nombre_completo }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('odontologo_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="asistente_id" class="form-label">Asistente/Enfermera</label>
                                    <select class="form-select @error('asistente_id') is-invalid @enderror" 
                                            id="asistente_id" name="asistente_id">
                                        <option value="">Sin asistente</option>
                                        @foreach($asistentes as $asistente)
                                            <option value="{{ $asistente->id }}" {{ old('asistente_id', $expediente->asistente_id) == $asistente->id ? 'selected' : '' }}>
                                                {{ $asistente->nombre_completo }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('asistente_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Sección: Información Clínica --}}
                        <div class="mb-4">
                            <h6 class="border-bottom pb-2 mb-3">
                                <i class="bi bi-clipboard2-pulse text-warning me-2"></i>Información Clínica
                            </h6>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="tratamiento_id" class="form-label">Tratamiento Realizado</label>
                                    <select class="form-select @error('tratamiento_id') is-invalid @enderror" 
                                            id="tratamiento_id" name="tratamiento_id">
                                        <option value="">Sin tratamiento específico</option>
                                        @foreach($tratamientos as $tratamiento)
                                            <option value="{{ $tratamiento->id }}" {{ old('tratamiento_id', $expediente->tratamiento_id) == $tratamiento->id ? 'selected' : '' }}>
                                                {{ $tratamiento->nombre }} - Bs {{ number_format($tratamiento->precio_base, 2) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('tratamiento_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="diagnostico" class="form-label">Diagnóstico</label>
                                    <textarea class="form-control @error('diagnostico') is-invalid @enderror" 
                                              id="diagnostico" 
                                              name="diagnostico" 
                                              rows="3"
                                              placeholder="Descripción del diagnóstico clínico">{{ old('diagnostico', $expediente->diagnostico) }}</textarea>
                                    @error('diagnostico')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="descripcion_tratamiento" class="form-label">Descripción del Tratamiento</label>
                                    <textarea class="form-control @error('descripcion_tratamiento') is-invalid @enderror" 
                                              id="descripcion_tratamiento" 
                                              name="descripcion_tratamiento" 
                                              rows="4"
                                              placeholder="Detalles del procedimiento realizado">{{ old('descripcion_tratamiento', $expediente->descripcion_tratamiento) }}</textarea>
                                    @error('descripcion_tratamiento')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label for="observaciones" class="form-label">Observaciones Adicionales</label>
                                    <textarea class="form-control @error('observaciones') is-invalid @enderror" 
                                              id="observaciones" 
                                              name="observaciones" 
                                              rows="3"
                                              placeholder="Notas adicionales, recomendaciones, etc.">{{ old('observaciones', $expediente->observaciones) }}</textarea>
                                    @error('observaciones')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('expedientes.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-check-circle me-2"></i>Actualizar Expediente
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Información</h6>
                </div>
                <div class="card-body">
                    <p class="small mb-2"><strong>Expediente Médico:</strong></p>
                    <p class="small text-muted">
                        El expediente médico es el registro completo de la atención dental del paciente. 
                        Incluye diagnóstico, tratamiento realizado y observaciones clínicas.
                    </p>
                </div>
            </div>

            <div class="card shadow-sm mb-3">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="bi bi-lightbulb me-2"></i>Consejos</h6>
                </div>
                <div class="card-body">
                    <ul class="small mb-0">
                        <li class="mb-2">Registra el diagnóstico de forma clara y precisa</li>
                        <li class="mb-2">Detalla el tratamiento realizado paso a paso</li>
                        <li class="mb-2">Indica la pieza dental tratada si aplica</li>
                        <li class="mb-2">Incluye observaciones relevantes para futuras consultas</li>
                        <li>Vincula con la cita para mejor seguimiento</li>
                    </ul>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="bi bi-tooth me-2"></i>Nomenclatura Dental</h6>
                </div>
                <div class="card-body">
                    <p class="small mb-2"><strong>Sistema FDI (dos dígitos):</strong></p>
                    <ul class="small mb-0">
                        <li><strong>11-18:</strong> Cuadrante superior derecho</li>
                        <li><strong>21-28:</strong> Cuadrante superior izquierdo</li>
                        <li><strong>31-38:</strong> Cuadrante inferior izquierdo</li>
                        <li><strong>41-48:</strong> Cuadrante inferior derecho</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Ver Paciente - Dentista Muelitas')

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
    <div>
        <h1 class="h3">
            <i class="bi bi-person-circle text-primary"></i>
            {{ $paciente->nombre_completo }}
        </h1>
        <p class="text-muted">Detalles completos del paciente</p>
    </div>
    <div>
        <a href="{{ route('pacientes.edit', $paciente->id) }}" class="btn btn-warning">
            <i class="bi bi-pencil"></i> Editar
        </a>
        <a href="{{ route('pacientes.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>
</div>

<div class="row">
    <!-- Información del Paciente -->
    <div class="col-lg-8">
        <!-- Información Personal -->
        <div class="card shadow-sm mb-3">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-person"></i> Información Personal</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Nombre Completo</label>
                        <p class="mb-0"><strong>{{ $paciente->nombre_completo }}</strong></p>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="text-muted small">Fecha de Nacimiento</label>
                        <p class="mb-0">{{ $paciente->fecha_nacimiento->format('d/m/Y') }}</p>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="text-muted small">Género</label>
                        <p class="mb-0">
                            @if($paciente->genero == 'masculino')
                                <i class="bi bi-gender-male text-primary"></i> Masculino
                            @elseif($paciente->genero == 'femenino')
                                <i class="bi bi-gender-female text-danger"></i> Femenino
                            @else
                                <i class="bi bi-gender-ambiguous text-secondary"></i> Otro
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información de Contacto -->
        <div class="card shadow-sm mb-3">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-telephone"></i> Información de Contacto</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Teléfono</label>
                        <p class="mb-0">
                            <i class="bi bi-telephone-fill text-success"></i>
                            <a href="tel:{{ $paciente->telefono }}">{{ $paciente->telefono }}</a>
                        </p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Email</label>
                        <p class="mb-0">
                            @if($paciente->email)
                                <i class="bi bi-envelope-fill text-primary"></i>
                                <a href="mailto:{{ $paciente->email }}">{{ $paciente->email }}</a>
                            @else
                                <span class="text-muted">Sin email</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-8 mb-3">
                        <label class="text-muted small">Dirección</label>
                        <p class="mb-0">{{ $paciente->direccion }}</p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="text-muted small">Ciudad</label>
                        <p class="mb-0">{{ $paciente->ciudad }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información Médica -->
        <div class="card shadow-sm mb-3">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0"><i class="bi bi-heart-pulse"></i> Información Médica</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Alergias</label>
                        <p class="mb-0">
                            @if($paciente->alergias)
                                {{ $paciente->alergias }}
                            @else
                                <span class="text-muted">Sin alergias registradas</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Condiciones Médicas</label>
                        <p class="mb-0">
                            @if($paciente->condiciones_medicas)
                                {{ $paciente->condiciones_medicas }}
                            @else
                                <span class="text-muted">Sin condiciones registradas</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contacto de Emergencia -->
        <div class="card shadow-sm mb-3">
            <div class="card-header bg-warning">
                <h5 class="mb-0"><i class="bi bi-exclamation-triangle"></i> Contacto de Emergencia</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Contacto de Emergencia</label>
                        <p class="mb-0">
                            @if($paciente->contacto_emergencia)
                                <i class="bi bi-person-fill text-warning"></i>
                                {{ $paciente->contacto_emergencia }}
                            @else
                                <span class="text-muted">Sin contacto</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted small">Teléfono de Emergencia</label>
                        <p class="mb-0">
                            @if($paciente->telefono_emergencia)
                                <i class="bi bi-telephone-fill text-warning"></i>
                                <a href="tel:{{ $paciente->telefono_emergencia }}">{{ $paciente->telefono_emergencia }}</a>
                            @else
                                <span class="text-muted">Sin teléfono</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Información del Sistema -->
        <div class="card shadow-sm mb-3">
            <div class="card-header bg-secondary text-white">
                <h6 class="mb-0"><i class="bi bi-info-circle"></i> Información del Sistema</h6>
            </div>
            <div class="card-body">
                <p class="small mb-2">
                    <strong>ID:</strong> #{{ $paciente->id }}
                </p>
                <p class="small mb-2">
                    <strong>Registrado:</strong><br>
                    {{ $paciente->created_at->format('d/m/Y H:i') }}<br>
                    <span class="text-muted">({{ $paciente->created_at->diffForHumans() }})</span>
                </p>
                <p class="small mb-0">
                    <strong>Última actualización:</strong><br>
                    {{ $paciente->updated_at->format('d/m/Y H:i') }}<br>
                    <span class="text-muted">({{ $paciente->updated_at->diffForHumans() }})</span>
                </p>
            </div>
        </div>

        <!-- Resumen -->
        <div class="card shadow-sm mb-3">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0"><i class="bi bi-bar-chart"></i> Resumen</h6>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span><i class="bi bi-calendar-check"></i> Citas:</span>
                    <strong>{{ $paciente->citas->count() }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span><i class="bi bi-file-medical"></i> Expedientes:</span>
                    <strong>{{ $paciente->expedientes->count() }}</strong>
                </div>
                <div class="d-flex justify-content-between">
                    <span><i class="bi bi-receipt"></i> Facturas:</span>
                    <strong>{{ $paciente->facturas->count() }}</strong>
                </div>
            </div>
        </div>

        <!-- Acciones -->
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white">
                <h6 class="mb-0"><i class="bi bi-lightning"></i> Acciones Rápidas</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button class="btn btn-outline-success btn-sm" disabled>
                        <i class="bi bi-calendar-plus"></i> Nueva Cita
                    </button>
                    <button class="btn btn-outline-info btn-sm" disabled>
                        <i class="bi bi-file-earmark-medical"></i> Nuevo Expediente
                    </button>
                    <button class="btn btn-outline-warning btn-sm" disabled>
                        <i class="bi bi-receipt"></i> Nueva Factura
                    </button>
                    <hr>
                    <form action="{{ route('pacientes.destroy', $paciente->id) }}" 
                          method="POST" 
                          onsubmit="return confirm('¿Estás seguro de eliminar este paciente? Esta acción no se puede deshacer.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm w-100">
                            <i class="bi bi-trash"></i> Eliminar Paciente
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

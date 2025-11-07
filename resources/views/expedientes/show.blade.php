@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><i class="bi bi-file-medical text-info me-2"></i>Detalle del Expediente</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('expedientes.index') }}">Expedientes</a></li>
                    <li class="breadcrumb-item active">Detalle</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('expedientes.edit', $expediente->id) }}" class="btn btn-warning">
                <i class="bi bi-pencil me-2"></i>Editar
            </a>
            <form action="{{ route('expedientes.destroy', $expediente->id) }}" 
                  method="POST" 
                  class="d-inline"
                  onsubmit="return confirm('¿Está seguro de eliminar este expediente?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-trash me-2"></i>Eliminar
                </button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            {{-- Información del Paciente --}}
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-person-fill me-2"></i>Información del Paciente</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <p class="mb-1 text-muted small">Nombre Completo</p>
                            @if($expediente->paciente)
                                <h6>
                                    <a href="{{ route('pacientes.show', $expediente->paciente->id) }}" class="text-decoration-none">
                                        {{ $expediente->paciente->nombre_completo }}
                                    </a>
                                </h6>
                            @else
                                <p class="text-muted">Sin paciente</p>
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            <p class="mb-1 text-muted small">Fecha de Atención</p>
                            <h6>
                                <i class="bi bi-calendar3 text-info me-2"></i>
                                {{ \Carbon\Carbon::parse($expediente->fecha)->format('d/m/Y') }}
                                ({{ \Carbon\Carbon::parse($expediente->fecha)->locale('es')->isoFormat('dddd') }})
                            </h6>
                        </div>
                        @if($expediente->paciente)
                        <div class="col-md-6 mb-3">
                            <p class="mb-1 text-muted small">Teléfono</p>
                            <h6><i class="bi bi-telephone text-success me-2"></i>{{ $expediente->paciente->telefono }}</h6>
                        </div>
                        <div class="col-md-6 mb-3">
                            <p class="mb-1 text-muted small">Email</p>
                            <h6>
                                @if($expediente->paciente->email)
                                    <i class="bi bi-envelope text-primary me-2"></i>{{ $expediente->paciente->email }}
                                @else
                                    <span class="text-muted">No registrado</span>
                                @endif
                            </h6>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Personal Médico --}}
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-person-badge me-2"></i>Personal Médico</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <p class="mb-1 text-muted small">Odontólogo Responsable</p>
                            @if($expediente->odontologo)
                                <h6><i class="bi bi-person-check text-success me-2"></i>{{ $expediente->odontologo->nombre_completo }}</h6>
                            @else
                                <p class="text-muted">Sin asignar</p>
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            <p class="mb-1 text-muted small">Asistente/Enfermera</p>
                            @if($expediente->asistente)
                                <h6><i class="bi bi-person text-info me-2"></i>{{ $expediente->asistente->nombre_completo }}</h6>
                            @else
                                <p class="text-muted">Sin asistente</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Información Clínica --}}
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="bi bi-clipboard2-pulse me-2"></i>Información Clínica</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-1 text-muted small">Tratamiento Realizado</p>
                            @if($expediente->tratamiento)
                                <h6>
                                    <a href="{{ route('tratamientos.show', $expediente->tratamiento->id) }}" class="text-decoration-none">
                                        <i class="bi bi-clipboard2-pulse text-warning me-2"></i>{{ $expediente->tratamiento->nombre }}
                                    </a>
                                </h6>
                                <p class="mb-0 small"><strong>Precio base:</strong> Bs {{ number_format($expediente->tratamiento->precio_base, 2) }}</p>
                            @else
                                <p class="text-muted">Sin tratamiento específico</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1 text-muted small">Pieza Dental</p>
                            @if($expediente->pieza_dental)
                                <h6>
                                    <span class="badge bg-secondary" style="font-size: 1.1rem;">
                                        <i class="bi bi-tooth me-1"></i>{{ $expediente->pieza_dental }}
                                    </span>
                                </h6>
                            @else
                                <p class="text-muted">No especificada</p>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3">
                        <p class="mb-2 text-muted small">Diagnóstico</p>
                        @if($expediente->diagnostico)
                            <div class="p-3 bg-light border-start border-info border-4">
                                {{ $expediente->diagnostico }}
                            </div>
                        @else
                            <p class="text-muted fst-italic">Sin diagnóstico registrado</p>
                        @endif
                    </div>

                    <div class="mb-3">
                        <p class="mb-2 text-muted small">Descripción del Tratamiento</p>
                        @if($expediente->descripcion_tratamiento)
                            <div class="p-3 bg-light border-start border-warning border-4">
                                {{ $expediente->descripcion_tratamiento }}
                            </div>
                        @else
                            <p class="text-muted fst-italic">Sin descripción del tratamiento</p>
                        @endif
                    </div>

                    <div>
                        <p class="mb-2 text-muted small">Observaciones Adicionales</p>
                        @if($expediente->observaciones)
                            <div class="p-3 bg-light border-start border-secondary border-4">
                                {{ $expediente->observaciones }}
                            </div>
                        @else
                            <p class="text-muted fst-italic">Sin observaciones adicionales</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            {{-- Acciones Rápidas --}}
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="bi bi-lightning-charge me-2"></i>Acciones Rápidas</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('expedientes.edit', $expediente->id) }}" class="btn btn-outline-warning btn-sm">
                            <i class="bi bi-pencil me-2"></i>Editar Expediente
                        </a>
                        @if($expediente->paciente)
                        <a href="{{ route('pacientes.show', $expediente->paciente->id) }}" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-person me-2"></i>Ver Paciente
                        </a>
                        @endif
                        @if($expediente->tratamiento)
                        <a href="{{ route('tratamientos.show', $expediente->tratamiento->id) }}" class="btn btn-outline-warning btn-sm">
                            <i class="bi bi-clipboard2-pulse me-2"></i>Ver Tratamiento
                        </a>
                        @endif
                        @if($expediente->cita)
                        <a href="{{ route('citas.show', $expediente->cita->id) }}" class="btn btn-outline-info btn-sm">
                            <i class="bi bi-calendar-check me-2"></i>Ver Cita
                        </a>
                        @endif
                        <a href="{{ route('expedientes.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-arrow-left me-2"></i>Volver al Listado
                        </a>
                    </div>
                </div>
            </div>

            {{-- Información del Sistema --}}
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="bi bi-gear me-2"></i>Información del Sistema</h6>
                </div>
                <div class="card-body">
                    <p class="mb-2 small"><strong>ID Expediente:</strong> #{{ str_pad($expediente->id, 4, '0', STR_PAD_LEFT) }}</p>
                    <p class="mb-2 small"><strong>Registrado:</strong> {{ $expediente->created_at->format('d/m/Y H:i') }}</p>
                    <p class="mb-0 small"><strong>Última actualización:</strong> {{ $expediente->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>

            {{-- Estadísticas del Paciente --}}
            @if($expediente->paciente)
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="bi bi-graph-up me-2"></i>Historial del Paciente</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="small">Total expedientes:</span>
                        <strong class="text-info">{{ $expediente->paciente->expedientes->count() }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="small">Total citas:</span>
                        <strong class="text-primary">{{ $expediente->paciente->citas->count() }}</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="small">Total facturas:</span>
                        <strong class="text-success">{{ $expediente->paciente->facturas->count() }}</strong>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Detalle de Cita - Dentista Muelitas')

@section('content')
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('citas.index') }}">Citas</a></li>
        <li class="breadcrumb-item active">Cita #{{ $cita->id }}</li>
    </ol>
</nav>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">
        <i class="bi bi-calendar-check text-primary"></i>
        Detalle de Cita #{{ $cita->id }}
    </h1>
    <div>
        <a href="{{ route('citas.edit', $cita->id) }}" class="btn btn-warning">
            <i class="bi bi-pencil"></i> Editar
        </a>
        <form action="{{ route('citas.destroy', $cita->id) }}" 
              method="POST" 
              class="d-inline"
              onsubmit="return confirm('¿Estás seguro de eliminar esta cita?');">
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
        <!-- Información de la Cita -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="bi bi-calendar-event"></i> Información de la Cita
                </h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Fecha</h6>
                        <p class="h5">
                            <i class="bi bi-calendar3 text-primary"></i>
                            {{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}
                            ({{ \Carbon\Carbon::parse($cita->fecha)->locale('es')->isoFormat('dddd') }})
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Hora</h6>
                        <p class="h5">
                            <i class="bi bi-clock text-info"></i>
                            {{ \Carbon\Carbon::parse($cita->hora)->format('H:i') }}
                        </p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <h6 class="text-muted mb-2">Estado</h6>
                        <p>
                            @if($cita->estado == 'pendiente')
                                <span class="badge bg-warning text-dark fs-6">
                                    <i class="bi bi-clock-history"></i> Pendiente
                                </span>
                            @elseif($cita->estado == 'confirmada')
                                <span class="badge bg-info fs-6">
                                    <i class="bi bi-check-circle"></i> Confirmada
                                </span>
                            @elseif($cita->estado == 'completada')
                                <span class="badge bg-success fs-6">
                                    <i class="bi bi-check-all"></i> Completada
                                </span>
                            @else
                                <span class="badge bg-danger fs-6">
                                    <i class="bi bi-x-circle"></i> Cancelada
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
                        <h6 class="text-muted mb-2">Nombre Completo</h6>
                        <p>
                            <i class="bi bi-person-circle text-primary"></i>
                            <a href="{{ route('pacientes.show', $cita->paciente->id) }}">
                                {{ $cita->paciente->nombre_completo }}
                            </a>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Teléfono</h6>
                        <p>
                            <i class="bi bi-telephone text-success"></i>
                            {{ $cita->paciente->telefono }}
                        </p>
                    </div>
                </div>

                @if($cita->paciente->email)
                <div class="row">
                    <div class="col-md-12">
                        <h6 class="text-muted mb-2">Email</h6>
                        <p>
                            <i class="bi bi-envelope text-info"></i>
                            {{ $cita->paciente->email }}
                        </p>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Detalles del Servicio -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">
                    <i class="bi bi-clipboard2-pulse"></i> Detalles del Servicio
                </h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Odontólogo</h6>
                        <p>
                            @if($cita->usuario)
                                <i class="bi bi-person-badge text-info"></i>
                                {{ $cita->usuario->nombre_completo }}
                            @else
                                <span class="text-muted">Sin asignar</span>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-2">Tratamiento</h6>
                        <p>
                            @if($cita->tratamiento)
                                <i class="bi bi-clipboard2-check text-success"></i>
                                <a href="{{ route('tratamientos.show', $cita->tratamiento->id) }}">
                                    {{ $cita->tratamiento->nombre }}
                                </a>
                                <br>
                                <small class="text-muted">
                                    Precio base: <strong>Bs {{ number_format($cita->tratamiento->precio_base, 2) }}</strong>
                                </small>
                            @else
                                <span class="text-muted">Sin tratamiento específico</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <h6 class="text-muted mb-2">Motivo de la Consulta</h6>
                        <p class="border-start border-primary border-4 ps-3">
                            {{ $cita->motivo }}
                        </p>
                    </div>
                </div>

                @if($cita->observaciones)
                <div class="row">
                    <div class="col-md-12">
                        <h6 class="text-muted mb-2">Observaciones</h6>
                        <p class="border-start border-info border-4 ps-3 text-muted">
                            {{ $cita->observaciones }}
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
                    <a href="{{ route('citas.edit', $cita->id) }}" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-pencil"></i> Editar Cita
                    </a>
                    <a href="{{ route('pacientes.show', $cita->paciente->id) }}" class="btn btn-outline-info btn-sm">
                        <i class="bi bi-person-fill"></i> Ver Paciente
                    </a>
                    @if($cita->tratamiento)
                    <a href="{{ route('tratamientos.show', $cita->tratamiento->id) }}" class="btn btn-outline-success btn-sm">
                        <i class="bi bi-clipboard2-pulse"></i> Ver Tratamiento
                    </a>
                    @endif
                    <a href="{{ route('citas.index') }}" class="btn btn-outline-secondary btn-sm">
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
                <p class="small mb-1"><strong>ID de Cita:</strong> {{ $cita->id }}</p>
                <p class="small mb-1"><strong>Registrado:</strong> {{ $cita->created_at->format('d/m/Y H:i') }}</p>
                <p class="small mb-0"><strong>Última actualización:</strong> {{ $cita->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        <!-- Estadísticas del Paciente -->
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="card-title">
                    <i class="bi bi-bar-chart text-info"></i> Estadísticas del Paciente
                </h6>
                <p class="small mb-1">
                    <strong>Total de citas:</strong> 
                    {{ $cita->paciente->citas->count() }}
                </p>
                <p class="small mb-1">
                    <strong>Citas completadas:</strong> 
                    {{ $cita->paciente->citas->where('estado', 'completada')->count() }}
                </p>
                <p class="small mb-0">
                    <strong>Citas pendientes:</strong> 
                    {{ $cita->paciente->citas->whereIn('estado', ['pendiente', 'confirmada'])->count() }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

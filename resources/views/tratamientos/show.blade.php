@extends('layouts.app')

@section('title', 'Detalle Tratamiento - Dentista Muelitas')

@section('content')
<div class="mb-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('tratamientos.index') }}">Tratamientos</a></li>
            <li class="breadcrumb-item active">{{ $tratamiento->nombre }}</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="h3">
            <i class="bi bi-tooth text-info"></i>
            {{ $tratamiento->nombre }}
        </h1>
        <div>
            <a href="{{ route('tratamientos.edit', $tratamiento->id) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Editar
            </a>
            <form action="{{ route('tratamientos.destroy', $tratamiento->id) }}" 
                  method="POST" 
                  class="d-inline"
                  onsubmit="return confirm('¿Estás seguro de eliminar este tratamiento? Esta acción no se puede deshacer.');">
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
        <!-- Descripción -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <i class="bi bi-clipboard2-pulse"></i> Descripción del Tratamiento
            </div>
            <div class="card-body">
                @if($tratamiento->descripcion)
                    <p class="card-text" style="white-space: pre-line;">{{ $tratamiento->descripcion }}</p>
                @else
                    <p class="text-muted fst-italic">No hay descripción disponible para este tratamiento.</p>
                @endif
            </div>
        </div>

        <!-- Información Económica y Temporal -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card shadow-sm border-success">
                    <div class="card-body text-center">
                        <i class="bi bi-currency-dollar text-success" style="font-size: 2.5rem;"></i>
                        <h5 class="card-title mt-2">Precio Base</h5>
                        <h3 class="text-success mb-0">Bs {{ number_format($tratamiento->precio_base, 2) }}</h3>
                        <small class="text-muted">Precio estándar</small>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm border-info">
                    <div class="card-body text-center">
                        <i class="bi bi-clock text-info" style="font-size: 2.5rem;"></i>
                        <h5 class="card-title mt-2">Duración</h5>
                        <h3 class="text-info mb-0">{{ $tratamiento->duracion_minutos }} min</h3>
                        <small class="text-muted">Tiempo aproximado</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Citas Relacionadas -->
        <div class="card shadow-sm">
            <div class="card-header bg-secondary text-white">
                <i class="bi bi-calendar-check"></i> Citas con este Tratamiento
            </div>
            <div class="card-body">
                @if($tratamiento->citas->isEmpty())
                    <div class="text-center py-4">
                        <i class="bi bi-calendar-x" style="font-size: 3rem; color: #ccc;"></i>
                        <p class="text-muted mt-2">Aún no hay citas programadas con este tratamiento</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Paciente</th>
                                    <th>Estado</th>
                                    <th>Odontólogo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tratamiento->citas->take(10) as $cita)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($cita->hora)->format('H:i') }}</td>
                                        <td>
                                            <a href="{{ route('pacientes.show', $cita->paciente_id) }}">
                                                {{ $cita->paciente->nombre_completo }}
                                            </a>
                                        </td>
                                        <td>
                                            @if($cita->estado == 'programada')
                                                <span class="badge bg-primary">Programada</span>
                                            @elseif($cita->estado == 'confirmada')
                                                <span class="badge bg-info">Confirmada</span>
                                            @elseif($cita->estado == 'completada')
                                                <span class="badge bg-success">Completada</span>
                                            @elseif($cita->estado == 'cancelada')
                                                <span class="badge bg-danger">Cancelada</span>
                                            @endif
                                        </td>
                                        <td>{{ $cita->usuario->nombre }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if($tratamiento->citas->count() > 10)
                            <p class="text-muted small text-center mt-2">
                                Mostrando las 10 citas más recientes de {{ $tratamiento->citas->count() }} totales
                            </p>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Panel Lateral -->
    <div class="col-lg-4">
        <!-- Información del Registro -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-dark text-white">
                <i class="bi bi-info-circle"></i> Información del Registro
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <strong><i class="bi bi-hash"></i> ID:</strong><br>
                        <span class="text-muted">#{{ $tratamiento->id }}</span>
                    </li>
                    <li class="mb-2">
                        <strong><i class="bi bi-calendar-plus"></i> Fecha de Registro:</strong><br>
                        <span class="text-muted">{{ $tratamiento->created_at->format('d/m/Y H:i') }}</span>
                    </li>
                    <li class="mb-2">
                        <strong><i class="bi bi-calendar-check"></i> Última Modificación:</strong><br>
                        <span class="text-muted">{{ $tratamiento->updated_at->format('d/m/Y H:i') }}</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Estadísticas -->
        <div class="card shadow-sm mb-4 border-primary">
            <div class="card-header bg-primary text-white">
                <i class="bi bi-graph-up"></i> Estadísticas
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <i class="bi bi-calendar-check text-primary" style="font-size: 2rem;"></i>
                    </div>
                    <div class="text-end">
                        <h4 class="mb-0">{{ $tratamiento->citas->count() }}</h4>
                        <small class="text-muted">Citas Totales</small>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <i class="bi bi-check-circle text-success" style="font-size: 2rem;"></i>
                    </div>
                    <div class="text-end">
                        <h4 class="mb-0">{{ $tratamiento->citas->where('estado', 'completada')->count() }}</h4>
                        <small class="text-muted">Citas Completadas</small>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <i class="bi bi-clock-history text-info" style="font-size: 2rem;"></i>
                    </div>
                    <div class="text-end">
                        <h4 class="mb-0">{{ $tratamiento->citas->whereIn('estado', ['programada', 'confirmada'])->count() }}</h4>
                        <small class="text-muted">Citas Pendientes</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Acciones Rápidas -->
        <div class="card shadow-sm border-success">
            <div class="card-header bg-success text-white">
                <i class="bi bi-lightning"></i> Acciones Rápidas
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('tratamientos.edit', $tratamiento->id) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Editar Tratamiento
                    </a>
                    <a href="{{ route('tratamientos.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Volver al Listado
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

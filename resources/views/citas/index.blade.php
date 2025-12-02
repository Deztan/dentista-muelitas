@extends('layouts.app')

@section('title', 'Citas - Dentista Muelitas')

@section('content')
<!-- ESTÁNDAR: Encabezado de reporte alineado con botón de acción -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3">
            <i class="bi bi-calendar-check text-primary"></i>
            Agenda de Citas
        </h1>
        <p class="text-muted mb-0">Listado completo de citas agendadas</p>
    </div>
    <a href="{{ route('citas.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Nueva Cita
    </a>
</div>

<!-- ESTÁNDAR: Contenido de reporte en tabla con paginación -->
<div class="card shadow-sm">
    <div class="card-body">
        @if($citas->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-calendar-x" style="font-size: 4rem; color: #ccc;"></i>
                <p class="text-muted mt-3">No hay citas agendadas</p>
                <a href="{{ route('citas.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i> Agendar primera cita
                </a>
            </div>
        @else
            <!-- ESTÁNDAR: Tabla de reporte -->
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Fecha y Hora</th>
                            <th>Paciente</th>
                            <th>Odontólogo</th>
                            <th>Tratamiento</th>
                            <th>Motivo</th>
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($citas as $cita)
                            <tr>
                                <!-- ACCESIBILIDAD: data-label para responsive móvil -->
                                <td data-label="Fecha y Hora">
                                    <strong>{{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}</strong>
                                    <br>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($cita->hora)->format('H:i') }}</small>
                                </td>
                                <td data-label="Paciente">
                                    <i class="bi bi-person-fill text-primary me-2"></i>
                                    {{ $cita->paciente->nombre_completo }}
                                </td>
                                <td data-label="Odontólogo">
                                    @if($cita->odontologo)
                                        <i class="bi bi-person-badge text-info me-2"></i>
                                        {{ $cita->odontologo->nombre_completo }}
                                    @else
                                        <span class="text-muted">Sin asignar</span>
                                    @endif
                                </td>
                                <td data-label="Tratamiento">
                                    @if($cita->tratamiento)
                                        <i class="bi bi-clipboard2-pulse text-success me-2"></i>
                                        {{ $cita->tratamiento->nombre }}
                                    @else
                                        <span class="text-muted">Sin tratamiento</span>
                                    @endif
                                </td>
                                <td data-label="Motivo">
                                    <small>{{ Str::limit($cita->motivo, 40) }}</small>
                                </td>
                                <td data-label="Estado">
                                    @if($cita->estado == 'agendada')
                                        <span class="badge bg-warning text-dark">Agendada</span>
                                    @elseif($cita->estado == 'confirmada')
                                        <span class="badge bg-info">Confirmada</span>
                                    @elseif($cita->estado == 'completada')
                                        <span class="badge bg-success">Completada</span>
                                    @elseif($cita->estado == 'cancelada')
                                        <span class="badge bg-danger">Cancelada</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($cita->estado) }}</span>
                                    @endif
                                </td>
                                <!-- ESTÁNDAR: Botones con iconos a la izquierda - ACCESIBILIDAD: data-label -->
                                <td data-label="Acciones" class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('citas.show', $cita->id) }}" 
                                           class="btn btn-info" 
                                           title="Ver detalles">
                                            <i class="bi bi-eye me-1"></i>
                                        </a>
                                        <a href="{{ route('citas.edit', $cita->id) }}" 
                                           class="btn btn-warning" 
                                           title="Editar">
                                            <i class="bi bi-pencil me-1"></i>
                                        </a>
                                        <form action="{{ route('citas.destroy', $cita->id) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('¿Estás seguro de eliminar esta cita?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                                <i class="bi bi-trash me-1"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- ESTÁNDAR: Paginación en parte inferior del reporte -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted">
                    <i class="bi bi-list-ul me-1"></i>
                    Mostrando {{ $citas->firstItem() }} - {{ $citas->lastItem() }} de {{ $citas->total() }} citas
                </div>
                <div>
                    {{ $citas->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

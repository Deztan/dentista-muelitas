@extends('layouts.app')

@section('title', 'Citas - Dentista Muelitas')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">
        <i class="bi bi-calendar-check text-primary"></i>
        Agenda de Citas
    </h1>
    <a href="{{ route('citas.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Nueva Cita
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        @if($citas->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-calendar-x" style="font-size: 4rem; color: #ccc;"></i>
                <p class="text-muted mt-3">No hay citas agendadas</p>
                <a href="{{ route('citas.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Agendar primera cita
                </a>
            </div>
        @else
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
                                <td>
                                    <strong>{{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}</strong>
                                    <br>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($cita->hora)->format('H:i') }}</small>
                                </td>
                                <td>
                                    <i class="bi bi-person-fill text-primary me-2"></i>
                                    {{ $cita->paciente->nombre_completo }}
                                </td>
                                <td>
                                    @if($cita->usuario)
                                        <i class="bi bi-person-badge text-info me-2"></i>
                                        {{ $cita->usuario->nombre_completo }}
                                    @else
                                        <span class="text-muted">Sin asignar</span>
                                    @endif
                                </td>
                                <td>
                                    @if($cita->tratamiento)
                                        <i class="bi bi-clipboard2-pulse text-success me-2"></i>
                                        {{ $cita->tratamiento->nombre }}
                                    @else
                                        <span class="text-muted">Sin tratamiento</span>
                                    @endif
                                </td>
                                <td>
                                    <small>{{ Str::limit($cita->motivo, 40) }}</small>
                                </td>
                                <td>
                                    @if($cita->estado == 'pendiente')
                                        <span class="badge bg-warning text-dark">Pendiente</span>
                                    @elseif($cita->estado == 'confirmada')
                                        <span class="badge bg-info">Confirmada</span>
                                    @elseif($cita->estado == 'completada')
                                        <span class="badge bg-success">Completada</span>
                                    @else
                                        <span class="badge bg-danger">Cancelada</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('citas.show', $cita->id) }}" 
                                           class="btn btn-info" 
                                           title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('citas.edit', $cita->id) }}" 
                                           class="btn btn-warning" 
                                           title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('citas.destroy', $cita->id) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('¿Estás seguro de eliminar esta cita?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted">
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

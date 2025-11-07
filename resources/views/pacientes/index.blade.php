@extends('layouts.app')

@section('title', 'Pacientes - Dentista Muelitas')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">
        <i class="bi bi-people text-primary"></i>
        Gestión de Pacientes
    </h1>
    <a href="{{ route('pacientes.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Nuevo Paciente
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        @if($pacientes->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-inbox" style="font-size: 4rem; color: #ccc;"></i>
                <p class="text-muted mt-3">No hay pacientes registrados</p>
                <a href="{{ route('pacientes.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Crear primer paciente
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nombre Completo</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th>Ciudad</th>
                            <th>Fecha Nacimiento</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pacientes as $paciente)
                            <tr>
                                <td><strong>#{{ $paciente->id }}</strong></td>
                                <td>
                                    <i class="bi bi-person-circle text-primary me-2"></i>
                                    {{ $paciente->nombre_completo }}
                                </td>
                                <td>
                                    <i class="bi bi-telephone"></i>
                                    {{ $paciente->telefono }}
                                </td>
                                <td>
                                    @if($paciente->email)
                                        <i class="bi bi-envelope"></i>
                                        {{ $paciente->email }}
                                    @else
                                        <span class="text-muted">Sin email</span>
                                    @endif
                                </td>
                                <td>{{ $paciente->ciudad }}</td>
                                <td>{{ $paciente->fecha_nacimiento->format('d/m/Y') }}</td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('pacientes.show', $paciente->id) }}" 
                                           class="btn btn-info" 
                                           title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('pacientes.edit', $paciente->id) }}" 
                                           class="btn btn-warning" 
                                           title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('pacientes.destroy', $paciente->id) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('¿Estás seguro de eliminar este paciente?');">
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
                    Mostrando {{ $pacientes->firstItem() }} - {{ $pacientes->lastItem() }} de {{ $pacientes->total() }} pacientes
                </div>
                <div>
                    {{ $pacientes->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

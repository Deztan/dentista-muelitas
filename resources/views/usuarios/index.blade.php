@extends('layouts.app')

@section('title', 'Gestión de Usuarios')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <h2><i class="bi bi-people-fill"></i> Gestión de Usuarios</h2>
            <p class="text-muted">Administra los usuarios del sistema</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('usuarios.create') }}" class="btn btn-primary">
                <i class="bi bi-person-plus-fill"></i> Nuevo Usuario
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nombre Completo</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Rol</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($usuarios as $usuario)
                            <tr>
                                <td>{{ $usuario->id }}</td>
                                <td>{{ $usuario->nombre_completo }}</td>
                                <td>{{ $usuario->email }}</td>
                                <td>{{ $usuario->telefono }}</td>
                                <td>
                                    @php
                                        $rolColors = [
                                            'gerente' => 'danger',
                                            'odontologo' => 'primary',
                                            'asistente_directo' => 'warning',
                                            'recepcionista' => 'info',
                                            'enfermera' => 'success'
                                        ];
                                        $rolNames = [
                                            'gerente' => 'Gerente',
                                            'odontologo' => 'Odontólogo',
                                            'asistente_directo' => 'Asistente Directo',
                                            'recepcionista' => 'Recepcionista',
                                            'enfermera' => 'Enfermera'
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $rolColors[$usuario->rol] ?? 'secondary' }}">
                                        {{ $rolNames[$usuario->rol] ?? $usuario->rol }}
                                    </span>
                                </td>
                                <td>
                                    @if($usuario->activo)
                                        <span class="badge bg-success">Activo</span>
                                    @else
                                        <span class="badge bg-secondary">Inactivo</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('usuarios.show', $usuario) }}" 
                                           class="btn btn-outline-info" 
                                           title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('usuarios.edit', $usuario) }}" 
                                           class="btn btn-outline-warning" 
                                           title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        @if($usuario->id !== Auth::id())
                                            <button type="button" 
                                                    class="btn btn-outline-danger" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#deleteModal{{ $usuario->id }}"
                                                    title="Eliminar">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        @endif
                                    </div>

                                    <!-- Modal de confirmación de eliminación -->
                                    @if($usuario->id !== Auth::id())
                                        <div class="modal fade" id="deleteModal{{ $usuario->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Confirmar Eliminación</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        ¿Estás seguro de que deseas eliminar al usuario <strong>{{ $usuario->nombre_completo }}</strong>?
                                                        <br><small class="text-danger">Esta acción no se puede deshacer.</small>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                        <form action="{{ route('usuarios.destroy', $usuario) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Eliminar</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                                    <p class="mt-2">No hay usuarios registrados</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center">
                {{ $usuarios->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

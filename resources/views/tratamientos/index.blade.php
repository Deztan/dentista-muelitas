@extends('layouts.app')

@section('title', 'Tratamientos - Dentista Muelitas')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">
        <i class="bi bi-clipboard2-pulse text-primary"></i>
        Catálogo de Tratamientos
    </h1>
    <a href="{{ route('tratamientos.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Nuevo Tratamiento
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        @if($tratamientos->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-inbox" style="font-size: 4rem; color: #ccc;"></i>
                <p class="text-muted mt-3">No hay tratamientos registrados</p>
                <a href="{{ route('tratamientos.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Crear primer tratamiento
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Precio Base</th>
                            <th>Duración</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tratamientos as $tratamiento)
                            <tr>
                                <td><strong>#{{ $tratamiento->id }}</strong></td>
                                <td>
                                    <i class="bi bi-tooth text-info me-2"></i>
                                    {{ $tratamiento->nombre }}
                                </td>
                                <td class="text-muted small">
                                    {{ Str::limit($tratamiento->descripcion, 50) ?? 'Sin descripción' }}
                                </td>
                                <td>
                                    <strong class="text-success">Bs {{ number_format($tratamiento->precio_base, 2) }}</strong>
                                </td>
                                <td>
                                    <i class="bi bi-clock"></i> {{ $tratamiento->duracion_minutos }} min
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('tratamientos.show', $tratamiento->id) }}" 
                                           class="btn btn-info" 
                                           title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('tratamientos.edit', $tratamiento->id) }}" 
                                           class="btn btn-warning" 
                                           title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('tratamientos.destroy', $tratamiento->id) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('¿Estás seguro de eliminar este tratamiento?');">
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
                    Mostrando {{ $tratamientos->firstItem() }} - {{ $tratamientos->lastItem() }} de {{ $tratamientos->total() }} tratamientos
                </div>
                <div>
                    {{ $tratamientos->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

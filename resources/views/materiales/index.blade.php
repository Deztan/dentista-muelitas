@extends('layouts.app')

@section('title', 'Materiales - Dentista Muelitas')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">
        <i class="bi bi-box-seam text-primary"></i>
        Inventario de Materiales
    </h1>
    <a href="{{ route('materiales.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Nuevo Material
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        @if($materiales->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-inbox" style="font-size: 4rem; color: #ccc;"></i>
                <p class="text-muted mt-3">No hay materiales registrados en el inventario</p>
                <a href="{{ route('materiales.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Crear primer material
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Unidad</th>
                            <th>Stock Actual</th>
                            <th>Stock Mínimo</th>
                            <th>Precio Unitario</th>
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($materiales as $material)
                            <tr>
                                <td><strong>#{{ $material->id }}</strong></td>
                                <td>
                                    <i class="bi bi-box text-primary me-2"></i>
                                    {{ $material->nombre }}
                                </td>
                                <td>{{ $material->unidad_medida }}</td>
                                <td>
                                    <strong>{{ $material->stock_actual }}</strong>
                                </td>
                                <td>{{ $material->stock_minimo }}</td>
                                <td>
                                    <strong class="text-success">Bs {{ number_format($material->precio_unitario, 2) }}</strong>
                                </td>
                                <td>
                                    @if($material->stock_actual <= 0)
                                        <span class="badge bg-danger">Sin Stock</span>
                                    @elseif($material->stock_actual <= $material->stock_minimo)
                                        <span class="badge bg-warning text-dark">Stock Bajo</span>
                                    @else
                                        <span class="badge bg-success">Disponible</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('materiales.show', $material->id) }}" 
                                           class="btn btn-info" 
                                           title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('materiales.edit', $material->id) }}" 
                                           class="btn btn-warning" 
                                           title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('materiales.destroy', $material->id) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('¿Estás seguro de eliminar este material?');">
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
                    Mostrando {{ $materiales->firstItem() }} - {{ $materiales->lastItem() }} de {{ $materiales->total() }} materiales
                </div>
                <div>
                    {{ $materiales->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

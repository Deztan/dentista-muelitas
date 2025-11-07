@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><i class="bi bi-file-medical text-info me-2"></i>Expedientes Médicos</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                    <li class="breadcrumb-item active">Expedientes</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('expedientes.create') }}" class="btn btn-info">
            <i class="bi bi-plus-circle me-2"></i>Nuevo Expediente
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            @if($expedientes->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-file-medical" style="font-size: 4rem; color: #ccc;"></i>
                    <p class="text-muted mt-3">No hay expedientes registrados</p>
                    <a href="{{ route('expedientes.create') }}" class="btn btn-info">
                        <i class="bi bi-plus-circle me-2"></i>Crear Primer Expediente
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Fecha</th>
                                <th>Paciente</th>
                                <th>Odontólogo</th>
                                <th>Tratamiento</th>
                                <th>Pieza Dental</th>
                                <th>Diagnóstico</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($expedientes as $expediente)
                                <tr>
                                    <td>
                                        <i class="bi bi-calendar3 text-info me-2"></i>
                                        {{ \Carbon\Carbon::parse($expediente->fecha)->format('d/m/Y') }}
                                    </td>
                                    <td>
                                        <i class="bi bi-person-fill text-primary me-2"></i>
                                        @if($expediente->paciente)
                                            {{ $expediente->paciente->nombre_completo }}
                                        @else
                                            <span class="text-muted">Sin paciente</span>
                                        @endif
                                    </td>
                                    <td>
                                        <i class="bi bi-person-badge text-success me-2"></i>
                                        @if($expediente->odontologo)
                                            {{ $expediente->odontologo->nombre_completo }}
                                        @else
                                            <span class="text-muted">Sin asignar</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($expediente->tratamiento)
                                            <i class="bi bi-clipboard2-pulse text-warning me-2"></i>
                                            {{ $expediente->tratamiento->nombre }}
                                        @else
                                            <span class="text-muted">Sin tratamiento</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($expediente->pieza_dental)
                                            <span class="badge bg-secondary">
                                                <i class="bi bi-tooth me-1"></i>{{ $expediente->pieza_dental }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($expediente->diagnostico)
                                            {{ Str::limit($expediente->diagnostico, 50) }}
                                        @else
                                            <span class="text-muted">Sin diagnóstico</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('expedientes.show', $expediente->id) }}" 
                                               class="btn btn-outline-info" title="Ver detalles">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('expedientes.edit', $expediente->id) }}" 
                                               class="btn btn-outline-warning" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('expedientes.destroy', $expediente->id) }}" 
                                                  method="POST" class="d-inline"
                                                  onsubmit="return confirm('¿Está seguro de eliminar este expediente?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger" title="Eliminar">
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

                <div class="mt-3">
                    {{ $expedientes->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

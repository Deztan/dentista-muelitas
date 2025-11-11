@extends('layouts.app')

@section('title', 'Detalle de Usuario')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <h2><i class="bi bi-person-badge"></i> Detalle de Usuario</h2>
            <p class="text-muted">Información completa del usuario</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Editar
            </a>
            <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-person-circle" style="font-size: 6rem; color: #0d6efd;"></i>
                    </div>
                    <h4>{{ $usuario->nombre_completo }}</h4>
                    <p class="text-muted">{{ $usuario->email }}</p>
                    
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
                    
                    <span class="badge bg-{{ $rolColors[$usuario->rol] ?? 'secondary' }} mb-2">
                        {{ $rolNames[$usuario->rol] ?? $usuario->rol }}
                    </span>
                    <br>
                    @if($usuario->activo)
                        <span class="badge bg-success">Activo</span>
                    @else
                        <span class="badge bg-secondary">Inactivo</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-8 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-info-circle"></i> Información Personal</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="text-muted small">ID del Usuario</label>
                            <p class="fw-bold">{{ $usuario->id }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">Nombre Completo</label>
                            <p class="fw-bold">{{ $usuario->nombre_completo }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="text-muted small">Email</label>
                            <p class="fw-bold">
                                <i class="bi bi-envelope"></i> {{ $usuario->email }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">Teléfono</label>
                            <p class="fw-bold">
                                <i class="bi bi-telephone"></i> {{ $usuario->telefono }}
                            </p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="text-muted small">Rol en el Sistema</label>
                            <p class="fw-bold">{{ $rolNames[$usuario->rol] ?? $usuario->rol }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">Estado</label>
                            <p class="fw-bold">
                                @if($usuario->activo)
                                    <i class="bi bi-check-circle text-success"></i> Activo
                                @else
                                    <i class="bi bi-x-circle text-danger"></i> Inactivo
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label class="text-muted small">Fecha de Registro</label>
                            <p class="fw-bold">
                                <i class="bi bi-calendar-plus"></i> 
                                {{ $usuario->created_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">Última Actualización</label>
                            <p class="fw-bold">
                                <i class="bi bi-calendar-check"></i> 
                                {{ $usuario->updated_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mt-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="bi bi-graph-up"></i> Estadísticas</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-4">
                            <div class="p-3">
                                <i class="bi bi-calendar-event" style="font-size: 2rem; color: #0d6efd;"></i>
                                <h3 class="mt-2">{{ $usuario->citas->count() }}</h3>
                                <p class="text-muted">Citas Asignadas</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3">
                                <i class="bi bi-file-medical" style="font-size: 2rem; color: #198754;"></i>
                                <h3 class="mt-2">{{ $usuario->expedientes->count() }}</h3>
                                <p class="text-muted">Expedientes Gestionados</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3">
                                <i class="bi bi-clock-history" style="font-size: 2rem; color: #ffc107;"></i>
                                <h3 class="mt-2">{{ $usuario->created_at->diffForHumans() }}</h3>
                                <p class="text-muted">En el Sistema</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Editar Usuario')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col">
            <h2><i class="bi bi-pencil-square"></i> Editar Usuario</h2>
            <p class="text-muted">Actualiza la información del usuario</p>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('usuarios.update', $usuario) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nombre_completo" class="form-label">
                            <i class="bi bi-person"></i> Nombre Completo <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('nombre_completo') is-invalid @enderror" 
                               id="nombre_completo" 
                               name="nombre_completo" 
                               value="{{ old('nombre_completo', $usuario->nombre_completo) }}" 
                               required>
                        @error('nombre_completo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">
                            <i class="bi bi-envelope"></i> Email <span class="text-danger">*</span>
                        </label>
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email', $usuario->email) }}" 
                               required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="telefono" class="form-label">
                            <i class="bi bi-telephone"></i> Teléfono <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('telefono') is-invalid @enderror" 
                               id="telefono" 
                               name="telefono" 
                               value="{{ old('telefono', $usuario->telefono) }}" 
                               required>
                        @error('telefono')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="rol" class="form-label">
                            <i class="bi bi-shield-check"></i> Rol <span class="text-danger">*</span>
                        </label>
                        <select class="form-select @error('rol') is-invalid @enderror" 
                                id="rol" 
                                name="rol" 
                                required>
                            <option value="">Selecciona un rol</option>
                            <option value="gerente" {{ old('rol', $usuario->rol) == 'gerente' ? 'selected' : '' }}>
                                Gerente (Administrador)
                            </option>
                            <option value="odontologo" {{ old('rol', $usuario->rol) == 'odontologo' ? 'selected' : '' }}>
                                Odontólogo
                            </option>
                            <option value="asistente_directo" {{ old('rol', $usuario->rol) == 'asistente_directo' ? 'selected' : '' }}>
                                Asistente Directo
                            </option>
                            <option value="recepcionista" {{ old('rol', $usuario->rol) == 'recepcionista' ? 'selected' : '' }}>
                                Recepcionista
                            </option>
                            <option value="enfermera" {{ old('rol', $usuario->rol) == 'enfermera' ? 'selected' : '' }}>
                                Enfermera
                            </option>
                        </select>
                        @error('rol')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="activo" class="form-label">
                            <i class="bi bi-toggle-on"></i> Estado
                        </label>
                        <select class="form-select @error('activo') is-invalid @enderror" 
                                id="activo" 
                                name="activo" 
                                required>
                            <option value="1" {{ old('activo', $usuario->activo) == '1' ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ old('activo', $usuario->activo) == '0' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                        @error('activo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <hr>

                <h5 class="mb-3">
                    <i class="bi bi-key"></i> Cambiar Contraseña 
                    <small class="text-muted">(Dejar en blanco si no deseas cambiarla)</small>
                </h5>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">
                            <i class="bi bi-lock"></i> Nueva Contraseña
                        </label>
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password">
                        <small class="text-muted">Mínimo 8 caracteres (opcional)</small>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="password_confirmation" class="form-label">
                            <i class="bi bi-lock-fill"></i> Confirmar Nueva Contraseña
                        </label>
                        <input type="password" 
                               class="form-control" 
                               id="password_confirmation" 
                               name="password_confirmation">
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Actualizar Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

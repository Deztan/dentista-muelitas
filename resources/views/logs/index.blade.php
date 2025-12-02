@extends('layouts.app')

@section('title', 'Logs del Sistema')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h2">
            <i class="bi bi-journal-text text-primary"></i>
            Registro de Actividades (Logs)
        </h1>
        <p class="text-muted">Historial completo de acciones en el sistema</p>
    </div>
</div>

<!-- Filtros -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-white">
        <h5 class="mb-0"><i class="bi bi-funnel"></i> Filtros</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('logs.index') }}">
            <div class="row g-3">
                <div class="col-md-2">
                    <label class="form-label">Nivel</label>
                    <select name="level" class="form-select">
                        <option value="">Todos</option>
                        @foreach($levels as $level)
                            <option value="{{ $level }}" {{ request('level') == $level ? 'selected' : '' }}>
                                {{ $level }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Módulo</label>
                    <select name="module" class="form-select">
                        <option value="">Todos</option>
                        @foreach($modules as $module)
                            <option value="{{ $module }}" {{ request('module') == $module ? 'selected' : '' }}>
                                {{ ucfirst($module) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Acción</label>
                    <select name="action" class="form-select">
                        <option value="">Todas</option>
                        @foreach($actions as $action)
                            <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                                {{ $action }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Usuario</label>
                    <select name="usuario_id" class="form-select">
                        <option value="">Todos</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}" {{ request('usuario_id') == $usuario->id ? 'selected' : '' }}>
                                {{ $usuario->nombre_completo }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Fecha Desde</label>
                    <input type="date" name="fecha_desde" class="form-control" value="{{ request('fecha_desde') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Fecha Hasta</label>
                    <input type="date" name="fecha_hasta" class="form-control" value="{{ request('fecha_hasta') }}">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bi bi-search"></i> Filtrar
                    </button>
                    <a href="{{ route('logs.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Limpiar
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Tabla de logs -->
<div class="card shadow-sm">
    <div class="card-header bg-white">
        <h5 class="mb-0">
            <i class="bi bi-list-ul"></i> 
            Historial de Actividades 
            <span class="badge bg-primary">{{ $logs->total() }} registros</span>
        </h5>
    </div>
    <div class="card-body">
        @if($logs->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                <p class="text-muted mt-3">No hay logs registrados con los filtros seleccionados</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Timestamp</th>
                            <th>Nivel</th>
                            <th>Usuario</th>
                            <th>Módulo</th>
                            <th>Acción</th>
                            <th>Mensaje</th>
                            <th>IP</th>
                            <th class="text-center">Detalles</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($logs as $log)
                            <tr>
                                <td>
                                    <small>
                                        <i class="bi bi-calendar3"></i> {{ $log->timestamp->format('d/m/Y') }}<br>
                                        <i class="bi bi-clock"></i> {{ $log->timestamp->format('H:i:s.u') }}
                                    </small>
                                </td>
                                <td>
                                    @if($log->level == 'EMERGENCY' || $log->level == 'ALERT' || $log->level == 'CRITICAL')
                                        <span class="badge bg-danger">{{ $log->level }}</span>
                                    @elseif($log->level == 'ERROR')
                                        <span class="badge bg-danger">{{ $log->level }}</span>
                                    @elseif($log->level == 'WARNING')
                                        <span class="badge bg-warning">{{ $log->level }}</span>
                                    @elseif($log->level == 'NOTICE' || $log->level == 'INFO')
                                        <span class="badge bg-info">{{ $log->level }}</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $log->level }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($log->usuario)
                                        <i class="bi bi-person-circle"></i>
                                        {{ $log->usuario->nombre_completo }}
                                    @elseif($log->usuario_nombre)
                                        <i class="bi bi-person-circle"></i>
                                        {{ $log->usuario_nombre }}
                                    @else
                                        <span class="text-muted">Sistema</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-primary">{{ ucfirst($log->module) }}</span>
                                </td>
                                <td>
                                    @if($log->action == 'CREATE')
                                        <span class="badge bg-success"><i class="bi bi-plus-circle"></i> {{ $log->action }}</span>
                                    @elseif($log->action == 'UPDATE')
                                        <span class="badge bg-warning"><i class="bi bi-pencil"></i> {{ $log->action }}</span>
                                    @elseif($log->action == 'DELETE')
                                        <span class="badge bg-danger"><i class="bi bi-trash"></i> {{ $log->action }}</span>
                                    @elseif($log->action == 'LOGIN')
                                        <span class="badge bg-success"><i class="bi bi-box-arrow-in-right"></i> {{ $log->action }}</span>
                                    @elseif($log->action == 'LOGOUT')
                                        <span class="badge bg-secondary"><i class="bi bi-box-arrow-right"></i> {{ $log->action }}</span>
                                    @else
                                        <span class="badge bg-info">{{ $log->action }}</span>
                                    @endif
                                </td>
                                <td>{{ \Str::limit($log->message, 60) }}</td>
                                <td><small class="text-muted">{{ $log->ip_address }}</small></td>
                                <td class="text-center">
                                    <a href="{{ route('logs.show', $log->id) }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i> Ver
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div class="mt-3">
                {{ $logs->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

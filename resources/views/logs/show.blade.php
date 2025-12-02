@extends('layouts.app')

@section('title', 'Detalle del Log')

@section('content')
<div class="mb-4">
    <a href="{{ route('logs.index') }}" class="btn btn-secondary mb-3">
        <i class="bi bi-arrow-left"></i> Volver al listado
    </a>
    
    <h1 class="h2">
        <i class="bi bi-journal-text text-primary"></i>
        Log #{{ $log->id }} - {{ $log->level }}
    </h1>
</div>

<div class="row">
    <!-- Información General -->
    <div class="col-md-6">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-info-circle"></i> Información General</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless table-sm mb-0">
                    <tr>
                        <th width="40%">Timestamp:</th>
                        <td>{{ $log->timestamp->format('Y-m-d H:i:s.u') }}</td>
                    </tr>
                    <tr>
                        <th>Nivel (RFC 5424):</th>
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
                    </tr>
                    <tr>
                        <th>Estado:</th>
                        <td>
                            @if($log->status == 'SUCCESS')
                                <span class="badge bg-success">{{ $log->status }}</span>
                            @elseif($log->status == 'FAILED')
                                <span class="badge bg-danger">{{ $log->status }}</span>
                            @else
                                <span class="badge bg-warning">{{ $log->status }}</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Tiempo de ejecución:</th>
                        <td>{{ $log->execution_time_ms }} ms</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Request Context -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0"><i class="bi bi-globe"></i> Contexto de Request</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless table-sm mb-0">
                    <tr>
                        <th width="40%">Página:</th>
                        <td><small>{{ $log->page }}</small></td>
                    </tr>
                    <tr>
                        <th>Método HTTP:</th>
                        <td><span class="badge bg-dark">{{ $log->method }}</span></td>
                    </tr>
                    <tr>
                        <th>IP Address:</th>
                        <td>{{ $log->ip_address }}</td>
                    </tr>
                    <tr>
                        <th>User Agent:</th>
                        <td><small>{{ \Str::limit($log->user_agent, 60) }}</small></td>
                    </tr>
                    <tr>
                        <th>Session ID:</th>
                        <td><small>{{ $log->session_id }}</small></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Usuario y Acción -->
    <div class="col-md-6">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="bi bi-person"></i> Usuario</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless table-sm mb-0">
                    <tr>
                        <th width="40%">Nombre:</th>
                        <td>
                            @if($log->usuario)
                                {{ $log->usuario->nombre_completo }}
                            @elseif($log->usuario_nombre)
                                {{ $log->usuario_nombre }} <small class="text-muted">(usuario eliminado)</small>
                            @else
                                <span class="text-muted">Sistema</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Rol:</th>
                        <td>{{ $log->usuario_rol ? ucfirst($log->usuario_rol) : 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Usuario ID:</th>
                        <td>{{ $log->usuario_id ?? 'N/A' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-lightning"></i> Acción</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless table-sm mb-0">
                    <tr>
                        <th width="40%">Acción:</th>
                        <td><span class="badge bg-primary">{{ $log->action }}</span></td>
                    </tr>
                    <tr>
                        <th>Módulo:</th>
                        <td><span class="badge bg-info">{{ $log->module }}</span></td>
                    </tr>
                    <tr>
                        <th>Recurso:</th>
                        <td>{{ $log->resource_type ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Recurso ID:</th>
                        <td>{{ $log->resource_id ?? 'N/A' }}</td>
                    </tr>
                    @if($log->compliance_tag)
                    <tr>
                        <th>Compliance:</th>
                        <td><span class="badge bg-warning">{{ $log->compliance_tag }}</span></td>
                    </tr>
                    @endif
                    @if($log->is_sensitive)
                    <tr>
                        <th>Datos Sensibles:</th>
                        <td><span class="badge bg-danger"><i class="bi bi-shield-lock"></i> SÍ</span></td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Mensaje -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="bi bi-chat-left-text"></i> Mensaje</h5>
    </div>
    <div class="card-body">
        <p class="mb-0 fs-5">{{ $log->message }}</p>
        @if($log->detail)
            <hr>
            <p class="text-muted mb-0">{{ $log->detail }}</p>
        @endif
        @if($log->error_message)
            <hr>
            <div class="alert alert-danger mb-0">
                <strong>Error:</strong> {{ $log->error_message }}
            </div>
        @endif
    </div>
</div>

<!-- Datos del cambio -->
@if($log->old_data || $log->new_data)
<div class="row">
    @if($log->old_data)
    <div class="col-md-6">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="bi bi-arrow-left-circle"></i> Datos Anteriores</h5>
            </div>
            <div class="card-body">
                <pre class="bg-light p-3 rounded" style="max-height: 400px; overflow-y: auto; font-size: 0.85rem;">{{ json_encode($log->old_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
            </div>
        </div>
    </div>
    @endif

    @if($log->new_data)
    <div class="col-md-6">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-arrow-right-circle"></i> Datos Nuevos</h5>
            </div>
            <div class="card-body">
                <pre class="bg-light p-3 rounded" style="max-height: 400px; overflow-y: auto; font-size: 0.85rem;">{{ json_encode($log->new_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
            </div>
        </div>
    </div>
    @endif
</div>
@endif

<!-- Metadata -->
@if($log->metadata)
<div class="card shadow-sm mb-4">
    <div class="card-header bg-dark text-white">
        <h5 class="mb-0"><i class="bi bi-code-square"></i> Metadata</h5>
    </div>
    <div class="card-body">
        <pre class="bg-light p-3 rounded" style="max-height: 300px; overflow-y: auto; font-size: 0.85rem;">{{ json_encode($log->metadata, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
    </div>
</div>
@endif
@endsection

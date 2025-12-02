@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-2 text-gray-800">
                <i class="fas fa-database"></i> Backups de Base de Datos
            </h1>
            <p class="text-muted mb-0">Gestión de copias de seguridad</p>
        </div>
        <div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createBackupModal">
                <i class="fas fa-plus-circle"></i> Crear Backup
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Información importante -->
    <div class="alert alert-info mb-4" role="alert">
        <i class="fas fa-info-circle"></i>
        <strong>Importante:</strong> Los backups se almacenan en el servidor. Se recomienda descargarlos y guardarlos en un lugar seguro. 
        La restauración sobrescribirá todos los datos actuales de la base de datos.
    </div>

    <!-- Tabla de backups -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-list"></i> Backups Disponibles ({{ count($backups) }})
            </h6>
        </div>
        <div class="card-body">
            @if(count($backups) > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="backupsTable">
                        <thead>
                            <tr>
                                <th>Archivo</th>
                                <th>Fecha/Hora</th>
                                <th>Tamaño</th>
                                <th>Tipo</th>
                                <th width="200">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($backups as $backup)
                            <tr>
                                <td>
                                    <i class="fas fa-file-archive text-primary"></i>
                                    <span class="font-weight-bold">{{ $backup['filename'] }}</span>
                                </td>
                                <td>
                                    <i class="far fa-clock"></i>
                                    {{ $backup['date'] }}
                                </td>
                                <td>
                                    <span class="badge bg-secondary">
                                        {{ $backup['size_mb'] }} MB
                                    </span>
                                </td>
                                <td>
                                    @if($backup['compressed'])
                                        <span class="badge bg-success">
                                            <i class="fas fa-file-archive"></i> Comprimido
                                        </span>
                                    @else
                                        <span class="badge bg-info">
                                            <i class="fas fa-file-alt"></i> SQL
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <!-- Descargar -->
                                        <a href="{{ route('backups.download', $backup['filename']) }}" 
                                           class="btn btn-success"
                                           title="Descargar">
                                            <i class="bi bi-download"></i>
                                        </a>

                                        <!-- Restaurar -->
                                        <button type="button" 
                                                class="btn btn-warning"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#restoreBackupModal"
                                                data-filename="{{ $backup['filename'] }}"
                                                title="Restaurar">
                                            <i class="bi bi-arrow-counterclockwise"></i>
                                        </button>

                                        <!-- Eliminar -->
                                        <button type="button" 
                                                class="btn btn-danger"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#deleteBackupModal"
                                                data-filename="{{ $backup['filename'] }}"
                                                title="Eliminar">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-database fa-3x text-muted mb-3"></i>
                    <p class="text-muted">No hay backups disponibles</p>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createBackupModal">
                        <i class="fas fa-plus-circle"></i> Crear Primer Backup
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal: Crear Backup -->
<div class="modal fade" id="createBackupModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-plus-circle"></i> Crear Nuevo Backup
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('backups.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p class="mb-3">Se creará un backup completo de la base de datos actual.</p>
                    
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="compress" id="compressCheckbox" value="1">
                        <label class="form-check-label" for="compressCheckbox">
                            <i class="fas fa-file-archive"></i> Comprimir backup (ZIP)
                        </label>
                        <small class="form-text text-muted d-block ms-4">
                            Reduce el tamaño del archivo para facilitar la descarga y almacenamiento.
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Crear Backup
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Restaurar Backup -->
<div class="modal fade" id="restoreBackupModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle"></i> Confirmar Restauración
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="" method="POST" id="restoreForm">
                @csrf
                @method('POST')
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i>
                        <strong>¡ADVERTENCIA!</strong> Esta acción sobrescribirá todos los datos actuales de la base de datos.
                    </div>
                    
                    <p>¿Estás seguro de que deseas restaurar el backup?</p>
                    <p class="mb-0">
                        <strong>Archivo:</strong> <span id="restoreFilename" class="text-primary"></span>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-undo"></i> Restaurar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Eliminar Backup -->
<div class="modal fade" id="deleteBackupModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-trash"></i> Eliminar Backup
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="" method="POST" id="deleteForm">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas eliminar este backup?</p>
                    <p class="mb-0">
                        <strong>Archivo:</strong> <span id="deleteFilename" class="text-danger"></span>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Eliminar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Modal de restaurar
    const restoreBackupModal = document.getElementById('restoreBackupModal');
    restoreBackupModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const filename = button.getAttribute('data-filename');
        
        document.getElementById('restoreFilename').textContent = filename;
        document.getElementById('restoreForm').action = '/backups/' + filename + '/restore';
    });

    // Modal de eliminar
    const deleteBackupModal = document.getElementById('deleteBackupModal');
    deleteBackupModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const filename = button.getAttribute('data-filename');
        
        document.getElementById('deleteFilename').textContent = filename;
        document.getElementById('deleteForm').action = '/backups/' + filename;
    });

    // DataTable
    @if(count($backups) > 0)
    $(document).ready(function() {
        $('#backupsTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
            },
            "order": [[1, "desc"]],
            "pageLength": 10
        });
    });
    @endif
</script>
@endpush
@endsection

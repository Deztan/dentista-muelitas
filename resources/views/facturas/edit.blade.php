@extends('layouts.app')

@section('title', 'Editar Factura - Dentista Muelitas')

@section('content')
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{ route('facturas.index') }}">Facturas</a></li>
        <li class="breadcrumb-item active">Editar Factura #{{ str_pad($factura->id, 4, '0', STR_PAD_LEFT) }}</li>
    </ol>
</nav>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header bg-warning">
                <h5 class="mb-0">
                    <i class="bi bi-pencil-square"></i> Editar Factura #{{ str_pad($factura->id, 4, '0', STR_PAD_LEFT) }}
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('facturas.update', $factura->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Información del Paciente y Tratamiento -->
                    <h6 class="border-bottom pb-2 mb-3">
                        <i class="bi bi-person-fill text-primary"></i> Información del Servicio
                    </h6>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="paciente_id" class="form-label">Paciente <span class="text-danger">*</span></label>
                            <select class="form-select @error('paciente_id') is-invalid @enderror" 
                                    id="paciente_id" 
                                    name="paciente_id" 
                                    required>
                                <option value="">Seleccione un paciente</option>
                                @foreach($pacientes as $paciente)
                                    <option value="{{ $paciente->id }}" 
                                        {{ old('paciente_id', $factura->paciente_id) == $paciente->id ? 'selected' : '' }}>
                                        {{ $paciente->nombre_completo }}
                                    </option>
                                @endforeach
                            </select>
                            @error('paciente_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="tratamiento_id" class="form-label">Tratamiento <span class="text-danger">*</span></label>
                            <select class="form-select @error('tratamiento_id') is-invalid @enderror" 
                                    id="tratamiento_id" 
                                    name="tratamiento_id" 
                                    required>
                                <option value="">Seleccione un tratamiento</option>
                                @foreach($tratamientos as $tratamiento)
                                    <option value="{{ $tratamiento->id }}" 
                                            data-precio="{{ $tratamiento->precio_base }}"
                                            {{ old('tratamiento_id', $factura->tratamiento_id) == $tratamiento->id ? 'selected' : '' }}>
                                        {{ $tratamiento->nombre }} - Bs {{ number_format($tratamiento->precio_base, 2) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tratamiento_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Información de la Factura -->
                    <h6 class="border-bottom pb-2 mb-3 mt-4">
                        <i class="bi bi-cash-coin text-success"></i> Detalles de Pago
                    </h6>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="fecha_emision" class="form-label">Fecha de Emisión <span class="text-danger">*</span></label>
                            <input type="date" 
                                   class="form-control @error('fecha_emision') is-invalid @enderror" 
                                   id="fecha_emision" 
                                   name="fecha_emision" 
                                   value="{{ old('fecha_emision', $factura->fecha_emision) }}"
                                   required>
                            @error('fecha_emision')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="monto_total" class="form-label">Monto Total <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Bs</span>
                                <input type="number" 
                                       class="form-control @error('monto_total') is-invalid @enderror" 
                                       id="monto_total" 
                                       name="monto_total" 
                                       step="0.01"
                                       min="0"
                                       value="{{ old('monto_total', $factura->monto_total) }}"
                                       required>
                                @error('monto_total')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="monto_pagado" class="form-label">Monto Pagado <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Bs</span>
                                <input type="number" 
                                       class="form-control @error('monto_pagado') is-invalid @enderror" 
                                       id="monto_pagado" 
                                       name="monto_pagado" 
                                       step="0.01"
                                       min="0"
                                       value="{{ old('monto_pagado', $factura->monto_pagado) }}"
                                       required>
                                @error('monto_pagado')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="saldo_calculado" class="form-label">Saldo Pendiente</label>
                            <div class="input-group">
                                <span class="input-group-text">Bs</span>
                                <input type="text" 
                                       class="form-control bg-light" 
                                       id="saldo_calculado" 
                                       value="{{ number_format($factura->saldo_pendiente, 2) }}"
                                       readonly>
                            </div>
                            <small class="text-muted">Se calcula automáticamente</small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="metodo_pago" class="form-label">Método de Pago <span class="text-danger">*</span></label>
                            <select class="form-select @error('metodo_pago') is-invalid @enderror" 
                                    id="metodo_pago" 
                                    name="metodo_pago" 
                                    required>
                                <option value="efectivo" {{ old('metodo_pago', $factura->metodo_pago) == 'efectivo' ? 'selected' : '' }}>Efectivo</option>
                                <option value="tarjeta" {{ old('metodo_pago', $factura->metodo_pago) == 'tarjeta' ? 'selected' : '' }}>Tarjeta</option>
                                <option value="transferencia" {{ old('metodo_pago', $factura->metodo_pago) == 'transferencia' ? 'selected' : '' }}>Transferencia</option>
                                <option value="qr" {{ old('metodo_pago', $factura->metodo_pago) == 'qr' ? 'selected' : '' }}>QR</option>
                            </select>
                            @error('metodo_pago')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="estado" class="form-label">Estado <span class="text-danger">*</span></label>
                            <select class="form-select @error('estado') is-invalid @enderror" 
                                    id="estado" 
                                    name="estado" 
                                    required>
                                <option value="pendiente" {{ old('estado', $factura->estado) == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="pagada" {{ old('estado', $factura->estado) == 'pagada' ? 'selected' : '' }}>Pagada</option>
                                <option value="cancelada" {{ old('estado', $factura->estado) == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                            </select>
                            @error('estado')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="observaciones" class="form-label">Observaciones</label>
                        <textarea class="form-control @error('observaciones') is-invalid @enderror" 
                                  id="observaciones" 
                                  name="observaciones" 
                                  rows="3">{{ old('observaciones', $factura->observaciones) }}</textarea>
                        @error('observaciones')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('facturas.show', $factura->id) }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-check-circle"></i> Actualizar Factura
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h6 class="card-title">
                    <i class="bi bi-info-circle text-primary"></i> Información del Registro
                </h6>
                <p class="small mb-1"><strong>ID:</strong> {{ $factura->id }}</p>
                <p class="small mb-1"><strong>Creado:</strong> {{ $factura->created_at->format('d/m/Y H:i') }}</p>
                <p class="small mb-0"><strong>Última actualización:</strong> {{ $factura->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="card-title">
                    <i class="bi bi-exclamation-triangle text-warning"></i> Importante
                </h6>
                <p class="small text-muted mb-0">
                    Si modifica los montos, recuerde actualizar el estado de la factura según corresponda.
                </p>
            </div>
        </div>
    </div>
</div>

<script>
// Calcular saldo pendiente
function calcularSaldo() {
    const total = parseFloat(document.getElementById('monto_total').value) || 0;
    const pagado = parseFloat(document.getElementById('monto_pagado').value) || 0;
    const saldo = total - pagado;
    document.getElementById('saldo_calculado').value = saldo.toFixed(2);
}

document.getElementById('monto_total').addEventListener('input', calcularSaldo);
document.getElementById('monto_pagado').addEventListener('input', calcularSaldo);
</script>
@endsection

@extends('layouts.app')

@section('title', 'Facturas - Dentista Muelitas')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">
        <i class="bi bi-receipt text-primary"></i>
        Facturas y Cobros
    </h1>
    <a href="{{ route('facturas.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Nueva Factura
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        @if($facturas->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-receipt-cutoff" style="font-size: 4rem; color: #ccc;"></i>
                <p class="text-muted mt-3">No hay facturas registradas</p>
                <a href="{{ route('facturas.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Crear primera factura
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nº Factura</th>
                            <th>Fecha</th>
                            <th>Paciente</th>
                            <th>Tratamiento</th>
                            <th>Monto Total</th>
                            <th>Pagado</th>
                            <th>Saldo</th>
                            <th>Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($facturas as $factura)
                            <tr>
                                <td><strong>#{{ str_pad($factura->id, 4, '0', STR_PAD_LEFT) }}</strong></td>
                                <td>{{ \Carbon\Carbon::parse($factura->fecha_emision)->format('d/m/Y') }}</td>
                                <td>
                                    <i class="bi bi-person-fill text-primary me-2"></i>
                                    @if($factura->paciente)
                                        {{ $factura->paciente->nombre_completo }}
                                    @else
                                        <span class="text-muted">Sin paciente</span>
                                    @endif
                                </td>
                                <td>
                                    <i class="bi bi-clipboard2-pulse text-success me-2"></i>
                                    @if($factura->tratamiento)
                                        {{ $factura->tratamiento->nombre }}
                                    @else
                                        <span class="text-muted">Sin tratamiento</span>
                                    @endif
                                </td>
                                <td><strong class="text-primary">Bs {{ number_format($factura->monto_total, 2) }}</strong></td>
                                <td class="text-success">Bs {{ number_format($factura->monto_pagado, 2) }}</td>
                                <td>
                                    @if($factura->saldo_pendiente > 0)
                                        <strong class="text-danger">Bs {{ number_format($factura->saldo_pendiente, 2) }}</strong>
                                    @else
                                        <span class="text-muted">Bs 0.00</span>
                                    @endif
                                </td>
                                <td>
                                    @if($factura->estado == 'pendiente')
                                        <span class="badge bg-warning text-dark">Pendiente</span>
                                    @elseif($factura->estado == 'pagada')
                                        <span class="badge bg-success">Pagada</span>
                                    @else
                                        <span class="badge bg-danger">Cancelada</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('facturas.show', $factura->id) }}" 
                                           class="btn btn-info" 
                                           title="Ver detalles">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('facturas.edit', $factura->id) }}" 
                                           class="btn btn-warning" 
                                           title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('facturas.destroy', $factura->id) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('¿Estás seguro de eliminar esta factura?');">
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
                    Mostrando {{ $facturas->firstItem() }} - {{ $facturas->lastItem() }} de {{ $facturas->total() }} facturas
                </div>
                <div>
                    {{ $facturas->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@extends('reportes.pdf.layout')

@section('title', 'Reporte de Facturas')

@section('content')
<div class="info-section">
    <h3>Reporte de Facturas</h3>
    <p>
        @if($desde || $hasta)
            Período: 
            {{ $desde ? $desde->format('d/m/Y') : 'Inicio' }} - 
            {{ $hasta ? $hasta->format('d/m/Y') : 'Actualidad' }}
        @else
            Todas las facturas
        @endif
    </p>
    @if($estado)
        <p>Estado: <strong>{{ ucfirst($estado) }}</strong></p>
    @endif
    @if($metodo)
        <p>Método de pago: <strong>{{ ucfirst($metodo) }}</strong></p>
    @endif
</div>

<!-- Totales -->
<div class="stats-grid">
    <div class="stat-box">
        <div class="stat-label">Total Facturado</div>
        <div class="stat-value">Bs {{ number_format($sumTotal, 2) }}</div>
    </div>
    <div class="stat-box">
        <div class="stat-label">Total Cobrado</div>
        <div class="stat-value" style="color: #28a745;">Bs {{ number_format($sumPagado, 2) }}</div>
    </div>
    <div class="stat-box">
        <div class="stat-label">Saldo Pendiente</div>
        <div class="stat-value" style="color: #dc3545;">Bs {{ number_format($sumSaldo, 2) }}</div>
    </div>
</div>

<!-- Tabla de facturas -->
<table>
    <thead>
        <tr>
            <th style="width: 8%;">N° Factura</th>
            <th style="width: 20%;">Paciente</th>
            <th style="width: 20%;">Tratamiento</th>
            <th style="width: 10%;" class="text-center">Fecha</th>
            <th style="width: 12%;" class="text-right">Monto Total</th>
            <th style="width: 12%;" class="text-right">Pagado</th>
            <th style="width: 12%;" class="text-right">Pendiente</th>
            <th style="width: 6%;" class="text-center">Estado</th>
        </tr>
    </thead>
    <tbody>
        @forelse($facturas as $factura)
            <tr>
                <td>{{ $factura->numero_factura }}</td>
                <td>{{ $factura->paciente->nombre ?? 'N/A' }} {{ $factura->paciente->apellido ?? '' }}</td>
                <td>{{ $factura->tratamiento->nombre ?? 'N/A' }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($factura->created_at)->format('d/m/Y') }}</td>
                <td class="text-right">Bs {{ number_format($factura->monto_total, 2) }}</td>
                <td class="text-right">Bs {{ number_format($factura->monto_pagado, 2) }}</td>
                <td class="text-right">Bs {{ number_format($factura->saldo_pendiente, 2) }}</td>
                <td class="text-center">
                    @if($factura->estado === 'pagada')
                        <span class="badge badge-success">Pagada</span>
                    @elseif($factura->estado === 'pendiente')
                        <span class="badge badge-warning">Pendiente</span>
                    @else
                        <span class="badge badge-danger">Anulada</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center">No se encontraron facturas</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection

@extends('reportes.pdf.layout')

@section('title', 'Reporte de Ingresos')

@section('content')
<div class="info-section">
    <h3>Reporte de Ingresos</h3>
    <p>
        @if($desde || $hasta)
            Período: 
            {{ $desde ? $desde->format('d/m/Y') : 'Inicio' }} - 
            {{ $hasta ? $hasta->format('d/m/Y') : 'Actualidad' }}
        @else
            Todos los ingresos registrados
        @endif
    </p>
</div>

<!-- Totales generales -->
<div class="stats-grid">
    <div class="stat-box">
        <div class="stat-label">Total Facturado</div>
        <div class="stat-value">Bs {{ number_format($totalFacturado, 2) }}</div>
    </div>
    <div class="stat-box">
        <div class="stat-label">Total Cobrado</div>
        <div class="stat-value" style="color: #28a745;">Bs {{ number_format($totalCobrado, 2) }}</div>
    </div>
    <div class="stat-box">
        <div class="stat-label">Total Pendiente</div>
        <div class="stat-value" style="color: #dc3545;">Bs {{ number_format($totalPendiente, 2) }}</div>
    </div>
</div>

<!-- Ingresos por método de pago -->
@if($ingresosPorMetodo->count() > 0)
<div class="info-section">
    <h3>Ingresos por Método de Pago</h3>
    <table>
        <thead>
            <tr>
                <th style="width: 50%;">Método de Pago</th>
                <th style="width: 50%;" class="text-right">Total Cobrado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ingresosPorMetodo as $metodo)
                <tr>
                    <td>{{ ucfirst($metodo->metodo_pago) }}</td>
                    <td class="text-right"><strong>Bs {{ number_format($metodo->total, 2) }}</strong></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

<!-- Ingresos por tratamiento -->
@if($ingresosPorTratamiento->count() > 0)
<div class="info-section">
    <h3>Top 10 Tratamientos por Ingresos</h3>
    <table>
        <thead>
            <tr>
                <th style="width: 50%;">Tratamiento</th>
                <th style="width: 20%;" class="text-center">Cantidad</th>
                <th style="width: 30%;" class="text-right">Total Ingreso</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ingresosPorTratamiento as $item)
                <tr>
                    <td>{{ $item->tratamiento->nombre ?? 'Sin especificar' }}</td>
                    <td class="text-center"><span class="badge badge-info">{{ $item->cantidad }}</span></td>
                    <td class="text-right"><strong>Bs {{ number_format($item->total, 2) }}</strong></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
@endsection

@extends('reportes.pdf.layout')

@section('title', 'Reporte de Inventario')

@section('content')
<div class="info-section">
    <h3>Reporte de Inventario de Materiales</h3>
    <p>Fecha de generación: {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
</div>

<!-- Estadísticas -->
<div class="stats-grid">
    <div class="stat-box">
        <div class="stat-label">Total Materiales</div>
        <div class="stat-value">{{ $totalMateriales }}</div>
    </div>
    <div class="stat-box">
        <div class="stat-label">Valor Total Inventario</div>
        <div class="stat-value" style="color: #28a745;">Bs {{ number_format($valorTotalInventario, 2) }}</div>
    </div>
</div>

<!-- Alertas de stock bajo -->
@if($materialesBajos->count() > 0)
<div class="info-section">
    <div class="alert alert-danger">
        <strong>⚠ ALERTA:</strong> {{ $materialesBajos->count() }} materiales con stock bajo o agotado
    </div>
    <h3>Materiales con Stock Bajo</h3>
    <table>
        <thead>
            <tr>
                <th style="width: 30%;">Material</th>
                <th style="width: 15%;">Categoría</th>
                <th style="width: 15%;" class="text-center">Stock Actual</th>
                <th style="width: 15%;" class="text-center">Stock Mínimo</th>
                <th style="width: 15%;" class="text-right">Precio Unit.</th>
                <th style="width: 10%;" class="text-center">Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($materialesBajos as $material)
                <tr class="{{ $material->stock_actual == 0 ? 'highlight-row' : '' }}">
                    <td>{{ $material->nombre }}</td>
                    <td>{{ $material->descripcion ?? 'Sin categoría' }}</td>
                    <td class="text-center">
                        <strong>{{ $material->stock_actual }} {{ $material->unidad_medida }}</strong>
                    </td>
                    <td class="text-center">{{ $material->stock_minimo }} {{ $material->unidad_medida }}</td>
                    <td class="text-right">Bs {{ number_format($material->precio_unitario, 2) }}</td>
                    <td class="text-center">
                        @if($material->stock_actual == 0)
                            <span class="badge badge-danger">Agotado</span>
                        @else
                            <span class="badge badge-warning">Bajo</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif

<!-- Top 10 por valor -->
<div class="info-section">
    <h3>Top 10 Materiales por Valor en Inventario</h3>
    <table>
        <thead>
            <tr>
                <th style="width: 10%;" class="text-center">Pos.</th>
                <th style="width: 35%;">Material</th>
                <th style="width: 15%;">Categoría</th>
                <th style="width: 15%;" class="text-center">Stock</th>
                <th style="width: 12%;" class="text-right">Precio Unit.</th>
                <th style="width: 13%;" class="text-right">Valor Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($materialesPorValor as $index => $material)
                <tr>
                    <td class="text-center">
                        @if($index === 0) 🥇
                        @elseif($index === 1) 🥈
                        @elseif($index === 2) 🥉
                        @else {{ $index + 1 }}
                        @endif
                    </td>
                    <td>{{ $material->nombre }}</td>
                    <td>{{ $material->descripcion ?? 'Sin categoría' }}</td>
                    <td class="text-center">{{ $material->stock_actual }} {{ $material->unidad_medida }}</td>
                    <td class="text-right">Bs {{ number_format($material->precio_unitario, 2) }}</td>
                    <td class="text-right"><strong>Bs {{ number_format($material->valor_total, 2) }}</strong></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Inventario completo -->
<div class="info-section">
    <h3>Inventario Completo</h3>
    <table>
        <thead>
            <tr>
                <th style="width: 25%;">Material</th>
                <th style="width: 15%;">Categoría</th>
                <th style="width: 15%;">Proveedor</th>
                <th style="width: 12%;" class="text-center">Stock</th>
                <th style="width: 12%;" class="text-right">Precio Unit.</th>
                <th style="width: 13%;" class="text-right">Valor Total</th>
                <th style="width: 8%;" class="text-center">Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($materiales as $material)
                <tr>
                    <td>{{ $material->nombre }}</td>
                    <td>{{ $material->descripcion ?? 'Sin categoría' }}</td>
                    <td>{{ $material->proveedor ?? 'N/A' }}</td>
                    <td class="text-center">{{ $material->stock_actual }} {{ $material->unidad_medida }}</td>
                    <td class="text-right">Bs {{ number_format($material->precio_unitario, 2) }}</td>
                    <td class="text-right">Bs {{ number_format($material->stock_actual * $material->precio_unitario, 2) }}</td>
                    <td class="text-center">
                        @if($material->stock_actual <= $material->stock_minimo)
                            <span class="badge badge-danger">!</span>
                        @else
                            <span class="badge badge-success">✓</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr style="background-color: #f8f9fa;">
                <td colspan="5" class="text-right"><strong>TOTAL GENERAL:</strong></td>
                <td class="text-right"><strong>Bs {{ number_format($valorTotalInventario, 2) }}</strong></td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Reporte de Inventario')

@section('content')
<div class="container-fluid py-4">
    <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            @foreach($breadcrumbs as $breadcrumb)
                @if(isset($breadcrumb['url']))
                    <li class="breadcrumb-item"><a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['name'] }}</a></li>
                @else
                    <li class="breadcrumb-item active">{{ $breadcrumb['name'] }}</li>
                @endif
            @endforeach
        </ol>
    </nav>

    <!-- Título y acciones -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">
            <i class="bi bi-box-seam text-warning"></i> Reporte de Inventario
        </h1>
        <div>
            <a href="{{ route('reportes.inventario.pdf') }}" class="btn btn-danger me-2" target="_blank">
                <i class="bi bi-file-pdf"></i> Exportar PDF
            </a>
            <a href="{{ route('reportes.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    <!-- Estadísticas generales -->
    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <div class="card border-primary">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Total Materiales</h6>
                    <h3 class="text-primary mb-0">{{ $totalMateriales }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card border-success">
                <div class="card-body">
                    <h6 class="text-muted mb-2">Valor Total Inventario</h6>
                    <h3 class="text-success mb-0">Bs {{ number_format($valorTotalInventario, 2) }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Alertas de stock bajo -->
    @if($materialesBajos->count() > 0)
    <div class="card mb-4 border-danger">
        <div class="card-header bg-danger text-white">
            <h5 class="mb-0">
                <i class="bi bi-exclamation-triangle"></i> 
                Alertas de Stock Bajo ({{ $materialesBajos->count() }} materiales)
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Material</th>
                            <th>Categoría</th>
                            <th class="text-center">Stock Actual</th>
                            <th class="text-center">Stock Mínimo</th>
                            <th class="text-end">Precio Unitario</th>
                            <th class="text-center">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($materialesBajos as $material)
                            <tr class="{{ $material->stock_actual == 0 ? 'table-danger' : 'table-warning' }}">
                                <td><strong>{{ $material->nombre }}</strong></td>
                                <td>
                                    <span class="badge bg-secondary">{{ $material->descripcion ?? 'Sin categoría' }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge {{ $material->stock_actual == 0 ? 'bg-danger' : 'bg-warning text-dark' }}">
                                        {{ $material->stock_actual }} {{ $material->unidad_medida }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    {{ $material->stock_minimo }} {{ $material->unidad_medida }}
                                </td>
                                <td class="text-end">
                                    Bs {{ number_format($material->precio_unitario, 2) }}
                                </td>
                                <td class="text-center">
                                    @if($material->stock_actual == 0)
                                        <span class="badge bg-danger">
                                            <i class="bi bi-x-circle"></i> Sin Stock
                                        </span>
                                    @else
                                        <span class="badge bg-warning text-dark">
                                            <i class="bi bi-exclamation-triangle"></i> Stock Bajo
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <!-- Materiales por valor (Top 10) -->
    <div class="card mb-4">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">
                <i class="bi bi-trophy"></i> Top 10 Materiales por Valor en Inventario
            </h5>
        </div>
        <div class="card-body">
            @if($materialesPorValor->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th style="width: 50px;">Pos.</th>
                                <th>Material</th>
                                <th>Categoría</th>
                                <th class="text-center">Stock</th>
                                <th class="text-end">Precio Unit.</th>
                                <th class="text-end">Valor Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($materialesPorValor as $index => $material)
                                <tr>
                                    <td class="text-center">
                                        @if($index === 0)
                                            <span class="fs-4">🥇</span>
                                        @elseif($index === 1)
                                            <span class="fs-4">🥈</span>
                                        @elseif($index === 2)
                                            <span class="fs-4">🥉</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $index + 1 }}</span>
                                        @endif
                                    </td>
                                    <td><strong>{{ $material->nombre }}</strong></td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $material->descripcion ?? 'Sin categoría' }}</span>
                                    </td>
                                    <td class="text-center">
                                        {{ $material->stock_actual }} {{ $material->unidad_medida }}
                                    </td>
                                    <td class="text-end">
                                        Bs {{ number_format($material->precio_unitario, 2) }}
                                    </td>
                                    <td class="text-end">
                                        <strong class="text-success">
                                            Bs {{ number_format($material->valor_total, 2) }}
                                        </strong>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted mb-0">No hay materiales en inventario.</p>
            @endif
        </div>
    </div>

    <!-- Lista completa de materiales -->
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="bi bi-list-ul"></i> Inventario Completo
            </h5>
        </div>
        <div class="card-body">
            @if($materiales->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Material</th>
                                <th>Categoría</th>
                                <th>Proveedor</th>
                                <th class="text-center">Stock</th>
                                <th class="text-center">Stock Mín.</th>
                                <th class="text-end">Precio Unit.</th>
                                <th class="text-end">Valor Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($materiales as $material)
                                <tr>
                                    <td>
                                        <strong>{{ $material->nombre }}</strong>
                                        @if($material->stock_actual <= $material->stock_minimo)
                                            <br>
                                            <small class="text-danger">
                                                <i class="bi bi-exclamation-triangle"></i> Stock bajo
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $material->descripcion ?? 'Sin categoría' }}</span>
                                    </td>
                                    <td>
                                        @if($material->proveedor)
                                            {{ $material->proveedor }}
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge {{ $material->stock_actual <= $material->stock_minimo ? 'bg-danger' : 'bg-primary' }}">
                                            {{ $material->stock_actual }} {{ $material->unidad_medida }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        {{ $material->stock_minimo }} {{ $material->unidad_medida }}
                                    </td>
                                    <td class="text-end">
                                        Bs {{ number_format($material->precio_unitario, 2) }}
                                    </td>
                                    <td class="text-end">
                                        <strong>Bs {{ number_format($material->stock_actual * $material->precio_unitario, 2) }}</strong>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="table-secondary">
                                <td colspan="6" class="text-end"><strong>TOTAL GENERAL:</strong></td>
                                <td class="text-end">
                                    <strong>Bs {{ number_format($valorTotalInventario, 2) }}</strong>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted">
                        Mostrando {{ $materiales->firstItem() ?? 0 }} a {{ $materiales->lastItem() ?? 0 }} 
                        de {{ $materiales->total() }} materiales
                    </div>
                    <div>
                        {{ $materiales->links() }}
                    </div>
                </div>
            @else
                <p class="text-muted mb-0">No hay materiales en el inventario.</p>
            @endif
        </div>
    </div>
</div>
@endsection

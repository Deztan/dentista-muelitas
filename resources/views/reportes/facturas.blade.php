@extends('layouts.app')

@section('title', 'Reporte de facturas')

@section('content')
<div class="d-flex align-items-center mb-3">
    <i class="bi bi-graph-up text-primary me-2 fs-3"></i>
    <h2 class="mb-0">Reporte de facturas</h2>
    <span class="text-muted ms-2">(filtros por fecha, estado y método de pago)</span>
    <div class="ms-auto">
        <button class="btn btn-outline-secondary btn-sm" onclick="window.print()">
            <i class="bi bi-printer"></i> Imprimir/Guardar PDF
        </button>
    </div>
    
</div>

<div class="card mb-4">
    <div class="card-body">
        <form class="row g-3" method="get" action="{{ route('reportes.facturas') }}">
            <div class="col-md-3">
                <label class="form-label">Desde</label>
                <input type="date" name="desde" value="{{ request('desde') }}" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">Hasta</label>
                <input type="date" name="hasta" value="{{ request('hasta') }}" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">Estado</label>
                <select name="estado" class="form-select">
                    <option value="">Todos</option>
                    @foreach(['pendiente','pagada','parcial','anulada'] as $opt)
                        <option value="{{ $opt }}" @selected(request('estado')===$opt)>{{ ucfirst($opt) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Método de pago</label>
                <select name="metodo_pago" class="form-select">
                    <option value="">Todos</option>
                    @foreach(['efectivo','tarjeta','transferencia','qr'] as $opt)
                        <option value="{{ $opt }}" @selected(request('metodo_pago')===$opt)>{{ ucfirst($opt) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 d-flex gap-2">
                <button class="btn btn-primary"><i class="bi bi-funnel"></i> Filtrar</button>
                <a href="{{ route('reportes.facturas') }}" class="btn btn-outline-secondary">Limpiar</a>
            </div>
        </form>
    </div>
    <div class="card-footer bg-light d-flex gap-3 flex-wrap">
        <span class="badge bg-primary">Total facturado: <strong>Bs {{ number_format($sumTotal,2,',','.') }}</strong></span>
        <span class="badge bg-success">Pagado: <strong>Bs {{ number_format($sumPagado,2,',','.') }}</strong></span>
        <span class="badge bg-warning text-dark">Saldo: <strong>Bs {{ number_format($sumSaldo,2,',','.') }}</strong></span>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>Fecha</th>
                <th>#</th>
                <th>Paciente</th>
                <th>Tratamiento</th>
                <th class="text-end">Total (Bs)</th>
                <th class="text-end">Pagado (Bs)</th>
                <th class="text-end">Saldo (Bs)</th>
                <th>Estado</th>
                <th>Método</th>
            </tr>
        </thead>
        <tbody>
            @forelse($facturas as $f)
            <tr>
                <td>{{ $f->created_at?->format('Y-m-d') }}</td>
                <td>{{ $f->id }}</td>
                <td>
                    @if($f->paciente)
                        <a href="{{ route('pacientes.show', $f->paciente->id) }}">{{ $f->paciente->nombre_completo }}</a>
                    @else
                        <span class="text-muted">Sin paciente</span>
                    @endif
                </td>
                <td>{{ $f->tratamiento->nombre ?? '—' }}</td>
                <td class="text-end">{{ number_format($f->monto_total,2,',','.') }}</td>
                <td class="text-end">{{ number_format($f->monto_pagado,2,',','.') }}</td>
                <td class="text-end">{{ number_format($f->saldo_pendiente,2,',','.') }}</td>
                <td>
                    @php $colors = ['pendiente'=>'warning','pagada'=>'success','parcial'=>'info','anulada'=>'secondary']; @endphp
                    <span class="badge bg-{{ $colors[$f->estado] ?? 'secondary' }}">{{ ucfirst($f->estado) }}</span>
                </td>
                <td>{{ ucfirst($f->metodo_pago) }}</td>
            </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center text-muted py-4">No hay resultados para los filtros seleccionados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-3">
    {{ $facturas->links() }}
    <p class="text-muted small mt-2">
        Consejo: usa el botón Imprimir para exportar a PDF (Ctrl+P) con diseño amigable para impresión.
    </p>
</div>

<style>
@media print {
    nav, .sidebar, .btn, form, .pagination { display: none !important; }
    main { width: 100%; margin: 0; padding: 0; }
    .table { font-size: 12px; }
}
</style>
@endsection

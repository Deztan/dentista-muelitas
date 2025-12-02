<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Factura;
use App\Models\Tratamiento;
use App\Models\Paciente;
use App\Models\Material;
use App\Models\Cita;
use App\Models\Expediente;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportesController extends Controller
{
    /**
     * Dashboard principal de reportes
     * GET /reportes
     */
    public function index()
    {
        $breadcrumbs = [
            ['name' => 'Inicio', 'url' => route('home')],
            ['name' => 'Reportes'],
        ];

        // Estadísticas rápidas del mes actual
        $mesActual = Carbon::now()->startOfMonth();
        $mesFin = Carbon::now()->endOfMonth();

        $stats = [
            'ingresos_mes' => Factura::whereBetween('created_at', [$mesActual, $mesFin])->sum('monto_pagado'),
            'pacientes_mes' => Cita::whereBetween('fecha', [$mesActual, $mesFin])->distinct('paciente_id')->count('paciente_id'),
            'citas_mes' => Cita::whereBetween('fecha', [$mesActual, $mesFin])->count(),
            'tratamientos_mes' => Expediente::whereBetween('fecha', [$mesActual, $mesFin])->count(),
        ];

        return view('reportes.index', compact('breadcrumbs', 'stats'));
    }

    /**
     * Reporte de facturas por rango de fechas y filtros opcionales.
     * GET /reportes/facturas
     */
    public function facturas(Request $request)
    {
        // Filtros
        $desde = $request->input('desde');
        $hasta = $request->input('hasta');
        $estado = $request->input('estado');
        $metodo = $request->input('metodo_pago');

        $query = Factura::with(['paciente', 'tratamiento'])
            ->orderByDesc('created_at');

        if ($desde) {
            try {
                $desde = Carbon::parse($desde)->startOfDay();
            } catch (\Exception $e) {
                $desde = null;
            }
        }

        if ($hasta) {
            try {
                $hasta = Carbon::parse($hasta)->endOfDay();
            } catch (\Exception $e) {
                $hasta = null;
            }
        }

        if ($desde) {
            $query->where('created_at', '>=', $desde);
        }
        if ($hasta) {
            $query->where('created_at', '<=', $hasta);
        }
        if ($estado) {
            $query->where('estado', $estado);
        }
        if ($metodo) {
            $query->where('metodo_pago', $metodo);
        }

        $facturas = $query->paginate(20)->withQueryString();

        // Totales (sin paginación)
        $totalesQuery = Factura::query();
        if ($desde) {
            $totalesQuery->where('created_at', '>=', $desde);
        }
        if ($hasta) {
            $totalesQuery->where('created_at', '<=', $hasta);
        }
        if ($estado) {
            $totalesQuery->where('estado', $estado);
        }
        if ($metodo) {
            $totalesQuery->where('metodo_pago', $metodo);
        }

        $sumTotal = (clone $totalesQuery)->sum('monto_total');
        $sumPagado = (clone $totalesQuery)->sum('monto_pagado');
        $sumSaldo = (clone $totalesQuery)->sum('saldo_pendiente');

        $breadcrumbs = [
            ['name' => 'Inicio', 'url' => route('home')],
            ['name' => 'Reportes', 'url' => route('reportes.facturas')],
            ['name' => 'Reporte de facturas'],
        ];

        return view('reportes.facturas', compact(
            'facturas',
            'desde',
            'hasta',
            'estado',
            'metodo',
            'sumTotal',
            'sumPagado',
            'sumSaldo',
            'breadcrumbs'
        ));
    }

    /**
     * Reporte de tratamientos realizados
     * GET /reportes/tratamientos
     */
    public function tratamientos(Request $request)
    {
        $desde = $request->input('desde');
        $hasta = $request->input('hasta');

        if ($desde) {
            try {
                $desde = Carbon::parse($desde)->startOfDay();
            } catch (\Exception $e) {
                $desde = null;
            }
        }

        if ($hasta) {
            try {
                $hasta = Carbon::parse($hasta)->endOfDay();
            } catch (\Exception $e) {
                $hasta = null;
            }
        }

        // Tratamientos más realizados (desde expedientes)
        $query = Expediente::with(['tratamiento', 'paciente', 'odontologo'])
            ->orderByDesc('fecha');

        if ($desde) {
            $query->where('fecha', '>=', $desde);
        }
        if ($hasta) {
            $query->where('fecha', '<=', $hasta);
        }

        $expedientes = $query->paginate(20)->withQueryString();

        // Estadísticas de tratamientos
        $statsQuery = Expediente::query();
        if ($desde) {
            $statsQuery->where('fecha', '>=', $desde);
        }
        if ($hasta) {
            $statsQuery->where('fecha', '<=', $hasta);
        }

        $tratamientosMasRealizados = (clone $statsQuery)
            ->select('tratamiento_id', DB::raw('count(*) as total'))
            ->with('tratamiento')
            ->groupBy('tratamiento_id')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $totalTratamientos = (clone $statsQuery)->count();

        $breadcrumbs = [
            ['name' => 'Inicio', 'url' => route('home')],
            ['name' => 'Reportes', 'url' => route('reportes.index')],
            ['name' => 'Tratamientos realizados'],
        ];

        return view('reportes.tratamientos', compact(
            'expedientes',
            'tratamientosMasRealizados',
            'totalTratamientos',
            'desde',
            'hasta',
            'breadcrumbs'
        ));
    }

    /**
     * Reporte de ingresos
     * GET /reportes/ingresos
     */
    public function ingresos(Request $request)
    {
        $desde = $request->input('desde');
        $hasta = $request->input('hasta');

        if ($desde) {
            try {
                $desde = Carbon::parse($desde)->startOfDay();
            } catch (\Exception $e) {
                $desde = null;
            }
        }

        if ($hasta) {
            try {
                $hasta = Carbon::parse($hasta)->endOfDay();
            } catch (\Exception $e) {
                $hasta = null;
            }
        }

        // Query base
        $query = Factura::with(['paciente', 'tratamiento']);

        if ($desde) {
            $query->where('created_at', '>=', $desde);
        }
        if ($hasta) {
            $query->where('created_at', '<=', $hasta);
        }

        // Totales generales
        $totalFacturado = (clone $query)->sum('monto_total');
        $totalCobrado = (clone $query)->sum('monto_pagado');
        $totalPendiente = (clone $query)->sum('saldo_pendiente');

        // Ingresos por método de pago
        $ingresosPorMetodo = (clone $query)
            ->select('metodo_pago', DB::raw('SUM(monto_pagado) as total'))
            ->groupBy('metodo_pago')
            ->get();

        // Ingresos por tratamiento
        $ingresosPorTratamiento = (clone $query)
            ->select('tratamiento_id', DB::raw('SUM(monto_pagado) as total'), DB::raw('COUNT(*) as cantidad'))
            ->with('tratamiento')
            ->groupBy('tratamiento_id')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        // Ingresos por mes (últimos 6 meses si no hay filtro)
        if (!$desde && !$hasta) {
            $hace6Meses = Carbon::now()->subMonths(6)->startOfMonth();
            $ingresosPorMes = Factura::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as mes'),
                DB::raw('SUM(monto_pagado) as total')
            )
                ->where('created_at', '>=', $hace6Meses)
                ->groupBy('mes')
                ->orderBy('mes')
                ->get();
        } else {
            $ingresosPorMes = collect();
        }

        $breadcrumbs = [
            ['name' => 'Inicio', 'url' => route('home')],
            ['name' => 'Reportes', 'url' => route('reportes.index')],
            ['name' => 'Ingresos'],
        ];

        return view('reportes.ingresos', compact(
            'totalFacturado',
            'totalCobrado',
            'totalPendiente',
            'ingresosPorMetodo',
            'ingresosPorTratamiento',
            'ingresosPorMes',
            'desde',
            'hasta',
            'breadcrumbs'
        ));
    }

    /**
     * Reporte de pacientes atendidos
     * GET /reportes/pacientes
     */
    public function pacientes(Request $request)
    {
        $desde = $request->input('desde');
        $hasta = $request->input('hasta');

        if ($desde) {
            try {
                $desde = Carbon::parse($desde)->startOfDay();
            } catch (\Exception $e) {
                $desde = null;
            }
        }

        if ($hasta) {
            try {
                $hasta = Carbon::parse($hasta)->endOfDay();
            } catch (\Exception $e) {
                $hasta = null;
            }
        }

        // Pacientes atendidos (que tuvieron citas)
        $queryPacientes = Cita::with('paciente')
            ->where('estado', '!=', 'cancelada');

        if ($desde) {
            $queryPacientes->where('fecha', '>=', $desde);
        }
        if ($hasta) {
            $queryPacientes->where('fecha', '<=', $hasta);
        }

        $pacientesAtendidos = $queryPacientes
            ->select('paciente_id', DB::raw('COUNT(*) as total_citas'))
            ->groupBy('paciente_id')
            ->orderByDesc('total_citas')
            ->paginate(20)
            ->withQueryString();

        // Estadísticas
        $totalPacientes = Paciente::count();
        $pacientesNuevos = Paciente::query();
        if ($desde) {
            $pacientesNuevos->where('created_at', '>=', $desde);
        }
        if ($hasta) {
            $pacientesNuevos->where('created_at', '<=', $hasta);
        }
        $totalPacientesNuevos = $pacientesNuevos->count();

        $citasCompletadas = Cita::where('estado', 'completada');
        if ($desde) {
            $citasCompletadas->where('fecha', '>=', $desde);
        }
        if ($hasta) {
            $citasCompletadas->where('fecha', '<=', $hasta);
        }
        $totalCitasCompletadas = $citasCompletadas->count();

        $citasCanceladas = Cita::whereIn('estado', ['cancelada', 'no_asistio']);
        if ($desde) {
            $citasCanceladas->where('fecha', '>=', $desde);
        }
        if ($hasta) {
            $citasCanceladas->where('fecha', '<=', $hasta);
        }
        $totalCitasCanceladas = $citasCanceladas->count();

        $breadcrumbs = [
            ['name' => 'Inicio', 'url' => route('home')],
            ['name' => 'Reportes', 'url' => route('reportes.index')],
            ['name' => 'Pacientes atendidos'],
        ];

        return view('reportes.pacientes', compact(
            'pacientesAtendidos',
            'totalPacientes',
            'totalPacientesNuevos',
            'totalCitasCompletadas',
            'totalCitasCanceladas',
            'desde',
            'hasta',
            'breadcrumbs'
        ));
    }

    /**
     * Reporte de inventario de materiales
     * GET /reportes/inventario
     */
    public function inventario(Request $request)
    {
        // Materiales con stock bajo (stock actual menor al stock mínimo)
        $materialesBajos = Material::whereRaw('stock_actual < stock_minimo')
            ->orderBy('stock_actual', 'asc')
            ->get();

        // Materiales con más valor en inventario
        $materialesPorValor = Material::select('*', DB::raw('stock_actual * precio_unitario as valor_total'))
            ->orderByDesc('valor_total')
            ->limit(10)
            ->get();

        // Todos los materiales
        $materiales = Material::orderBy('nombre')->paginate(20);

        // Totales
        $totalMateriales = Material::count();
        $valorTotalInventario = Material::sum(DB::raw('stock_actual * precio_unitario'));

        $breadcrumbs = [
            ['name' => 'Inicio', 'url' => route('home')],
            ['name' => 'Reportes', 'url' => route('reportes.index')],
            ['name' => 'Inventario de materiales'],
        ];

        return view('reportes.inventario', compact(
            'materiales',
            'materialesBajos',
            'materialesPorValor',
            'totalMateriales',
            'valorTotalInventario',
            'breadcrumbs'
        ));
    }

    /**
     * Exportar reporte de facturas a PDF
     * GET /reportes/facturas/pdf
     */
    public function facturasPdf(Request $request)
    {
        $desde = $request->input('desde');
        $hasta = $request->input('hasta');
        $estado = $request->input('estado');
        $metodo = $request->input('metodo_pago');

        $query = Factura::with(['paciente', 'tratamiento'])
            ->orderByDesc('created_at');

        if ($desde) {
            $desde = Carbon::parse($desde)->startOfDay();
            $query->where('created_at', '>=', $desde);
        }
        if ($hasta) {
            $hasta = Carbon::parse($hasta)->endOfDay();
            $query->where('created_at', '<=', $hasta);
        }
        if ($estado) {
            $query->where('estado', $estado);
        }
        if ($metodo) {
            $query->where('metodo_pago', $metodo);
        }

        $facturas = $query->get();
        $sumTotal = $facturas->sum('monto_total');
        $sumPagado = $facturas->sum('monto_pagado');
        $sumSaldo = $facturas->sum('saldo_pendiente');

        $pdf = Pdf::loadView('reportes.pdf.facturas', compact(
            'facturas',
            'desde',
            'hasta',
            'estado',
            'metodo',
            'sumTotal',
            'sumPagado',
            'sumSaldo'
        ));

        return $pdf->download('reporte_facturas_' . Carbon::now()->format('Y-m-d_His') . '.pdf');
    }

    /**
     * Exportar reporte de tratamientos a PDF
     * GET /reportes/tratamientos/pdf
     */
    public function tratamientosPdf(Request $request)
    {
        $desde = $request->input('desde');
        $hasta = $request->input('hasta');

        if ($desde) {
            $desde = Carbon::parse($desde)->startOfDay();
        }
        if ($hasta) {
            $hasta = Carbon::parse($hasta)->endOfDay();
        }

        $query = Expediente::with(['tratamiento', 'paciente', 'odontologo'])
            ->orderByDesc('fecha');

        if ($desde) {
            $query->where('fecha', '>=', $desde);
        }
        if ($hasta) {
            $query->where('fecha', '<=', $hasta);
        }

        $expedientes = $query->get();

        $statsQuery = Expediente::query();
        if ($desde) {
            $statsQuery->where('fecha', '>=', $desde);
        }
        if ($hasta) {
            $statsQuery->where('fecha', '<=', $hasta);
        }

        $tratamientosMasRealizados = $statsQuery
            ->select('tratamiento_id', DB::raw('count(*) as total'))
            ->with('tratamiento')
            ->groupBy('tratamiento_id')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $totalTratamientos = $statsQuery->count();

        $pdf = Pdf::loadView('reportes.pdf.tratamientos', compact(
            'expedientes',
            'tratamientosMasRealizados',
            'totalTratamientos',
            'desde',
            'hasta'
        ));

        return $pdf->download('reporte_tratamientos_' . Carbon::now()->format('Y-m-d_His') . '.pdf');
    }

    /**
     * Exportar reporte de ingresos a PDF
     * GET /reportes/ingresos/pdf
     */
    public function ingresosPdf(Request $request)
    {
        $desde = $request->input('desde');
        $hasta = $request->input('hasta');

        if ($desde) {
            $desde = Carbon::parse($desde)->startOfDay();
        }
        if ($hasta) {
            $hasta = Carbon::parse($hasta)->endOfDay();
        }

        $query = Factura::with(['paciente', 'tratamiento']);

        if ($desde) {
            $query->where('created_at', '>=', $desde);
        }
        if ($hasta) {
            $query->where('created_at', '<=', $hasta);
        }

        $totalFacturado = $query->sum('monto_total');
        $totalCobrado = $query->sum('monto_pagado');
        $totalPendiente = $query->sum('saldo_pendiente');

        $ingresosPorMetodo = (clone $query)
            ->select('metodo_pago', DB::raw('SUM(monto_pagado) as total'))
            ->groupBy('metodo_pago')
            ->get();

        $ingresosPorTratamiento = (clone $query)
            ->select('tratamiento_id', DB::raw('SUM(monto_pagado) as total'), DB::raw('COUNT(*) as cantidad'))
            ->with('tratamiento')
            ->groupBy('tratamiento_id')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $pdf = Pdf::loadView('reportes.pdf.ingresos', compact(
            'totalFacturado',
            'totalCobrado',
            'totalPendiente',
            'ingresosPorMetodo',
            'ingresosPorTratamiento',
            'desde',
            'hasta'
        ));

        return $pdf->download('reporte_ingresos_' . Carbon::now()->format('Y-m-d_His') . '.pdf');
    }

    /**
     * Exportar reporte de pacientes a PDF
     * GET /reportes/pacientes/pdf
     */
    public function pacientesPdf(Request $request)
    {
        $desde = $request->input('desde');
        $hasta = $request->input('hasta');

        if ($desde) {
            $desde = Carbon::parse($desde)->startOfDay();
        }
        if ($hasta) {
            $hasta = Carbon::parse($hasta)->endOfDay();
        }

        $queryPacientes = Paciente::with(['citas' => function ($query) use ($desde, $hasta) {
            if ($desde) {
                $query->where('fecha', '>=', $desde);
            }
            if ($hasta) {
                $query->where('fecha', '<=', $hasta);
            }
        }])->get();

        $totalPacientes = Paciente::count();

        $pacientesNuevos = Paciente::query();
        if ($desde) {
            $pacientesNuevos->where('created_at', '>=', $desde);
        }
        if ($hasta) {
            $pacientesNuevos->where('created_at', '<=', $hasta);
        }
        $totalPacientesNuevos = $pacientesNuevos->count();

        $citasCompletadas = Cita::where('estado', 'completada');
        if ($desde) {
            $citasCompletadas->where('fecha', '>=', $desde);
        }
        if ($hasta) {
            $citasCompletadas->where('fecha', '<=', $hasta);
        }
        $totalCitasCompletadas = $citasCompletadas->count();

        $citasCanceladas = Cita::whereIn('estado', ['cancelada', 'no_asistio']);
        if ($desde) {
            $citasCanceladas->where('fecha', '>=', $desde);
        }
        if ($hasta) {
            $citasCanceladas->where('fecha', '<=', $hasta);
        }
        $totalCitasCanceladas = $citasCanceladas->count();

        $pdf = Pdf::loadView('reportes.pdf.pacientes', compact(
            'queryPacientes',
            'totalPacientes',
            'totalPacientesNuevos',
            'totalCitasCompletadas',
            'totalCitasCanceladas',
            'desde',
            'hasta'
        ));

        return $pdf->download('reporte_pacientes_' . Carbon::now()->format('Y-m-d_His') . '.pdf');
    }

    /**
     * Exportar reporte de inventario a PDF
     * GET /reportes/inventario/pdf
     */
    public function inventarioPdf(Request $request)
    {
        $materialesBajos = Material::whereRaw('stock_actual < stock_minimo')
            ->orderBy('stock_actual', 'asc')
            ->get();

        $materialesPorValor = Material::select('*', DB::raw('stock_actual * precio_unitario as valor_total'))
            ->orderByDesc('valor_total')
            ->limit(10)
            ->get();

        $materiales = Material::orderBy('nombre')->get();

        $totalMateriales = Material::count();
        $valorTotalInventario = Material::sum(DB::raw('stock_actual * precio_unitario'));

        $pdf = Pdf::loadView('reportes.pdf.inventario', compact(
            'materiales',
            'materialesBajos',
            'materialesPorValor',
            'totalMateriales',
            'valorTotalInventario'
        ));

        return $pdf->download('reporte_inventario_' . Carbon::now()->format('Y-m-d_His') . '.pdf');
    }
}

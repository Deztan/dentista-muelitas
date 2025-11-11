<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Factura;
use Carbon\Carbon;

class ReportesController extends Controller
{
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
}

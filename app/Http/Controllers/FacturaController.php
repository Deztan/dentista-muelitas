<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\Paciente;
use App\Models\Tratamiento;
use App\Models\Log;
use Illuminate\Http\Request;
use PDF;

class FacturaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $facturas = Factura::with(['paciente', 'tratamiento'])
            ->orderBy('fecha_emision', 'desc')
            ->paginate(15);

        Log::registrar(
            'READ',
            'facturas',
            'Acceso a lista de facturas',
            [
                'level' => Log::INFO,
                'resource_type' => 'Factura',
                'metadata' => ['total_facturas' => $facturas->total()],
                'compliance_tag' => 'FINANCIAL'
            ]
        );

        return view('facturas.index', compact('facturas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pacientes = Paciente::orderBy('nombre_completo')->get();
        $tratamientos = Tratamiento::orderBy('nombre')->get();

        return view('facturas.create', compact('pacientes', 'tratamientos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'tratamiento_id' => 'required|exists:tratamientos,id',
            'fecha_emision' => 'required|date',
            'monto_total' => 'required|numeric|min:0',
            'monto_pagado' => 'required|numeric|min:0',
            'metodo_pago' => 'required|in:efectivo,tarjeta,transferencia,qr',
            'estado' => 'required|in:pendiente,pagada,cancelada',
            'observaciones' => 'nullable|string',
        ]);

        // Calcular saldo pendiente
        $validated['saldo_pendiente'] = $validated['monto_total'] - $validated['monto_pagado'];

        $factura = Factura::create($validated);
        $paciente = Paciente::find($factura->paciente_id);

        Log::crear('facturas', $factura->id, "Factura emitida: #{$factura->numero_factura} - {$paciente->nombre_completo} - Bs. {$factura->monto_total}", $validated, ['resource_type' => 'Factura', 'compliance_tag' => 'FINANCIAL']);

        return redirect()->route('facturas.index')
            ->with('success', 'Factura creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $factura = Factura::with(['paciente', 'tratamiento'])->findOrFail($id);

        Log::registrar(
            'READ',
            'facturas',
            "Visualización de factura #{$factura->numero_factura}",
            [
                'level' => Log::INFO,
                'resource_type' => 'Factura',
                'resource_id' => $id,
                'compliance_tag' => 'FINANCIAL'
            ]
        );

        return view('facturas.show', compact('factura'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $factura = Factura::findOrFail($id);
        $pacientes = Paciente::orderBy('nombre_completo')->get();
        $tratamientos = Tratamiento::orderBy('nombre')->get();

        Log::registrar(
            'READ',
            'facturas',
            "Acceso a formulario de edición de factura #{$factura->numero_factura}",
            [
                'level' => Log::INFO,
                'resource_type' => 'Factura',
                'resource_id' => $id,
                'compliance_tag' => 'FINANCIAL'
            ]
        );

        return view('facturas.edit', compact('factura', 'pacientes', 'tratamientos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'tratamiento_id' => 'required|exists:tratamientos,id',
            'fecha_emision' => 'required|date',
            'monto_total' => 'required|numeric|min:0',
            'monto_pagado' => 'required|numeric|min:0',
            'metodo_pago' => 'required|in:efectivo,tarjeta,transferencia,qr',
            'estado' => 'required|in:pendiente,pagada,cancelada',
            'observaciones' => 'nullable|string',
        ]);

        // Calcular saldo pendiente
        $validated['saldo_pendiente'] = $validated['monto_total'] - $validated['monto_pagado'];

        $factura = Factura::findOrFail($id);
        $datosAnteriores = $factura->toArray();
        $factura->update($validated);
        $paciente = Paciente::find($factura->paciente_id);

        Log::editar('facturas', $factura->id, "Factura modificada: #{$factura->numero_factura}", $datosAnteriores, $validated, ['resource_type' => 'Factura', 'compliance_tag' => 'FINANCIAL']);

        return redirect()->route('facturas.show', $factura->id)
            ->with('success', 'Factura actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $factura = Factura::findOrFail($id);
        $paciente = Paciente::find($factura->paciente_id);
        $numeroFactura = $factura->numero_factura;
        $datosAnteriores = $factura->toArray();
        $factura->delete();

        Log::eliminar('facturas', $id, "Factura anulada: #{$numeroFactura}", $datosAnteriores, ['resource_type' => 'Factura', 'compliance_tag' => 'FINANCIAL']);

        return redirect()->route('facturas.index')
            ->with('success', 'Factura eliminada exitosamente.');
    }

    /**
     * Imprimir/Exportar factura a PDF
     */
    public function print(string $id)
    {
        $factura = Factura::with(['paciente', 'tratamiento'])->findOrFail($id);

        $pdf = PDF::loadView('facturas.print', compact('factura'));

        return $pdf->download('factura_' . $factura->numero_factura . '.pdf');
    }
}

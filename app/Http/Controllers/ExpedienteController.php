<?php

namespace App\Http\Controllers;

use App\Models\Expediente;
use App\Models\Paciente;
use App\Models\Usuario;
use App\Models\Tratamiento;
use App\Models\Cita;
use Illuminate\Http\Request;

class ExpedienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expedientes = Expediente::with(['paciente', 'odontologo', 'tratamiento'])
            ->orderBy('fecha', 'desc')
            ->paginate(15);

        return view('expedientes.index', compact('expedientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pacientes = Paciente::orderBy('nombre_completo')->get();
        $odontologos = Usuario::where('rol', 'gerente_odontologo')
            ->where('activo', true)
            ->orderBy('nombre_completo')
            ->get();
        $asistentes = Usuario::whereIn('rol', ['asistente_directo', 'enfermera'])
            ->where('activo', true)
            ->orderBy('nombre_completo')
            ->get();
        $tratamientos = Tratamiento::orderBy('nombre')->get();
        $citas = Cita::with('paciente')
            ->where('estado', 'completada')
            ->orderBy('fecha', 'desc')
            ->get();

        return view('expedientes.create', compact('pacientes', 'odontologos', 'asistentes', 'tratamientos', 'citas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'cita_id' => 'nullable|exists:citas,id',
            'tratamiento_id' => 'nullable|exists:tratamientos,id',
            'odontologo_id' => 'required|exists:usuarios,id',
            'asistente_id' => 'nullable|exists:usuarios,id',
            'fecha' => 'required|date',
            'diagnostico' => 'nullable|string',
            'descripcion_tratamiento' => 'nullable|string',
            'pieza_dental' => 'nullable|string|max:10',
            'observaciones' => 'nullable|string',
        ]);

        Expediente::create($validated);

        return redirect()->route('expedientes.index')
            ->with('success', 'Expediente creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $expediente = Expediente::with(['paciente', 'cita', 'tratamiento', 'odontologo', 'asistente'])
            ->findOrFail($id);

        return view('expedientes.show', compact('expediente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $expediente = Expediente::findOrFail($id);
        $pacientes = Paciente::orderBy('nombre_completo')->get();
        $odontologos = Usuario::where('rol', 'gerente_odontologo')
            ->where('activo', true)
            ->orderBy('nombre_completo')
            ->get();
        $asistentes = Usuario::whereIn('rol', ['asistente_directo', 'enfermera'])
            ->where('activo', true)
            ->orderBy('nombre_completo')
            ->get();
        $tratamientos = Tratamiento::orderBy('nombre')->get();
        $citas = Cita::with('paciente')
            ->where('estado', 'completada')
            ->orderBy('fecha', 'desc')
            ->get();

        return view('expedientes.edit', compact('expediente', 'pacientes', 'odontologos', 'asistentes', 'tratamientos', 'citas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'cita_id' => 'nullable|exists:citas,id',
            'tratamiento_id' => 'nullable|exists:tratamientos,id',
            'odontologo_id' => 'required|exists:usuarios,id',
            'asistente_id' => 'nullable|exists:usuarios,id',
            'fecha' => 'required|date',
            'diagnostico' => 'nullable|string',
            'descripcion_tratamiento' => 'nullable|string',
            'pieza_dental' => 'nullable|string|max:10',
            'observaciones' => 'nullable|string',
        ]);

        $expediente = Expediente::findOrFail($id);
        $expediente->update($validated);

        return redirect()->route('expedientes.show', $expediente->id)
            ->with('success', 'Expediente actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $expediente = Expediente::findOrFail($id);
        $expediente->delete();

        return redirect()->route('expedientes.index')
            ->with('success', 'Expediente eliminado exitosamente.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Paciente;
use App\Models\Tratamiento;
use App\Models\Usuario;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $citas = Cita::with(['paciente', 'tratamiento', 'usuario'])
            ->orderBy('fecha', 'desc')
            ->orderBy('hora', 'desc')
            ->paginate(15);

        return view('citas.index', compact('citas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pacientes = Paciente::orderBy('nombre_completo')->get();
        $tratamientos = Tratamiento::orderBy('nombre')->get();
        $usuarios = Usuario::where('rol', 'gerente_odontologo')
            ->where('activo', true)
            ->orderBy('nombre_completo')
            ->get();

        return view('citas.create', compact('pacientes', 'tratamientos', 'usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'usuario_id' => 'required|exists:usuarios,id',
            'tratamiento_id' => 'nullable|exists:tratamientos,id',
            'fecha' => 'required|date',
            'hora' => 'required|date_format:H:i',
            'motivo' => 'required|string|max:500',
            'observaciones' => 'nullable|string',
            'estado' => 'required|in:pendiente,confirmada,completada,cancelada',
        ]);

        Cita::create($validated);

        return redirect()->route('citas.index')
            ->with('success', 'Cita agendada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cita = Cita::with(['paciente', 'tratamiento', 'usuario'])->findOrFail($id);
        return view('citas.show', compact('cita'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cita = Cita::findOrFail($id);
        $pacientes = Paciente::orderBy('nombre_completo')->get();
        $tratamientos = Tratamiento::orderBy('nombre')->get();
        $usuarios = Usuario::where('rol', 'gerente_odontologo')
            ->where('activo', true)
            ->orderBy('nombre_completo')
            ->get();

        return view('citas.edit', compact('cita', 'pacientes', 'tratamientos', 'usuarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'usuario_id' => 'required|exists:usuarios,id',
            'tratamiento_id' => 'nullable|exists:tratamientos,id',
            'fecha' => 'required|date',
            'hora' => 'required|date_format:H:i',
            'motivo' => 'required|string|max:500',
            'observaciones' => 'nullable|string',
            'estado' => 'required|in:pendiente,confirmada,completada,cancelada',
        ]);

        $cita = Cita::findOrFail($id);
        $cita->update($validated);

        return redirect()->route('citas.show', $cita->id)
            ->with('success', 'Cita actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cita = Cita::findOrFail($id);
        $cita->delete();

        return redirect()->route('citas.index')
            ->with('success', 'Cita eliminada exitosamente.');
    }
}

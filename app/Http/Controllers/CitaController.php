<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Paciente;
use App\Models\Tratamiento;
use App\Models\Usuario;
use App\Models\Log;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $citas = Cita::with(['paciente', 'tratamiento', 'odontologo', 'asistente'])
            ->orderBy('fecha', 'desc')
            ->orderBy('hora', 'desc')
            ->paginate(15);

        Log::registrar(
            'READ',
            'citas',
            'Acceso a lista de citas',
            [
                'level' => Log::INFO,
                'resource_type' => 'Cita',
                'metadata' => ['total_citas' => $citas->total()]
            ]
        );

        return view('citas.index', compact('citas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pacientes = Paciente::orderBy('nombre_completo', 'asc')->get();
        $tratamientos = Tratamiento::orderBy('nombre')->get();
        $odontologos = Usuario::whereIn('rol', ['gerente', 'odontologo'])
            ->where('activo', true)
            ->orderBy('nombre_completo')
            ->get();
        $asistentes = Usuario::where('rol', 'asistente_directo')
            ->where('activo', true)
            ->orderBy('nombre_completo')
            ->get();

        return view('citas.create', compact('pacientes', 'tratamientos', 'odontologos', 'asistentes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'odontologo_id' => 'required|exists:usuarios,id',
            'asistente_id' => 'nullable|exists:usuarios,id',
            'tratamiento_id' => 'nullable|exists:tratamientos,id',
            'fecha' => 'required|date',
            'hora' => 'required|date_format:H:i',
            'duracion_minutos' => 'required|integer|min:15|max:240',
            'motivo' => 'required|string|max:500',
            'observaciones' => 'nullable|string',
            'estado' => 'required|in:agendada,confirmada,en_curso,completada,cancelada,no_asistio',
        ]);

        $cita = Cita::create($validated);
        $paciente = Paciente::find($cita->paciente_id);

        // Registrar en logs
        Log::crear(
            'citas',
            $cita->id,
            "Cita agendada para {$paciente->nombre_completo} - {$cita->fecha} {$cita->hora}",
            $validated,
            ['resource_type' => 'Cita', 'detail' => "Cita médica programada para el {$cita->fecha}"]
        );

        return redirect()->route('citas.index')
            ->with('success', 'Cita agendada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cita = Cita::with(['paciente', 'tratamiento', 'odontologo', 'asistente'])->findOrFail($id);

        Log::registrar(
            'READ',
            'citas',
            "Visualización de cita #{$id}",
            [
                'level' => Log::INFO,
                'resource_type' => 'Cita',
                'resource_id' => $id
            ]
        );

        return view('citas.show', compact('cita'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cita = Cita::findOrFail($id);
        $pacientes = Paciente::orderBy('nombre_completo', 'asc')->get();
        $tratamientos = Tratamiento::orderBy('nombre')->get();
        $usuarios = Usuario::whereIn('rol', ['gerente', 'odontologo'])
            ->where('activo', true)
            ->orderBy('nombre_completo')
            ->get();

        Log::registrar(
            'READ',
            'citas',
            "Acceso a formulario de edición de cita #{$id}",
            [
                'level' => Log::INFO,
                'resource_type' => 'Cita',
                'resource_id' => $id
            ]
        );

        return view('citas.edit', compact('cita', 'pacientes', 'tratamientos', 'usuarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'odontologo_id' => 'required|exists:usuarios,id',
            'asistente_id' => 'nullable|exists:usuarios,id',
            'tratamiento_id' => 'nullable|exists:tratamientos,id',
            'fecha' => 'required|date',
            'hora' => 'required|date_format:H:i',
            'duracion_minutos' => 'required|integer|min:15|max:240',
            'motivo' => 'required|string|max:500',
            'observaciones' => 'nullable|string',
            'estado' => 'required|in:agendada,confirmada,en_curso,completada,cancelada,no_asistio',
        ]);

        $cita = Cita::findOrFail($id);
        $datosAnteriores = $cita->toArray();
        $cita->update($validated);
        $paciente = Paciente::find($cita->paciente_id);

        // Registrar en logs
        Log::editar(
            'citas',
            $cita->id,
            "Cita modificada: {$paciente->nombre_completo}",
            $datosAnteriores,
            $validated,
            ['resource_type' => 'Cita']
        );

        return redirect()->route('citas.show', $cita->id)
            ->with('success', 'Cita actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cita = Cita::findOrFail($id);
        $paciente = Paciente::find($cita->paciente_id);
        $datosAnteriores = $cita->toArray();
        $cita->delete();

        // Registrar en logs
        Log::eliminar(
            'citas',
            $id,
            "Cita cancelada: {$paciente->nombre_completo}",
            $datosAnteriores,
            ['resource_type' => 'Cita']
        );

        return redirect()->route('citas.index')
            ->with('success', 'Cita eliminada exitosamente.');
    }
}

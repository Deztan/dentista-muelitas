<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\Log;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    /**
     * Display a listing of the resource.
     * Muestra la lista de todos los pacientes
     */
    public function index()
    {
        $pacientes = Paciente::orderBy('created_at', 'desc')->paginate(10);

        Log::registrar(
            'READ',
            'pacientes',
            'Acceso a lista de pacientes',
            [
                'level' => Log::INFO,
                'resource_type' => 'Paciente',
                'metadata' => ['total_pacientes' => $pacientes->total()]
            ]
        );

        return view('pacientes.index', compact('pacientes'));
    }

    /**
     * Show the form for creating a new resource.
     * Muestra el formulario para crear un nuevo paciente
     */
    public function create()
    {
        return view('pacientes.create');
    }

    /**
     * Store a newly created resource in storage.
     * Guarda un nuevo paciente en la base de datos
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date',
            'genero' => 'required|in:masculino,femenino,otro',
            'telefono' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'direccion' => 'required|string|max:500',
            'ciudad' => 'required|string|max:100',
            'alergias' => 'nullable|string',
            'condiciones_medicas' => 'nullable|string',
            'contacto_emergencia' => 'nullable|string|max:255',
            'telefono_emergencia' => 'nullable|string|max:20',
        ]);

        $paciente = Paciente::create($validated);

        // Registrar en logs
        Log::crear(
            'pacientes',
            $paciente->id,
            "Paciente registrado: {$paciente->nombre_completo}",
            $validated,
            [
                'resource_type' => 'Paciente',
                'detail' => "Nuevo paciente registrado en el sistema con ID {$paciente->id}"
            ]
        );

        return redirect()->route('pacientes.index')
            ->with('success', 'Paciente creado exitosamente.');
    }

    /**
     * Display the specified resource.
     * Muestra los detalles de un paciente específico
     */
    public function show(string $id)
    {
        $paciente = Paciente::with(['citas', 'expedientes', 'facturas'])->findOrFail($id);

        Log::registrar(
            'READ',
            'pacientes',
            "Visualización de paciente: {$paciente->nombre_completo}",
            [
                'level' => Log::INFO,
                'resource_type' => 'Paciente',
                'resource_id' => $id,
                'is_sensitive' => true
            ]
        );

        return view('pacientes.show', compact('paciente'));
    }

    /**
     * Show the form for editing the specified resource.
     * Muestra el formulario para editar un paciente
     */
    public function edit(string $id)
    {
        $paciente = Paciente::findOrFail($id);

        Log::registrar(
            'READ',
            'pacientes',
            "Acceso a formulario de edición de paciente: {$paciente->nombre_completo}",
            [
                'level' => Log::INFO,
                'resource_type' => 'Paciente',
                'resource_id' => $id
            ]
        );

        return view('pacientes.edit', compact('paciente'));
    }

    /**
     * Update the specified resource in storage.
     * Actualiza los datos de un paciente
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date',
            'genero' => 'required|in:masculino,femenino,otro',
            'telefono' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'direccion' => 'required|string|max:500',
            'ciudad' => 'required|string|max:100',
            'alergias' => 'nullable|string',
            'condiciones_medicas' => 'nullable|string',
            'contacto_emergencia' => 'nullable|string|max:255',
            'telefono_emergencia' => 'nullable|string|max:20',
        ]);

        $paciente = Paciente::findOrFail($id);
        $datosAnteriores = $paciente->toArray();
        $paciente->update($validated);

        // Registrar en logs
        Log::editar(
            'pacientes',
            $paciente->id,
            "Datos actualizados del paciente: {$paciente->nombre_completo}",
            $datosAnteriores,
            $validated,
            [
                'resource_type' => 'Paciente',
                'detail' => 'Actualización de información del paciente'
            ]
        );

        return redirect()->route('pacientes.index')
            ->with('success', 'Paciente actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     * Elimina un paciente de la base de datos
     */
    public function destroy(string $id)
    {
        $paciente = Paciente::findOrFail($id);
        $nombrePaciente = $paciente->nombre_completo;
        $datosAnteriores = $paciente->toArray();
        $paciente->delete();

        // Registrar en logs
        Log::eliminar(
            'pacientes',
            $id,
            "Paciente eliminado del sistema: {$nombrePaciente}",
            $datosAnteriores,
            [
                'resource_type' => 'Paciente',
                'detail' => 'Eliminación permanente del registro de paciente',
                'is_sensitive' => true
            ]
        );

        return redirect()->route('pacientes.index')
            ->with('success', 'Paciente eliminado exitosamente.');
    }
}

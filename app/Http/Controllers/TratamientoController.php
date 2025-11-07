<?php

namespace App\Http\Controllers;

use App\Models\Tratamiento;
use Illuminate\Http\Request;

class TratamientoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tratamientos = Tratamiento::orderBy('nombre')->paginate(15);
        return view('tratamientos.index', compact('tratamientos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tratamientos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio_base' => 'required|numeric|min:0',
            'duracion_minutos' => 'required|integer|min:1',
        ]);

        Tratamiento::create($validated);

        return redirect()->route('tratamientos.index')
            ->with('success', 'Tratamiento creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tratamiento = Tratamiento::with('citas')->findOrFail($id);
        return view('tratamientos.show', compact('tratamiento'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tratamiento = Tratamiento::findOrFail($id);
        return view('tratamientos.edit', compact('tratamiento'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio_base' => 'required|numeric|min:0',
            'duracion_minutos' => 'required|integer|min:1',
        ]);

        $tratamiento = Tratamiento::findOrFail($id);
        $tratamiento->update($validated);

        return redirect()->route('tratamientos.index')
            ->with('success', 'Tratamiento actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tratamiento = Tratamiento::findOrFail($id);
        $tratamiento->delete();

        return redirect()->route('tratamientos.index')
            ->with('success', 'Tratamiento eliminado exitosamente.');
    }
}

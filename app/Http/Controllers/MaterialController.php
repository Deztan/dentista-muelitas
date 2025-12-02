<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Log;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $materiales = Material::orderBy('nombre')->paginate(15);

        Log::registrar(
            'READ',
            'materiales',
            'Acceso a lista de materiales',
            [
                'level' => Log::INFO,
                'resource_type' => 'Material',
                'metadata' => ['total_materiales' => $materiales->total()]
            ]
        );

        return view('materiales.index', compact('materiales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('materiales.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'unidad_medida' => 'required|string|max:50',
            'stock_actual' => 'required|numeric|min:0',
            'stock_minimo' => 'required|numeric|min:0',
            'precio_unitario' => 'required|numeric|min:0',
            'proveedor' => 'nullable|string|max:255',
        ]);

        $validated['activo'] = true;
        $material = Material::create($validated);

        Log::crear('materiales', $material->id, "Material agregado al inventario: {$material->nombre}", $validated, ['resource_type' => 'Material']);

        return redirect()->route('materiales.index')
            ->with('success', 'Material creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $material = Material::findOrFail($id);

        Log::registrar(
            'READ',
            'materiales',
            "Visualización de material: {$material->nombre}",
            [
                'level' => Log::INFO,
                'resource_type' => 'Material',
                'resource_id' => $id
            ]
        );

        return view('materiales.show', compact('material'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $material = Material::findOrFail($id);

        Log::registrar(
            'READ',
            'materiales',
            "Acceso a formulario de edición de material: {$material->nombre}",
            [
                'level' => Log::INFO,
                'resource_type' => 'Material',
                'resource_id' => $id
            ]
        );

        return view('materiales.edit', compact('material'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'unidad_medida' => 'required|string|max:50',
            'stock_actual' => 'required|numeric|min:0',
            'stock_minimo' => 'required|numeric|min:0',
            'precio_unitario' => 'required|numeric|min:0',
            'proveedor' => 'nullable|string|max:255',
        ]);

        $material = Material::findOrFail($id);
        $datosAnteriores = $material->toArray();
        $material->update($validated);

        Log::editar('materiales', $material->id, "Material actualizado: {$material->nombre}", $datosAnteriores, $validated, ['resource_type' => 'Material']);

        return redirect()->route('materiales.show', $material->id)
            ->with('success', 'Material actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $material = Material::findOrFail($id);
        $nombreMaterial = $material->nombre;
        $datosAnteriores = $material->toArray();
        $material->delete();

        Log::eliminar('materiales', $id, "Material eliminado del inventario: {$nombreMaterial}", $datosAnteriores, ['resource_type' => 'Material']);

        return redirect()->route('materiales.index')
            ->with('success', 'Material eliminado exitosamente.');
    }
}

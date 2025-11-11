<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UsuarioController extends Controller
{
    /**
     * Verificar que el usuario tiene permisos (solo gerente)
     */
    private function checkPermission()
    {
        if (!Auth::check() || Auth::user()->rol !== 'gerente') {
            abort(403, 'Solo el gerente puede administrar usuarios.');
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->checkPermission();
        $usuarios = Usuario::orderBy('created_at', 'desc')->paginate(10);
        return view('usuarios.index', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->checkPermission();
        return view('usuarios.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->checkPermission();
        $validated = $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email|max:255',
            'password' => 'required|string|min:8|confirmed',
            'telefono' => 'required|string|max:20',
            'rol' => 'required|in:gerente,odontologo,asistente_directo,recepcionista,enfermera',
            'activo' => 'required|boolean',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        Usuario::create($validated);

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Usuario $usuario)
    {
        $this->checkPermission();
        return view('usuarios.show', compact('usuario'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Usuario $usuario)
    {
        $this->checkPermission();
        return view('usuarios.edit', compact('usuario'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Usuario $usuario)
    {
        $this->checkPermission();
        $validated = $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:usuarios,email,' . $usuario->id,
            'telefono' => 'required|string|max:20',
            'rol' => 'required|in:gerente,odontologo,asistente_directo,recepcionista,enfermera',
            'activo' => 'required|boolean',
        ]);

        // Solo actualizar password si se proporciona uno nuevo
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'string|min:8|confirmed',
            ]);
            $validated['password'] = Hash::make($request->password);
        }

        $usuario->update($validated);

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Usuario $usuario)
    {
        $this->checkPermission();
        
        // Evitar que el usuario se elimine a sí mismo
        if ($usuario->id === Auth::id()) {
            return redirect()->route('usuarios.index')
                ->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        $usuario->delete();

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario eliminado exitosamente.');
    }
}

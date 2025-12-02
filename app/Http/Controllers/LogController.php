<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index(Request $request)
    {
        // Solo gerente puede ver logs
        if (auth()->user()->rol !== 'gerente') {
            abort(403, 'No autorizado');
        }

        $query = Log::with('usuario')->orderBy('timestamp', 'desc');

        // Filtros
        if ($request->filled('module')) {
            $query->where('module', $request->module);
        }

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        if ($request->filled('usuario_id')) {
            $query->where('usuario_id', $request->usuario_id);
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate('timestamp', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('timestamp', '<=', $request->fecha_hasta);
        }

        $logs = $query->paginate(50);

        // Para los filtros
        $usuarios = \App\Models\Usuario::orderBy('nombre_completo')->get();

        // Módulos posibles en el sistema
        $modules = collect(['auth', 'pacientes', 'citas', 'tratamientos', 'materiales', 'usuarios', 'expedientes', 'facturas'])->sort();

        // Acciones estándar
        $actions = collect(['CREATE', 'READ', 'UPDATE', 'DELETE', 'LOGIN', 'LOGOUT', 'EXPORT', 'IMPORT', 'PRINT', 'SEND'])->sort();

        // Niveles RFC 5424
        $levels = ['EMERGENCY', 'ALERT', 'CRITICAL', 'ERROR', 'WARNING', 'NOTICE', 'INFO', 'DEBUG'];

        return view('logs.index', compact('logs', 'usuarios', 'modules', 'actions', 'levels'));
    }

    public function show($id)
    {
        // Solo gerente puede ver logs
        if (auth()->user()->rol !== 'gerente') {
            abort(403, 'No autorizado');
        }

        $log = Log::with('usuario')->findOrFail($id);
        return view('logs.show', compact('log'));
    }
}

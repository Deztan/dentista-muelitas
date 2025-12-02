<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Mostrar formulario de login
     */
    public function showLoginForm()
    {
        // Si ya está autenticado, redirigir al home
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('auth.login');
    }

    /**
     * Procesar el login
     */
    public function login(Request $request)
    {
        // Validar credenciales
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Intentar autenticar
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            // Verificar si el usuario está activo
            if (!Auth::user()->activo) {
                Auth::logout();

                // Log de intento de login con cuenta inactiva
                Log::registrar(
                    Log::ACTION_LOGIN,
                    'auth',
                    'Intento de acceso con cuenta inactiva: ' . $request->email,
                    [
                        'level' => Log::WARNING,
                        'status' => 'FAILED',
                        'error_message' => 'Cuenta de usuario inactiva',
                        'metadata' => ['email' => $request->email]
                    ]
                );

                return back()->withErrors([
                    'email' => 'Tu cuenta está inactiva. Contacta al administrador.',
                ]);
            }

            // Log de login exitoso
            Log::login(Auth::user());

            return redirect()->intended(route('home'))
                ->with('success', '¡Bienvenido, ' . Auth::user()->nombre_completo . '!');
        }

        // Log de intento de login fallido
        Log::registrar(
            Log::ACTION_LOGIN,
            'auth',
            'Intento de acceso fallido: ' . $request->email,
            [
                'level' => Log::WARNING,
                'status' => 'FAILED',
                'error_message' => 'Credenciales inválidas',
                'metadata' => ['email' => $request->email]
            ]
        );

        // Si falla, regresar con error
        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    /**
     * Cerrar sesión
     */
    public function logout(Request $request)
    {
        $usuario = Auth::user();

        // Log de logout
        if ($usuario) {
            Log::logout($usuario);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Sesión cerrada exitosamente.');
    }
}

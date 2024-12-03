<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControladorLogin extends Controller
{
    public function vistaLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        // Validar entrada
        $request->validate([
            'nombre' => 'required|string',
            'password' => 'required|string',
        ]);

        // Intentar autenticación
        if (Auth::attempt($request->only('nombre', 'password'), $request->filled('remember'))) {
            $usuario = Auth::user();

            // Redirigir según el rol del usuario
            return match ($usuario->rol) {
                'Jefe de Cuadrilla' => redirect('/inicioHectarea'),
                'Encargado de Almacen' => redirect('/inicioAlmacen'),
                default => $this->logoutInvalidoRol(),
            };
        }

        // Fallo de autenticación
        return back()->withErrors(['nombre' => 'Las credenciales no coinciden.']);
    }

    private function logoutInvalidoRol()
    {
        Auth::logout();
        return redirect('/login')->withErrors(['rol' => 'Rol no válido.']);
    }
}

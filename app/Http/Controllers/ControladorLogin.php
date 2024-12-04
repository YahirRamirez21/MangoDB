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

        $request->validate([
            'nombre' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Usuario::estaLogueadoEnOtraSesion($request->input('nombre'))) {
            return back()->withErrors(['nombre' => 'Este usuario ya está logueado en otra sesión.']);
        }

        if (Auth::attempt($request->only('nombre', 'password'), $request->filled('remember'))) {
            Usuario::marcarComoLogueado(Auth::user()->nombre);

            $usuarioLogeado = Auth::user();

            return match ($usuarioLogeado->rol) {
                'Jefe de Cuadrilla' => redirect('/inicioHectarea'),
                'Encargado de Almacen' => redirect('/inicioAlmacen'),
                default => $this->logoutInvalidoRol(),
            };
        }

        return back()->withErrors(['nombre' => 'Las credenciales no coinciden.']);
    }

    private function logoutInvalidoRol()
    {
        Auth::logout();
        return redirect('/login')->withErrors(['rol' => 'Rol no válido.']);
    }

    public function logout(Request $request)
    {
        Usuario::eliminarSesion(Auth::user()->nombre);

        Auth::logout();

        return redirect('/login');
    }
}

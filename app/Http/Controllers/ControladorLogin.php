<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControladorLogin extends Controller
{
     // Inyectamos el modelo Usuario
     protected $usuario;

     public function __construct(Usuario $usuario)
     {
         $this->usuario = $usuario;
     }

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

        // Verificar si el usuario ya está logueado en otra sesión
        if ($this->usuario->estaLogueadoEnOtraSesion($request->input('nombre'))) {
            return back()->withErrors(['nombre' => 'Este usuario ya está logueado en otra sesión.']);
        }

        // Intentar autenticación
        if (Auth::attempt($request->only('nombre', 'password'), $request->filled('remember'))) {
            // Marcar al usuario como logueado usando caché
            $this->usuario->marcarComoLogueado(Auth::user()->nombre);
            
            $usuarioLogeado = Auth::user();

            // Redirigir según el rol del usuario
            return match ($usuarioLogeado->rol) {
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

    public function logout(Request $request)
    {
        // Eliminar la clave de caché cuando el usuario se desloguea
        $this->usuario->eliminarSesion(Auth::user()->nombre);

        // Desloguear al usuario
        Auth::logout();

        // Redirigir al login
        return redirect('/login');
    }
}

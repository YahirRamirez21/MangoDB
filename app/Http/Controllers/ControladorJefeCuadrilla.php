<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hectarea;
use App\Models\Caja;
use Illuminate\Support\Facades\Auth;

class ControladorJefeCuadrilla extends Controller
{
    public function index(Request $request)
    {
        $usuario = Auth::user();
        if ($usuario) {
            $hectareas = Hectarea::getByUserId($usuario->id); // Lógica delegada al modelo
            return view('inicioJC', compact('hectareas')); // Pasar hectáreas a la vista
        }

        return redirect()->route('login')->with('error', 'Usuario no autenticado');
    }

    public function informacionHectarea($id)
    {
        $hectarea = Hectarea::find($id); // Obtener la hectárea por ID

        if ($hectarea) {
            return view('infoHectareaJC', compact('hectarea'));
        } else {
            return redirect()->route('inicioHectarea')->with('error', 'Hectárea no encontrada');
        }
    }

    
}

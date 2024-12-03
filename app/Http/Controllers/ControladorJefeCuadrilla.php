<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hectarea;
use App\Models\Caja;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
        $usuario = Auth::user();
        if ($usuario) {
            // Obtiene la hectárea y valida que pertenezca al usuario autenticado.
            $hectarea = Hectarea::obtenerHectareaDeUsuario($id, $usuario->id);

            if (!$hectarea) {
                return redirect()->route('hectareas.index')->with('error', 'No tienes permiso para acceder a esta hectárea');
            }

            return view('infoHectareaJC', compact('hectarea'));
        }
    }

    public function cambiarEstadoCosecha(Request $request, $id)
    {
        $action = $request->input('action');
        if ($action == 'registrar') {
            $hectarea = Hectarea::obtenerHectarea($id);
            if ($hectarea) {
                Hectarea::cambiarEstado($hectarea);
                return redirect()->route('hectareas.info', $id)->with('success', 'Estado de cosecha actualizado correctamente');
            }
        }
    }

    public function crearCajas($hectarea_id)
    {
        return view('cajaCreateHectareaEA', compact('hectarea_id'));
    }

    public function registrarCaja(Request $request)
    {
        $action = $request->input('action');
        if ($action == 'crear') {
            $id = $request->input('hectarea');
            $calidad = $request->input('calidad');
            $kilogramos = $request->input('kilogramos');
            $fecha_recoleccion = Carbon::now();

            if (empty($kilogramos)) {
                $caja = new Caja(); 
                $caja->id_hectarea = $id;
                $caja->kilogramos = $kilogramos;
                $caja->calidad = $calidad;
                $caja->fecha_cosecha = $fecha_recoleccion;
                $cajaCreadaBD = Caja::registrarCaja($caja);
                return view('cajaCreateHectareaEA', [
                    'hectarea_id' => $id, 
                    'cajaCreadaBD' => $cajaCreadaBD
                ])->with('success', 'Caja creada con éxito.');
            }
        }
    }
}

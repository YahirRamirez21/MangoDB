<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Caja;
use App\Models\Posicion;
use App\Models\Almacen;
use Carbon\Carbon;

class ControladorEncargadoAlmacen extends Controller
{
    protected $caja;
    protected $posicion;
    protected $almacen;

    public function __construct(Caja $caja, Posicion $posicion, Almacen $almacen)
    {
        $this->caja = $caja;
        $this->posicion = $posicion;
        $this->almacen = $almacen;
    }

    public function mostrarCaja(Request $request, $tipo)
    {
        $action = $request->input('action');

        if ($action === 'buscar') {
            $caja = null;

            if ($request->has('box-id') && $request->input('box-id') !== '') {
                $id = $request->input('box-id');
                $caja = $this->caja->findById($id);

                if (!$caja) {
                    return response()->json(['message' => 'Caja no encontrada'], 404);
                }

                if (str_replace(' ', '', $caja->calidad) !== $tipo) {
                    return redirect()->back()->with('error', 'La caja no pertenece al almacén seleccionado.');
                }

                $almacen = $this->almacen->findByTipo($tipo);
                $posicion = $this->posicion->findByCajaAndAlmacen($caja->id, $almacen->id);
            }

            return view('ingresaCajaCreateEA', compact('caja', 'posicion', 'tipo'));
        } else {
            return view('ingresaCajaCreateEA', ['tipo' => $tipo]);
        }
    }

    public function registrarCaja(Request $request, $tipo)
    {
        $id = $request->input('box-id');

        if ($this->posicion->existePorCaja($id)) {
            return response()->json(['message' => 'La caja ya tiene una posición asignada'], 400);
        }

        $caja = $this->caja->findById($id);

        if (!$caja) {
            return response()->json(['message' => 'Caja no encontrada'], 404);
        }

        if (str_replace(' ', '', $caja->calidad) !== $tipo) {
            return response()->json(['message' => 'La caja no pertenece al almacén seleccionado'], 400);
        }

        $caja->registrarFechaIngreso();

        $posicion = $this->posicion->asignarNueva($caja, $tipo);

        return view('ingresaCajaCreateEA', [
            'caja' => $caja,
            'posicion' => $posicion,
            'tipo' => $tipo,
        ]);
    }
}

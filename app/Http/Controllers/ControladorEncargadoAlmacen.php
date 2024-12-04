<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Caja;
use App\Models\Posicion;
use App\Models\Almacen;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ControladorEncargadoAlmacen extends Controller
{
    protected $caja;
    protected $posicion;

    public function __construct(Caja $caja, Posicion $posicion)
    {
        $this->caja = $caja;
        $this->posicion = $posicion;
    }

    public function mostrarCaja(Request $request, $tipo)
    {
        $action = $request->input('action');

        if ($action == 'buscar') {

            $caja = null;

            if ($request->has('box-id') && $request->input('box-id') != '') {

                $id = $request->input('box-id');
                $caja = $this->caja->obtenerPorId($id);
                if (!$caja) {
                    return response()->json(['message' => 'Caja no encontrada'], 404);
                }
                if (str_replace(' ', '', $caja->calidad) !== $tipo) {
                    return redirect()->back()->with('error', 'La caja no pertenece al almacén seleccionado.');
                }
                $almacenId = Almacen::where(DB::raw("REPLACE(tipo, ' ', '')"), $tipo)->value('id');
                $posicion = Posicion::where('id_caja', $caja->id)
                    ->where('id_almacen', $almacenId)
                    ->first();
            }

            return view('ingresaCajaCreateEA', compact('caja', 'posicion', 'tipo'));
        } else {
            return view('ingresaCajaCreateEA', ['tipo' => $tipo]);
        }
    }

    public function registrarCaja(Request $request, $tipo)
    {
        $id = $request->input('box-id');

        if ($this->posicion->posicionExiste($id)) {
            return response()->json(['message' => 'La caja ya tiene una posición asignada'], 400);
        }

        $caja = $this->caja->obtenerPorId($id);
        if (!$caja) {
            return response()->json(['message' => 'Caja no encontrada'], 404);
        }

        if (str_replace(' ', '', $caja->calidad) !== $tipo) {
            return response()->json(['message' => 'La caja no pertenece al almacén seleccionado'], 400);
        }

        $caja->fecha_ingreso_almacen = Carbon::now();

        $posicion = $this->posicion->asignarPosicion($caja);

        $caja->save();


        return view('ingresaCajaCreateEA', [
            'caja' => $caja,
            'posicion' => $posicion,
            'tipo' => $tipo
        ]);
    }
}

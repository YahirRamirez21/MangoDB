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
                $caja = $this->caja->buscarCajaID($id);

                if (!$caja) {
                    return redirect()->back()->with('error', 'La caja no existe.');
                }

                if (str_replace(' ', '', $caja->calidad) !== $tipo) {
                    return redirect('/ingresoCajasAlmacen/{$tipo}')->with('error', 'La caja no pertenece al almacén seleccionado.')->with('tipo', $tipo);
                }

                $almacen = $this->almacen->buscarAlmacenTipo($tipo);
                $posicion = $this->posicion->buscarPosicionCajaAlmacen($caja->id, $almacen->id);
            }

            return view('ingresaCajaCreateEA', compact('caja', 'posicion', 'tipo'));
        } else {
            return view('ingresaCajaCreateEA', ['tipo' => $tipo]);
        }
    }

    public function registrarCaja(Request $request, $tipo)
    {
        $id = $request->input('box-id');

        if ($this->posicion->existeCaja($id)) {
            return redirect()->back()->with('error', 'La caja ya tiene posicion asignada.');
        }

        $caja = $this->caja->buscarCajaID($id);

        if (!$caja) {
            return redirect()->back()->with('error', 'La caja no existe.');
        }

        if (str_replace(' ', '', $caja->calidad) !== $tipo) {
            return redirect('/ingresoCajasAlmacen/{$tipo}')->with('error', 'La caja no pertenece al almacén seleccionado.');
        }

        $caja->registrarFechaIngreso();

        $posicion = $this->posicion->asignarNuevaPosicion($caja, $tipo);

        return view('ingresaCajaCreateEA', [
            'caja' => $caja,
            'posicion' => $posicion,
            'tipo' => $tipo,
        ]);
    }

    public function eleccionAlmacen(Request $request, $tipo){
        $almacen = $this->almacen->buscarAlmacenTipo($tipo);
        return view('infoAlmacenEA', compact('tipo','almacen'));
    }

}

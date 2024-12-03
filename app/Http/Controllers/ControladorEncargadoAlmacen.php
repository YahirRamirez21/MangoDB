<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Caja;
use App\Models\Posicion;
use Carbon\Carbon;

class ControladorEncargadoAlmacen extends Controller
{
    public function mostrarCaja(Request $request, $tipo)
    {
        $action = $request->input('action');

        if ($action == 'buscar') {
            // Inicializamos la variable $caja como null
            $caja = null;
            // Verifica si se ha enviado un ID en la solicitud GET
            if ($request->has('box-id') && $request->input('box-id') != '') {
                // Si el usuario ha ingresado un ID, busca la caja
                $id = $request->input('box-id');
                $caja = Caja::obtenerPorId($id);

                // Si no se encuentra la caja, se puede devolver un mensaje de error
                if (!$caja) {
                    return response()->json(['message' => 'Caja no encontrada'], 404);
                }

                // Valida que la caja pertenezca al almacén seleccionado
                if (str_replace(' ','', $caja->calidad) !== $tipo) {
                    return response()->json(['message' => 'La caja no pertenece al almacén seleccionado'], 400);
                }
            }

            // Pasa la variable 'caja' (puede ser null o una caja encontrada) a la vista
            return view('ingresaCajaCreateEA', compact('caja', 'tipo'));
        } elseif ($action == 'registrar') {
            // Verificar si el 'box-id' está presente en el formulario
            $id = $request->input('box-id'); // Obtener el ID de la caja


            // Verificar si ya existe una posición asignada para esta caja
            if (Posicion::posicionExiste($id)) {
                // Si ya existe una posición, devolver un error
                return response()->json(['message' => 'La caja ya tiene una posición asignada'], 400);
            }

            // Buscar la caja existente por ID
            $caja = Caja::obtenerPorId($id);

            if (!$caja) {
                // Si no se encuentra la caja, devolver un error
                return response()->json(['message' => 'Caja no encontrada'], 404);
            }

            // Valida que la caja pertenezca al almacén seleccionado
            if (str_replace(' ','', $caja->calidad) !== $tipo) {
                return response()->json(['message' => 'La caja no pertenece al almacén seleccionado'], 400);
            }

            // Actualizar los campos que faltan en la caja
            $caja->fecha_ingreso_almacen = Carbon::now(); // Fecha actual para ingreso a almacén

            // Si se quiere actualizar la posición de la caja, primero puedes obtener la posición o crear una nueva
            $posicion = Posicion::asignarPosicion($caja);

            // Guardar los cambios en la caja
            $caja->save();


            // Redirigir con un mensaje de éxito
            return view('ingresaCajaCreateEA', [
                'caja' => $caja,
                'posicion' => $posicion,
                'tipo' => $tipo
            ]);
        }else{
            return view('ingresaCajaCreateEA', ['tipo' => $tipo]);
        }
    }
}

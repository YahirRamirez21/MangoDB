<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Caja;

class ControladorEncargadoAlmacen extends Controller
{
    public function mostrarCaja(Request $request)
    {

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
       }

       // Pasa la variable 'caja' (puede ser null o una caja encontrada) a la vista
       return view('ingresaCajaCreateEA', compact('caja'));

    }

    
}

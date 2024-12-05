<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Caja;
use App\Models\Usuario;
use App\Models\Venta;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ControladorAPI extends Controller
{
    public function log(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = Usuario::where('nombre', $validated['nombre'])->first();

        if ($user && password_verify($validated['password'], $user->password)) {
            return response()->json([
                'message' => 'Login exitoso',
                'usuario' => $user,  
                
            ], 200);
        } else {
            return response()->json([
                'message' => 'Credenciales incorrectas',
            ], 401);
        }
    
    }
    public function retirar(Request $request)
    {
        $validated = $request->validate([
            'kilogramos' => 'required|numeric|min:0',
            'id_almacen' => 'required|exists:almacenes,id', 
        ]);
    
        $kilogramosARetirar = $validated['kilogramos'];
        $idAlmacen = $validated['id_almacen']; 
        Log::info('Kilogramos a retirar: ' . $kilogramosARetirar . ' del almacén ID: ' . $idAlmacen);
    
        DB::beginTransaction();
    
        try {
            // Filtrar cajas con bloqueo pesimista
            $cajas = DB::table('Cajas')
                ->join('Posiciones', 'Cajas.id', '=', 'Posiciones.id_caja')
                ->where('Posiciones.id_almacen', $idAlmacen)
                ->where('Cajas.Kilogramos', '>', 0)
                ->orderBy('Cajas.fecha_ingreso_almacen')
                ->select('Cajas.*')
                ->lockForUpdate() // Bloquea filas seleccionadas para evitar modificaciones concurrentes
                ->get();
    
            $kilogramosRestantes = $kilogramosARetirar;
            $cajasParaEliminar = []; 
    
            foreach ($cajas as $caja) {
                Log::info('Procesando caja ID: ' . $caja->id);
    
                if ($kilogramosRestantes <= 0) {
                    Log::info('Se han retirado todos los kilogramos requeridos.');
                    break;
                }
    
                if ($caja->kilogramos >= $kilogramosRestantes) {
                    Log::info('Caja tiene suficientes kilogramos. Retirando: ' . $kilogramosRestantes . ' kg.');
    
                    // Actualizar kilogramos de la caja
                    Caja::where('id', $caja->id)->update([
                        'kilogramos' => $caja->kilogramos - $kilogramosRestantes
                    ]);
    
                    if (($caja->kilogramos - $kilogramosRestantes) == 0) {
                        $cajasParaEliminar[] = $caja;
                        DB::table('Posiciones')->where('id_caja', $caja->id)->delete(); 
                        Log::info('Posición de la caja ID ' . $caja->id . ' eliminada.');
                    }
    
                    $kilogramosRestantes = 0;
                } else {
                    Log::info('Caja no tiene suficientes kilogramos, vaciando: ' . $caja->kilogramos . ' kg.');
    
                    $kilogramosRestantes -= $caja->kilogramos;
    
                    // Vaciar caja
                    Caja::where('id', $caja->id)->update(['kilogramos' => 0]);
    
                    // Eliminar posición asociada
                    DB::table('Posiciones')->where('id_caja', $caja->id)->delete();
                    Log::info('Posición de la caja ID ' . $caja->id . ' eliminada.');
    
                    $cajasParaEliminar[] = $caja;
                }
            }
    
            if ($kilogramosRestantes > 0) {
                DB::rollBack();
                Log::error('No se pudieron retirar todos los kilogramos solicitados. Restantes: ' . $kilogramosRestantes);
                return response()->json([
                    'message' => 'No hay suficientes kilogramos disponibles para retirar.',
                ], 400);
            }
    
            Log::info('Todos los kilogramos han sido retirados correctamente.');
    
            // Eliminar las cajas vacías
            foreach ($cajasParaEliminar as $caja) {
                Caja::where('id', $caja->id)->delete();
                Log::info('Caja ID ' . $caja->id . ' eliminada.');
            }
    
            // Registrar la venta
            $venta = new Venta();
            $venta->Fecha = now();
            $venta->kilogramos = $kilogramosARetirar;
            $venta->precio_total = $kilogramosARetirar * 100; 
            $venta->id_encargado_venta = 1;
            $venta->save();
    
            Log::info('Venta registrada con ID: ' . $venta->id);
    
            DB::commit();
    
            return response()->json([
                'message' => 'Kilogramos retirados exitosamente',
                'venta' => $venta,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al retirar kilogramos: ' . $e->getMessage());
    
            return response()->json([
                'message' => 'Error al procesar la solicitud',
                'error' => $e->getMessage(), 
            ], 500);
        }
    }
   


    }

    
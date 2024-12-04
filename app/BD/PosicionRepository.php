<?php

namespace App\Repositories;

use App\Models\Posicion;
use App\Models\Almacen;
use App\Models\Caja;
use Illuminate\Support\Facades\DB;

class PosicionRepository
{
    // Asignar una posición a una caja
    public function asignarPosicion(Caja $caja)
    {
        return DB::transaction(function () use ($caja) {
            $tipo = $caja->calidad;
            $almacen = Almacen::where('tipo', $tipo)->first();

            if (!$almacen->tieneEspacio()) {
                return $this->asignarPosicionPEPS($almacen, $caja);
            }

            $estante = 1;
            $division = 1;
            $subdivision = 1;

            // Asignación de posición
            while (!$almacen->verificarCapacidadPosicion($estante, $division, $subdivision)) {
                $subdivision++;
                if ($subdivision > 3) {
                    $subdivision = 1;
                    $division++;
                    if ($division > 3) {
                        $division = 1;
                        $estante++;
                        if ($estante > 3) {
                            throw new \Exception('No hay espacio suficiente en el almacén.');
                        }
                    }
                }
            }

            // Verificación final
            $posicionExistente = Posicion::where('id_almacen', $almacen->id)
                ->where('estante', $estante)
                ->where('division', $division)
                ->where('subdivision', $subdivision)
                ->lockForUpdate()
                ->first();

            if ($posicionExistente) {
                throw new \Exception('La posición ya fue asignada en otro proceso. Intente de nuevo.');
            }

            $posicion = new Posicion();
            $posicion->id_caja = $caja->id;
            $posicion->estante = $estante;
            $posicion->division = $division;
            $posicion->subdivision = $subdivision;
            $posicion->id_almacen = $almacen->id;
            $posicion->save();

            return $posicion;
        });
    }

    // Asignar posición usando el método PEPS
    public function asignarPosicionPEPS(Almacen $almacen, Caja $caja)
    {
        return DB::transaction(function () use ($almacen, $caja) {
            $cajasOrdenadas = Caja::where('id_almacen', $almacen->id)
                ->orderBy('fecha_ingreso_almacen', 'asc')
                ->get();

            $posicion = Posicion::where('id_caja', $cajasOrdenadas->first()->id)->first();
            $posicion->id_caja = $caja->id;
            $posicion->save();

            return $posicion;
        });
    }
}

<?php

namespace App\Repositories;

use App\Models\Posicion;
use App\Models\Almacen;
use App\Models\Caja;
use Illuminate\Support\Facades\DB;

class PosicionRepository
{
    public function findByCajaAndAlmacen($cajaId, $almacenId)
    {
        return Posicion::where('id_caja', $cajaId)
            ->where('id_almacen', $almacenId)
            ->first();
    }

    public function asignarNueva(Caja $caja, $tipo)
    {
        return DB::transaction(function () use ($caja, $tipo) {
            $almacen = Almacen::where('tipo', $tipo)->firstOrFail();

            if (!$almacen->tieneEspacio()) {
                return $this->reasignarPorPEPS($almacen, $caja);
            }

            return $this->crearPosicionDisponible($almacen, $caja);
        });
    }

    public function buscarPosicionExistente(Almacen $almacen, $estante, $division, $subidivision) {
        return Posicion::where('id_almacen', $almacen->id)
        ->where('estante', $estante)
        ->where('division', $division)
        ->where('subdivision', $subdivision)
        ->lockForUpdate()
        ->first();
    }

    public function crearObjetoPosicion(Caja $caja, $estante, $division, $subdivision, Almacen $almacen ){
        $posicion = new Posicion();
        $posicion->id_caja = $caja->id;
        $posicion->estante = $estante;
        $posicion->division = $division;
        $posicion->subdivision = $subdivision;
        $posicion->id_almacen = $almacen->id;
        $posicion->save();

        return $posicion;
    }

    public function reasignarPorPEPS(Almacen $almacen, Caja $caja)
    {
        return DB::transaction(function () use ($almacen, $caja) {
            $repositorioCaja = new Caja();
            $cajasOrdenadas = Caja::where('id_almacen', $almacen->id)
                ->orderBy('fecha_ingreso_almacen', 'asc')
                ->get();

            $posicion = Posicion::where('id_caja', $cajasOrdenadas->first()->id)->first();
            $posicion->id_caja = $caja->id;
            $posicion->save();

            return $posicion;
        });
    }

    public function existeCaja(){
        return Posicion::where('id_caja', $cajaId)->exists();
    }
}

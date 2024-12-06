<?php

namespace App\BD;

use App\Models\Posicion;
use App\Models\Almacen;
use App\Models\Caja;
use Illuminate\Support\Facades\DB;

class PosicionRepository
{
    protected $posicion;

    public function __construct(Posicion $posicion)
    {
        $this->posicion = $posicion;
    }

    public function buscarPosicionCajaAlmacen($cajaId, $almacenId)
    {
        return $this->posicion->where('id_caja', $cajaId)
            ->where('id_almacen', $almacenId)
            ->first();
    }

    public function asignarNuevaPosicion(Caja $caja, $tipo)
    {
        return DB::transaction(function () use ($caja, $tipo) {
            $respositorioAlmacen = new Almacen();
            $almacen = $respositorioAlmacen->whereRaw('REPLACE(tipo, " ", "") = ?', [$tipo])->firstOrFail();

            return $this->posicion->crearPosicionDisponible($almacen, $caja);
        });
    }

    public function buscarPosicionExistente(Almacen $almacen, $estante, $division, $subdivision) {
        return $this->posicion->where('id_almacen', $almacen->id)
        ->where('estante', $estante)
        ->where('division', $division)
        ->where('subdivision', $subdivision)
        ->lockForUpdate()
        ->first();
    }

    public function crearObjetoPosicion(Almacen $almacen, Caja $caja, $estante, $division, $subdivision)
    {
        return DB::transaction(function () use ($almacen, $caja, $estante, $division, $subdivision) {
            $posicion = new Posicion();
            $posicion->id_caja = $caja->id;
            $posicion->estante = $estante;
            $posicion->division = $division;
            $posicion->subdivision = $subdivision;
            $posicion->id_almacen = $almacen->id;

            $posicion->lockForUpdate();
    
            $posicion->save();
    
            return $posicion;
        });
    }

    public function existeCaja($cajaId){
        return $this->posicion->where('id_caja', $cajaId)->exists();
    }
}

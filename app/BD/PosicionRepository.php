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

    public function buscarPrimeraPosicionVaciaOrdenada(Almacen $almacen)
    {
        return $this->posicion->where('id_almacen', $almacen->id)
            ->whereNull('id_caja')
            ->orderBy('estante')
            ->orderBy('division')
            ->orderBy('subdivision')
            ->lockForUpdate()
            ->first();
    }

    public function crearObjetoPosicion($posicion, $idCaja)
    {
        
        if ($posicion) {
            
            DB::table('posiciones')
                ->where('id_almacen', $posicion->id_almacen)
                ->where('estante', $posicion->estante)
                ->where('division', $posicion->division)
                ->where('subdivision', $posicion->subdivision)
                ->update(['id_caja' => $idCaja]);

        
            $posicion->id_caja = $idCaja;
        }
    }

    public function existeCaja($cajaId)
    {
        return $this->posicion->where('id_caja', $cajaId)->exists();
    }
}

<?php

namespace App\BD;

use App\Models\Almacen;

class AlmacenRepository
{
    protected $almacen;

    public function __construct(Almacen $almacen)
    {
        $this->almacen = $almacen;
    }

    public function findByTipo($tipo)
    {
        return $this->almacen->whereRaw('REPLACE(tipo, " ", "") = ?', [$tipo])->first();
    }

    public function verificarCapacidadPosicion($almacen, $estante, $division, $subdivision)
    {
        return !$almacen->posiciones()
            ->where('estante', $estante)
            ->where('division', $division)
            ->where('subdivision', $subdivision)
            ->exists();
    }

    public function tieneEspacio($almacen)
    {
        return $almacen->posiciones()->count() < $almacen->capacidad;
    }
}

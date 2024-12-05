<?php
namespace App\BD;

use App\Models\Caja;

class CajaRepository
{
    protected $caja;

    public function __construct(Caja $caja)
    {
        $this->caja = $caja;
    }
    // Obtener una caja por su ID con sus posiciones
    public function obtenerPorId($id)
    {
        return Caja::with('posiciones')->find($id);
    }

    // Registrar una caja
    public function registrarCaja(Caja $caja)
    {
        $caja->fecha_ingreso_almacen = now();
        return $caja->save();
    }
}

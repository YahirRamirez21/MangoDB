<?php
namespace App\Repositories;

use App\Models\Caja;

class CajaRepository
{
    // Obtener una caja por su ID con sus posiciones
    public function obtenerPorId($id)
    {
        return Caja::with('posiciones')->find($id);
    }

    // Registrar una caja
    public function registrarCaja(Caja $caja)
    {
        return $caja->save();
    }
}

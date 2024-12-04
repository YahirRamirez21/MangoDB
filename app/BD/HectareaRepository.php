<?php

namespace App\Repositories;

use App\Models\Hectarea;

class HectareaRepository
{
    // Obtener hectáreas por el ID de usuario
    public function getByUserId($userId)
    {
        return Hectarea::where('id_jefe_cuadrilla', $userId)->get();
    }

    // Cambiar el estado de una hectárea
    public function cambiarEstado(Hectarea $hectarea)
    {
        $hectarea->fecha_recoleccion = now();
        $hectarea->save();
    }

    // Filtrar hectáreas por tipo (autorizada/no autorizada)
    public function filtrarPorTipo($tipo, $userId)
    {
        $query = Hectarea::where('id_jefe_cuadrilla', $userId);

        if ($tipo) {
            if ($tipo == 'autorizada') {
                $query->whereNotNull('fecha_recoleccion');
            } elseif ($tipo == 'no_autorizada') {
                $query->whereNull('fecha_recoleccion');
            }
        }

        return $query->get();
    }
}

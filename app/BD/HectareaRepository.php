<?php

namespace App\BD;

use App\Models\Hectarea;

class HectareaRepository
{
    protected $hectarea;

    public function __construct(Hectarea $hectarea)
    {
        $this->hectarea = $hectarea;
    }

    public function getByUserId($userId)
    {
        return $this->hectarea->where('id_jefe_cuadrilla', $userId)->get();
    }

    public function obtenerHectarea($id)
    {
        return $this->hectarea->find($id);
    }

    public function filtrarPorTipo($tipo, $userId)
    {
        $query = $this->hectarea->where('id_jefe_cuadrilla', $userId);

        if ($tipo) {
            if ($tipo === 'autorizada') {
                $query->whereNotNull('fecha_recoleccion');
            } elseif ($tipo === 'no_autorizada') {
                $query->whereNull('fecha_recoleccion');
            }
        }

        return $query->get();
    }

    public function obtenerHectareaDeUsuario($id, $userId)
    {
        return $this->hectarea->where('id', $id)->where('id_jefe_cuadrilla', $userId)->first();
    }

    public function cambiarEstado($hectarea)
    {
        $hectarea->fecha_recoleccion = now();
        $hectarea->save();
    }
}

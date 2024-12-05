<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Almacen extends Model
{
    protected $table = 'almacenes';

    public function posiciones()
    {
        return $this->hasMany(Posicion::class, 'id_almacen');
    }

    public function tieneEspacio()
    {
        return $this->posiciones()->count() < $this->capacidad;
    }

    public function findByTipo($tipo)
    {
        return $this->where('tipo', $tipo)->first();
    }

    public function verificarCapacidadPosicion($estante, $division, $subdivision)
{
    // Comprobar si existe una posición ocupada en el almacén con los mismos parámetros
    return !$this->posiciones()
        ->where('estante', $estante)
        ->where('division', $division)
        ->where('subdivision', $subdivision)
        ->exists();
}
}

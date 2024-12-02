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
        $totalEstantes = $this->posiciones()->count(); // Total de posiciones ocupadas
        return $totalEstantes < $this->capacidad; // Verifica si hay espacio para más cajas
    }

    public function verificarCapacidadPosicion($estante, $division, $subdivision)
    {
        return !Posicion::where('id_almacen', $this->id)
            ->where('estante', $estante)
            ->where('division', $division)
            ->where('subdivision', $subdivision)
            ->exists(); // Verifica si ya existe una posición con la misma configuración
    }
}

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
        $totalEstantes = $this->posiciones()->count();
        return $totalEstantes < $this->capacidad;
    }

    public function verificarCapacidadPosicion($estante, $division, $subdivision)
    {
        return !Posicion::where('id_almacen', $this->id)
            ->where('estante', $estante)
            ->where('division', $division)
            ->where('subdivision', $subdivision)
            ->lockForUpdate()
            ->exists();
    }
}

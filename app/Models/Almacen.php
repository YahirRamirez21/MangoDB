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
}

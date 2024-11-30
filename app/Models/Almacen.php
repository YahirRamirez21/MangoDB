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
}

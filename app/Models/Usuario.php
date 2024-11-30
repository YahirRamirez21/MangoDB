<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{

    protected $table = 'usuarios';

    public function hectareas()
    {
        return $this->hasMany(Hectarea::class, 'id_jefe_cuadrilla');
    }

    public function ventas()
    {
        return $this->hasMany(Venta::class, 'id_encargado_venta');
    }
}

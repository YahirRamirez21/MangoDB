<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hectarea extends Model
{

    protected $table = 'hectareas';

    public function jefeCuadrilla()
    {
        return $this->belongsTo(Usuario::class, 'id_jefe_cuadrilla');
    }

    public function plantas()
    {
        return $this->hasMany(Planta::class, 'id_hectarea');
    }

    public function cajas()
    {
        return $this->hasMany(Caja::class, 'id_hectarea');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{

    protected $table = 'cajas';

    public function hectarea()
    {
        return $this->belongsTo(Hectarea::class, 'id_hectarea');
    }

    public function posiciones()
    {
        return $this->hasMany(Posicion::class, 'id_caja');
    }

    public function cajasVentas()
    {
        return $this->hasMany(CajaVenta::class, 'id_caja');
    }
}

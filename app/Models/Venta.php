<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{

    protected $table = 'ventas';

    public function encargadoVenta()
    {
        return $this->belongsTo(Usuario::class, 'id_encargado_venta');
    }

    public function cajasVentas()
    {
        return $this->hasMany(CajaVenta::class, 'id_venta');
    }
}

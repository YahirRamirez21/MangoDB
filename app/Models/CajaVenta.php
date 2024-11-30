<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CajaVenta extends Model
{

    protected $table = 'cajas_ventas';

    public function caja()
    {
        return $this->belongsTo(Caja::class, 'id_caja');
    }

    public function venta()
    {
        return $this->belongsTo(Venta::class, 'id_venta');
    }
}

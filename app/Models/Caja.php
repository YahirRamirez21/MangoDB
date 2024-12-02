<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{

    protected $table = 'cajas';

    public $timestamps = false;

    protected $fillable = [
        'hectarea_id',
        'fecha_recoleccion',
    ];


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

    public static function obtenerPorId($id)
    {
        return self::with('posiciones')->find($id);
    }

    
}

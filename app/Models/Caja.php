<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    protected $table = 'cajas';

    public $timestamps = false;

    protected $fillable = [
        'id_hectarea',
        'calidad',
        'kilogramos',
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

    public function findById($id)
    {
        return $this->with('posiciones')->find($id);
    }

    public function registrarFechaIngreso()
    {
        $this->fecha_ingreso_almacen = now();
        $this->save();
    }
}

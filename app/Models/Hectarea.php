<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Hectarea extends Model
{
    protected $table = 'hectareas';
    protected $fillable = ['estado', 'id_jefe_cuadrilla', 'renta', 'porcentaje_general'];
    public $timestamps = false;

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

    // Métodos no estáticos

    public function getByUserId($userId)
    {
        return $this->where('id_jefe_cuadrilla', $userId)->get();
    }

    public function obtenerHectarea($id)
    {
        return $this->find($id);
    }

    public function cambiarEstado()
    {
        $this->fecha_recoleccion = Carbon::now();
        $this->save();
    }

    public function obtenerHectareaDeUsuario($id, $userId)
    {
        return $this->where('id', $id)->where('id_jefe_cuadrilla', $userId)->first();
    }

    public function filtrarPorTipo($tipo, $userId)
    {
        $query = $this->where('id_jefe_cuadrilla', $userId);

        if ($tipo) {
            if ($tipo == 'autorizada') {
                $query->whereNotNull('fecha_recoleccion');
            } elseif ($tipo == 'no_autorizada') {
                $query->whereNull('fecha_recoleccion');
            }
        }

        return $query->get();
    }
}

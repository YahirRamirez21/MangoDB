<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Hectarea extends Model
{

    protected $table = 'hectareas';

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

    public static function getByUserId($userId)
    {
        return self::where('id_jefe_cuadrilla', $userId)->get();
    }

    public static function obtenerHectarea($id) {
        return self::find($id);
    }

    public static function cambiarEstado($hectarea) {
        $hectarea->fecha_recoleccion = Carbon::now();
        $hectarea->save();
    }

    public static function obtenerHectareaDeUsuario($id, $userId)
    {
        // Obtiene la hectárea asegurando que pertenece al usuario autenticado.
        return self::where('id', $id)->where('id_jefe_cuadrilla', $userId)->first();
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Cache;

class Usuario extends Authenticatable
{

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'password',
        'rol',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function hectareas()
    {
        return $this->hasMany(Hectarea::class, 'id_jefe_cuadrilla');
    }

    public function ventas()
    {
        return $this->hasMany(Venta::class, 'id_encargado_venta');
    }

    /**
     * Verifica si el usuario está logueado en otra sesión con bloqueo.
     *
     * @return bool
     */
    public static function estaLogueadoEnOtraSesion($nombre)
    {
        $lockKey = 'usuario_logueado:' . $nombre;
        $lock = Cache::lock($lockKey, 10); 

        if ($lock->get()) {
            $isLoggedIn = Cache::has($lockKey);
            $lock->release();

            return $isLoggedIn;
        }

        return false;
    }

    public static function marcarComoLogueado($nombre)
    {
        $lockKey = 'usuario_logueado:' . $nombre;
        $lock = Cache::lock($lockKey, 10);

        if ($lock->get()) {
            Cache::put($lockKey, true, now()->addMinutes(30));
            $lock->release(); 
        }
    }

    public static function eliminarSesion($nombre)
    {
        $lockKey = 'usuario_logueado:' . $nombre;
        $lock = Cache::lock($lockKey, 10); 

        if ($lock->get()) {
            Cache::forget($lockKey);
            $lock->release(); 
        }
    }

}

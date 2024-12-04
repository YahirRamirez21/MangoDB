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
        // Usamos un bloqueo para prevenir la concurrencia
        $lockKey = 'usuario_logueado:' . $nombre;
        $lock = Cache::lock($lockKey, 10); // Tiempo de espera para adquirir el bloqueo (10 segundos)

        // Intentamos adquirir el bloqueo, si no podemos, es porque otro proceso lo tiene
        if ($lock->get()) {
            $isLoggedIn = Cache::has($lockKey);
            $lock->release();  // Liberamos el bloqueo

            return $isLoggedIn;
        }

        return false;
    }

    /**
     * Marca al usuario como logueado, usando caché.
     */
    public static function marcarComoLogueado($nombre)
    {
        $lockKey = 'usuario_logueado:' . $nombre;
        $lock = Cache::lock($lockKey, 10); // Tiempo de espera para adquirir el bloqueo (10 segundos)

        // Intentamos adquirir el bloqueo, si no podemos, es porque otro proceso lo tiene
        if ($lock->get()) {
            Cache::put($lockKey, true, now()->addMinutes(30));
            $lock->release(); // Liberamos el bloqueo
        }
    }

    /**
     * Elimina el estado de sesión del usuario en la caché.
     */
    public static function eliminarSesion($nombre)
    {
        $lockKey = 'usuario_logueado:' . $nombre;
        $lock = Cache::lock($lockKey, 10); // Tiempo de espera para adquirir el bloqueo (10 segundos)

        // Intentamos adquirir el bloqueo, si no podemos, es porque otro proceso lo tiene
        if ($lock->get()) {
            Cache::forget($lockKey);
            $lock->release(); // Liberamos el bloqueo
        }
    }

}

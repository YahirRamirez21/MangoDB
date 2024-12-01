<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

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

}

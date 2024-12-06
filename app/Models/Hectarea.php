<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\BD\HectareaRepository;

class Hectarea extends Model
{
    protected $table = 'hectareas';
    protected $fillable = ['estado', 'id_jefe_cuadrilla', 'renta', 'porcentaje_general'];
    public $timestamps = false;

    protected $repository;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->repository = new HectareaRepository($this);
    }

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

    public function obtenerUsuarioID($userId)
    {
        return $this->repository->obtenerUsuarioID($userId);
    }

    public function obtenerHectarea($id)
    {
        return $this->repository->obtenerHectarea($id);
    }

    public function cambiarEstado()
    {
        $this->repository->cambiarEstado($this);
    }

    public function obtenerHectareaDeUsuario($id, $userId)
    {
        return $this->repository->obtenerHectareaDeUsuario($id, $userId);
    }

    public function filtrarPorTipo($tipo, $userId)
    {
        return $this->repository->filtrarPorTipo($tipo, $userId);
    }
}

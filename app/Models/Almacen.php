<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\BD\AlmacenRepository;

class Almacen extends Model
{
    protected $table = 'almacenes';

    protected $repository;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->repository = new AlmacenRepository($this);
    }

    public function posiciones()
    {
        return $this->hasMany(Posicion::class, 'id_almacen');
    }

    public function tieneEspacio()
    {
        return $this->repository->tieneEspacio($this);
    }

    public function findByTipo($tipo)
    {
        return $this->repository->findByTipo($tipo);
    }

    public function verificarCapacidadPosicion($estante, $division, $subdivision)
    {
        return $this->repository->verificarCapacidadPosicion($this, $estante, $division, $subdivision);
    }
}

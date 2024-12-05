<?php

namespace App\Models;

use App\BD\CajaRepository;
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
    protected $repository;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->repository = new CajaRepository($this);
    }

    public function hectarea()
    {
        return $this->belongsTo(Hectarea::class, 'id_hectarea');
    }

    public function posiciones()
    {
        return $this->hasMany(Posicion::class, 'id_caja');
    }

    public function registrarCaja()
    {
        $this->save();
        return $this;
    }

    public function findById($id)
    {
        return $this->repository->obtenerPorId($id);
    }

    public function registrarFechaIngreso()
    {
        return $this->repository->registrarCaja($this);
    }
}

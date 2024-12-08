<?php

namespace App\Models;

use App\BD\PosicionRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Caja;
use App\Models\Almacen;

class Posicion extends Model
{
    protected $table = 'posiciones';

    public $timestamps = false;

    protected $fillable = [
        'id_caja',
        'id_almacen',
        'estante',
        'division',
        'subdivision',
    ];

    protected $repository;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->repository = new PosicionRepository($this);
    }
    // Definir la clave primaria compuesta
    public function getKeyName()
    {
        return null; 
    }

    public function getQualifiedKeyName()
    {
        return ['id_almacen', 'estante', 'division', 'subdivision'];
    }

    public function _contruct() {}

    public function caja()
    {
        return $this->belongsTo(Caja::class, 'id_caja');
    }

    public function almacen()
    {
        return $this->belongsTo(Almacen::class, 'id_almacen');
    }

    public function buscarPosicionCajaAlmacen($cajaId, $almacenId)
    {
        return $this->repository->buscarPosicionCajaAlmacen($cajaId, $almacenId);
    }

    public function asignarNuevaPosicion(Caja $caja, $tipo)
    {
        return $this->repository->asignarNuevaPosicion($caja, $tipo);
    }

    public function crearPosicionDisponible(Almacen $almacen, Caja $caja)
    {

        $posicion = $this->repository->buscarPrimeraPosicionVaciaOrdenada($almacen);

        if ($posicion) {

            $this->repository->crearObjetoPosicion($posicion, $caja->id);
            
            return $posicion;
        }
        return null;
    }

    public function existeCaja($cajaId)
    {
        return $this->repository->existeCaja($cajaId);
    }
}

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


        $posicionUltimaCaja = $this->repository->buscarPrimeraPosicionVaciaOrdenada($almacen);
        print_r($posicionUltimaCaja);
        if ($posicionUltimaCaja) {
            // Crear la siguiente posición
            // Intentamos incrementar la subdivisión primero
            $nuevaPosicion = Posicion::where('id_almacen', $posicionUltimaCaja->id_almacen)
                ->where('estante', $posicionUltimaCaja->estante)
                ->where('division', $posicionUltimaCaja->division)
                ->where('subdivision', $posicionUltimaCaja->subdivision + 1) // Incrementamos la subdivisión
                ->first();

            // Si no encontramos una posición disponible con la suma de 1 a la subdivisión, intentamos incrementar la división
            if (!$nuevaPosicion) {
                $nuevaPosicion = Posicion::where('id_almacen', $almacen->id)
                    ->where('estante', $posicionUltimaCaja->estante)
                    ->where('division', $posicionUltimaCaja->division + 1) // Incrementamos la división
                    ->where('subdivision', 1) // Empezamos de nuevo en la primera subdivisión
                    ->first();
            }

            // Si no encontramos una posición disponible con la suma de 1 a la división, intentamos incrementar el estante
            if (!$nuevaPosicion) {
                $nuevaPosicion = Posicion::where('id_almacen', $almacen->id)
                    ->where('estante', $posicionUltimaCaja->estante + 1) // Incrementamos el estante
                    ->where('division', 1) // Empezamos de nuevo en la primera división
                    ->where('subdivision', 1) // Empezamos de nuevo en la primera subdivisión
                    ->first();
            }

            $this->repository->crearObjetoPosicion($nuevaPosicion, $caja->id);

            return $nuevaPosicion;
        }else{

            $posicionUno = new Posicion();
            $posicionUno->estante = 1;
            $posicionUno->subdivision = 1;
            $posicionUno->division = 1;
            $posicionUno->id_almacen = $almacen->id;
            //dd($posicionUno);
            //var_dump($posicionUno);
            print_r($posicionUno);
            $this->repository->crearObjetoPosicion($posicionUno, $caja->id);
        }

        return null;
    }

    public function existeCaja($cajaId)
    {
        return $this->repository->existeCaja($cajaId);
    }
}

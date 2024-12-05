<?php

namespace App\Models;

use App\BD\PosicionRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Caja;

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
    private $repositorio;

    public function __construct(PosicionRepository $repositorio)
    {
        $this->repositorio = $repositorio;
    }

    public function caja()
    {
        return $this->belongsTo(Caja::class, 'id_caja');
    }

    public function almacen()
    {
        return $this->belongsTo(Almacen::class, 'id_almacen');
    }

    public function findByCajaAndAlmacen($cajaId, $almacenId)
    {
        return $repositorio->findByCajaAndAlmacen($cajaId, $almacenId);
    }

    public function asignarNueva(Caja $caja, $tipo)
    {
        return $repositorio->asignarNueva($caja, $tipo);
    }

    private function crearPosicionDisponible(Almacen $almacen, Caja $caja)
    {
        $estante = 1;
        $division = 1;
        $subdivision = 1;

        while (!$almacen->verificarCapacidadPosicion($estante, $division, $subdivision)) {
            $subdivision++;
            if ($subdivision > 3) {
                $subdivision = 1;
                $division++;
                if ($division > 3) {
                    $division = 1;
                    $estante++;
                    if ($estante > 3) {
                        throw new \Exception('No hay espacio suficiente en el almacén.');
                    }
                }
            }
        }

        $posicionExistente =  $repositorio->buscarPosicionExistente($almacen, $estante, $division, $subdivision);

        if ($posicionExistente) {
            throw new \Exception('La posición ya fue asignada en otro proceso. Intente de nuevo.');
        }

        $posicion =  $repositorio->crearObjetoPosicion($caja, $estante, $division, $subdivision, $almacen);
        return $posicion;
    }

    private function reasignarPorPEPS(Almacen $almacen, Caja $caja)
    {
        return $repositorio->reasignarPorPEPS($almacen, $caja);
    }

    private function existePorCaja($cajaId)
    {
        return $repositorio->existeCaja($cajaId);
    }
}

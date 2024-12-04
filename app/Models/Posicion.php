<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
        return $this->where('id_caja', $cajaId)
            ->where('id_almacen', $almacenId)
            ->first();
    }

    
    public function asignarNueva(Caja $caja, $tipo)
    {
        return DB::transaction(function () use ($caja, $tipo) {
            $almacen = Almacen::where('tipo', $tipo)->firstOrFail();

            if (!$almacen->tieneEspacio()) {
                return $this->reasignarPorPEPS($almacen, $caja);
            }

            return $this->crearPosicionDisponible($almacen, $caja);
        });
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

        $posicionExistente = $this->where('id_almacen', $almacen->id)
            ->where('estante', $estante)
            ->where('division', $division)
            ->where('subdivision', $subdivision)
            ->lockForUpdate()
            ->first();

        if ($posicionExistente) {
            throw new \Exception('La posición ya fue asignada en otro proceso. Intente de nuevo.');
        }

        $posicion = new Posicion();
        $posicion->id_caja = $caja->id;
        $posicion->estante = $estante;
        $posicion->division = $division;
        $posicion->subdivision = $subdivision;
        $posicion->id_almacen = $almacen->id;
        $posicion->save();

        return $posicion;
    }

    private function reasignarPorPEPS(Almacen $almacen, Caja $caja)
    {
        return DB::transaction(function () use ($almacen, $caja) {
            $cajasOrdenadas = Caja::where('id_almacen', $almacen->id)
                ->orderBy('fecha_ingreso_almacen', 'asc')
                ->get();

            $posicion = $this->where('id_caja', $cajasOrdenadas->first()->id)->first();
            $posicion->id_caja = $caja->id;
            $posicion->save();

            return $posicion;
        });
    }

    public function existePorCaja($cajaId)
    {
        return $this->where('id_caja', $cajaId)->exists();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Posicion extends Model
{
    protected $table = 'posiciones';

    public $timestamps = false;

    public function caja()
    {
        return $this->belongsTo(Caja::class, 'id_caja');
    }

    public function almacen()
    {
        return $this->belongsTo(Almacen::class, 'id_almacen');
    }

    public static function asignarPosicion(Caja $caja)
    {
        return DB::transaction(function () use ($caja) {
            $tipo = $caja->calidad;
            $almacen = Almacen::where('tipo', $tipo)->first();

            if (!$almacen->tieneEspacio()) {//que no revase la capacidad del almacen
                return self::asignarPosicionPEPS($almacen, $caja);
            }

            $estante = 1;
            $division = 1;
            $subdivision = 1;

            // Bloqueo explícito para garantizar que la posición no sea asignada por otro usuario
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

            // Verificación final en caso de alta concurrencia
            $posicionExistente = self::where('id_almacen', $almacen->id)
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
        });
    }

    public static function asignarPosicionPEPS(Almacen $almacen, Caja $caja)
    {
        return DB::transaction(function () use ($almacen, $caja) {
            $cajasOrdenadas = Caja::where('id_almacen', $almacen->id)
                ->orderBy('fecha_ingreso_almacen', 'asc')
                ->get();

            $posicion = self::where('id_caja', $cajasOrdenadas->first()->id)->first();
            $posicion->id_caja = $caja->id;
            $posicion->save();

            return $posicion;
        });
    }

    public static function posicionExiste($idCaja)
    {
        return self::where('id_caja', $idCaja)->exists();
    }

}

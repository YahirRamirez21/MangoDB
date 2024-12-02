<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Posicion extends Model
{
    protected $table = 'posiciones';

    // Deshabilitar los timestamps
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
        $tipo = $caja->calidad;
        $almacen = Almacen::where('tipo', $tipo)->first();
        

        // Verificar si el almacén tiene capacidad
        if (!$almacen->tieneEspacio()) {
            // Si no hay espacio, aplicamos el PEPS (Primero en entrar, Primero en salir)
            return self::asignarPosicionPEPS($almacen, $caja);
        }

        // Buscar una posición vacía respetando los límites
        $estante = 1;
        $division = 1;
        $subdivision = 1;

        while (!$almacen->verificarCapacidadPosicion($estante, $division, $subdivision)) {
            // Si ya existe una posición con esas coordenadas, probamos otra combinación
            $subdivision++;
            if ($subdivision > 3) { // Máximo de 3 subdivisiones
                $subdivision = 1;
                $division++;
                if ($division > 3) { // Máximo de 3 divisiones
                    $division = 1;
                    $estante++;
                    if ($estante > 1) { // Máximo de 3 estantes
                        throw new \Exception('No hay espacio suficiente en el almacén.');
                    }
                }
            }
        }

        // Si encontramos una posición válida, la asignamos a la caja
        $posicion = new Posicion();
        $posicion->id_caja = $caja->id;
        $posicion->estante = $estante;
        $posicion->division = $division;
        $posicion->subdivision = $subdivision;
        $posicion->id_almacen = $almacen->id;
        $posicion->save();

        return $posicion;
    }

    /**
     * Asignar posición utilizando PEPS (Primero en entrar, Primero en salir).
     */
    public static function asignarPosicionPEPS(Almacen $almacen, Caja $caja)
    {
        // Buscar las cajas más antiguas en el almacén
        $cajasOrdenadas = Caja::where('id_almacen', $almacen->id)
                            ->orderBy('fecha_ingreso_almacen', 'asc') // Ordenar por fecha
                            ->get();

        // Aquí podemos aplicar PEPS para asignar posiciones, por ejemplo, buscar la primera posición disponible
        // o hacer que se asignen posiciones vacías de las cajas más antiguas
        $posicion = self::where('id_caja', $cajasOrdenadas->first()->id)->first();
        $posicion->id_caja = $caja->id;
        $posicion->save();
        
        return $posicion;
    }

    public static function posicionExiste($idCaja)
    {
        return self::where('id_caja', $idCaja)->exists();  // Verifica si existe una posición para esa caja
    }
    
}

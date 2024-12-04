<?php
namespace App\Repositories;

use App\Models\Almacen;
use Illuminate\Support\Facades\DB;

class AlmacenRepository
{
    // Verifica si el almacén tiene espacio
    public function tieneEspacio(Almacen $almacen)
    {
        $totalEstantes = $almacen->posiciones()->count(); 
        return $totalEstantes < $almacen->capacidad; 
    }

    // Verifica la capacidad de una posición
    public function verificarCapacidadPosicion(Almacen $almacen, $estante, $division, $subdivision)
    {
        return !DB::table('posiciones')
            ->where('id_almacen', $almacen->id)
            ->where('estante', $estante)
            ->where('division', $division)
            ->where('subdivision', $subdivision)
            ->exists(); 
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Planta extends Model
{

    protected $table = 'plantas';

    public function hectarea()
    {
        return $this->belongsTo(Hectarea::class, 'id_hectarea');
    }
}

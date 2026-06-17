<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class MovimientoEtiqueta extends Pivot
{
    protected $table = 'movimiento_etiqueta';

    public $timestamps = false;

    protected $fillable = [
        'movimiento_id',
        'etiqueta_id',
    ];
}

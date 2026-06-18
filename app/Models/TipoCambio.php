<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoCambio extends Model
{
    protected $table = 'tipos_cambio';

    protected $fillable = [
        'moneda_origen_id',
        'moneda_destino_id',
        'cotizacion',
        'fecha',
    ];

    protected function casts(): array
    {
        return [
            'fecha' => 'date',
            'cotizacion' => 'decimal:6',
        ];
    }
}

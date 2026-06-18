<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
            'cotizacion' => 'decimal:6',
            'fecha' => 'date:Y-m-d',
        ];
    }

    public function monedaOrigen(): BelongsTo
    {
        return $this->belongsTo(
            Moneda::class,
            'moneda_origen_id'
        );
    }

    public function monedaDestino(): BelongsTo
    {
        return $this->belongsTo(
            Moneda::class,
            'moneda_destino_id'
        );
    }
}

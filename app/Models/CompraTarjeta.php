<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CompraTarjeta extends Model
{
    use HasFactory;

    protected $table = 'compras_tarjeta';

    protected $fillable = [
        'tarjeta_id',
        'descripcion',
        'fecha_compra',
        'monto_total',
        'cuotas',
    ];

    protected function casts(): array
    {
        return [
            'fecha_compra' => 'date',
            'monto_total' => 'decimal:2',
            'cuotas' => 'integer',
        ];
    }

    public function tarjeta(): BelongsTo
    {
        return $this->belongsTo(TarjetaCredito::class, 'tarjeta_id');
    }

    public function cuotasDetalle(): HasMany
    {
        return $this->hasMany(CuotaTarjeta::class, 'compra_id');
    }
}

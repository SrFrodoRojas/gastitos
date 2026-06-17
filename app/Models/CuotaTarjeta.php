<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CuotaTarjeta extends Model
{
    use HasFactory;

    protected $table = 'cuotas_tarjeta';

    protected $fillable = [
        'compra_id',
        'numero_cuota',
        'monto',
        'fecha_vencimiento',
        'pagada',
        'fecha_pago',
    ];

    protected function casts(): array
    {
        return [
            'monto' => 'decimal:2',
            'pagada' => 'boolean',
            'fecha_vencimiento' => 'date',
            'fecha_pago' => 'date',
        ];
    }

    public function compra(): BelongsTo
    {
        return $this->belongsTo(CompraTarjeta::class, 'compra_id');
    }
}

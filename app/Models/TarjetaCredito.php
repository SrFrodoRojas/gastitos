<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TarjetaCredito extends Model
{
    use HasFactory;

    protected $table = 'tarjetas_credito';

    protected $fillable = [
        'user_id',
        'nombre',
        'limite_credito',
        'saldo_actual',
        'dia_cierre',
        'dia_vencimiento',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'limite_credito' => 'decimal:2',
            'saldo_actual' => 'decimal:2',
            'activo' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function compras(): HasMany
    {
        return $this->hasMany(CompraTarjeta::class, 'tarjeta_id');
    }
}

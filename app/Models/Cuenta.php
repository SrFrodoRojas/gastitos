<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cuenta extends Model
{
    use HasFactory;

    protected $table = 'cuentas';

    protected $fillable = [
        'user_id',
        'moneda_id',
        'nombre',
        'tipo',
        'saldo_inicial',
        'saldo_actual',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'saldo_inicial' => 'decimal:2',
            'saldo_actual' => 'decimal:2',
            'activo' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function moneda(): BelongsTo
    {
        return $this->belongsTo(Moneda::class);
    }

    public function movimientos(): HasMany
    {
        return $this->hasMany(Movimiento::class);
    }

    public function transferenciasOrigen(): HasMany
    {
        return $this->hasMany(Transferencia::class, 'cuenta_origen_id');
    }

    public function transferenciasDestino(): HasMany
    {
        return $this->hasMany(Transferencia::class, 'cuenta_destino_id');
    }
}

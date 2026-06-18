<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Transferencia extends Model
{
    use HasFactory;

    protected $table = 'transferencias';

    protected $fillable = [
        'user_id',
        'cuenta_origen_id',
        'cuenta_destino_id',
        'fecha',
        'monto_origen',
        'monto_destino',
        'cotizacion',
        'descripcion',
    ];

    protected function casts(): array
    {
        return [
            'fecha' => 'date:Y-m-d',
            'monto_origen' => 'decimal:2',
            'monto_destino' => 'decimal:2',
            'cotizacion' => 'decimal:6',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cuentaOrigen(): BelongsTo
    {
        return $this->belongsTo(
            Cuenta::class,
            'cuenta_origen_id'
        );
    }

    public function cuentaDestino(): BelongsTo
    {
        return $this->belongsTo(
            Cuenta::class,
            'cuenta_destino_id'
        );
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class MovimientoRecurrente extends Model
{
    protected $table = 'movimientos_recurrentes';

    protected $fillable = [
        'user_id',
        'cuenta_id',
        'categoria_id',
        'tipo',
        'descripcion',
        'monto',
        'frecuencia',
        'proxima_fecha',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'proxima_fecha' => 'date:Y-m-d',
            'monto' => 'decimal:2',
            'activo' => 'boolean',
        ];
    }

    public function cuenta(): BelongsTo
    {
        return $this->belongsTo(Cuenta::class);
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

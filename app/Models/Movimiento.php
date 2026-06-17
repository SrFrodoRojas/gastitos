<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    use HasFactory;

    protected $table = 'movimientos';

    protected $fillable = [
        'user_id',
        'cuenta_id',
        'categoria_id',
        'tipo',
        'fecha',
        'descripcion',
        'monto',
        'observacion',
    ];

    protected function casts(): array
    {
        return [
            'fecha' => 'date:Y-m-d',
            'monto' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cuenta(): BelongsTo
    {
        return $this->belongsTo(Cuenta::class);
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    public function etiquetas(): BelongsToMany
    {
        return $this->belongsToMany(
            Etiqueta::class,
            'movimiento_etiqueta',
            'movimiento_id',
            'etiqueta_id'
        )->using(MovimientoEtiqueta::class);
    }
}

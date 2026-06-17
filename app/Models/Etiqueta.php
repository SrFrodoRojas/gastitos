<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;

class Etiqueta extends Model
{
    use HasFactory;

    protected $table = 'etiquetas';

    protected $fillable = [
        'user_id',
        'nombre',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function movimientos(): BelongsToMany
    {
        return $this->belongsToMany(
            Movimiento::class,
            'movimiento_etiqueta',
            'etiqueta_id',
            'movimiento_id'
        )->using(MovimientoEtiqueta::class);
    }
}

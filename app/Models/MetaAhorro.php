<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class MetaAhorro extends Model
{
    use HasFactory;

    protected $table = 'metas_ahorro';

    protected $fillable = [
        'user_id',
        'nombre',
        'descripcion',
        'monto_objetivo',
        'monto_actual',
        'fecha_objetivo',
        'estado',
    ];

    protected function casts(): array
    {
        return [
            'monto_objetivo' => 'decimal:2',
            'monto_actual' => 'decimal:2',
            'fecha_objetivo' => 'date:Y-m-d',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

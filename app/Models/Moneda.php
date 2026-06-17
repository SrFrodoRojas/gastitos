<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Moneda extends Model
{
    use HasFactory;

    protected $table = 'monedas';

    protected $fillable = [
        'nombre',
        'codigo',
        'simbolo',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'activo' => 'boolean',
        ];
    }

    public function cuentas()
    {
        return $this->hasMany(Cuenta::class);
    }
}

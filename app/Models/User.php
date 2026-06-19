<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function cuentas()
    {
        return $this->hasMany(Cuenta::class);
    }

    public function categorias()
    {
        return $this->hasMany(Categoria::class);
    }

    public function movimientos()
    {
        return $this->hasMany(Movimiento::class);
    }

    public function transferencias()
    {
        return $this->hasMany(Transferencia::class);
    }

    public function presupuestos()
    {
        return $this->hasMany(Presupuesto::class);
    }

    public function metasAhorro()
    {
        return $this->hasMany(MetaAhorro::class);
    }

    public function tarjetasCredito()
    {
        return $this->hasMany(TarjetaCredito::class);
    }

    public function etiquetas()
    {
        return $this->hasMany(Etiqueta::class);
    }

    public function movimientosRecurrentes()
    {
        return $this->hasMany(
            MovimientoRecurrente::class
        );
    }


    public function monedaPrincipal(): BelongsTo
    {
        return $this->belongsTo(Moneda::class, 'moneda_principal_id');
    }
}

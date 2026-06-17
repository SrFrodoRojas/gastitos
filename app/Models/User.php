<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
}

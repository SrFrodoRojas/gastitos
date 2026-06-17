<?php

namespace App\Providers;

use App\Models\Categoria;
use App\Models\CompraTarjeta;
use App\Models\Cuenta;
use App\Models\Movimiento;
use App\Models\Presupuesto;
use App\Models\Transferencia;
use App\Policies\CategoriaPolicy;
use App\Policies\CompraTarjetaPolicy;
use App\Policies\CuentaPolicy;
use App\Policies\MovimientoPolicy;
use App\Policies\PresupuestoPolicy;
use App\Policies\TransferenciaPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(
            Categoria::class,
            CategoriaPolicy::class
        );

        Gate::policy(
            Cuenta::class,
            CuentaPolicy::class
        );

        Gate::policy(
            Movimiento::class,
            MovimientoPolicy::class
        );

        Gate::policy(
            Transferencia::class,
            TransferenciaPolicy::class
        );

        Gate::policy(
            Presupuesto::class,
            PresupuestoPolicy::class
        );

        Gate::policy(
            CompraTarjeta::class,
            CompraTarjetaPolicy::class
        );
    }
}

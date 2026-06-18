<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoriaController;
use App\Http\Controllers\Api\CompraTarjetaController;
use App\Http\Controllers\Api\CuentaController;
use App\Http\Controllers\Api\CuotaTarjetaController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\EtiquetaController;
use App\Http\Controllers\Api\MetaAhorroController;
use App\Http\Controllers\Api\MovimientoController;
use App\Http\Controllers\Api\MovimientoEtiquetaController;
use App\Http\Controllers\Api\PresupuestoController;
use App\Http\Controllers\Api\PresupuestoResumenController;
use App\Http\Controllers\Api\ReporteController;
use App\Http\Controllers\Api\TarjetaCreditoController;
use App\Http\Controllers\Api\TransferenciaController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource(
        'categorias',
        CategoriaController::class
    );

    Route::apiResource(
        'cuentas',
        CuentaController::class
    );

    Route::apiResource(
        'movimientos',
        MovimientoController::class
    );

    Route::get(
        '/dashboard',
        [DashboardController::class, 'index']
    );

    Route::apiResource(
        'transferencias',
        TransferenciaController::class
    );

    Route::get(
        '/reportes/gastos-por-categoria',
        [ReporteController::class, 'gastosPorCategoria']
    );

    Route::get(
        '/presupuestos/resumen',
        [PresupuestoResumenController::class, 'index']
    );

    Route::apiResource(
        'presupuestos',
        PresupuestoController::class
    );

    Route::apiResource(
        'metas-ahorro',
        MetaAhorroController::class
    );

    Route::apiResource(
        'tarjetas-credito',
        TarjetaCreditoController::class
    );

    Route::apiResource(
        'compras-tarjeta',
        CompraTarjetaController::class
    )
        ->parameters([
            'compras-tarjeta' => 'compraTarjeta',
        ])
        ->except(['update']);

    Route::get(
        'cuotas-tarjeta',
        [CuotaTarjetaController::class, 'index']
    );

    Route::get(
        'cuotas-tarjeta/{cuotaTarjeta}',
        [CuotaTarjetaController::class, 'show']
    );

    Route::patch(
        'cuotas-tarjeta/{cuotaTarjeta}/pagar',
        [CuotaTarjetaController::class, 'pagar']
    );

    Route::apiResource(
        'etiquetas',
        EtiquetaController::class
    );

    Route::get(
        'movimientos/{movimiento}/etiquetas',
        [MovimientoEtiquetaController::class, 'index']
    );

    Route::put(
        'movimientos/{movimiento}/etiquetas',
        [MovimientoEtiquetaController::class, 'sync']
    );
});

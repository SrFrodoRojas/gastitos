<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoriaController;
use App\Http\Controllers\Api\CuentaController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\MovimientoController;
use App\Http\Controllers\Api\PresupuestoController;
use App\Http\Controllers\Api\PresupuestoResumenController;
use App\Http\Controllers\Api\ReporteController;
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

    /* Aca agregue un comentario */
});

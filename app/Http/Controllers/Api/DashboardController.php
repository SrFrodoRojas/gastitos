<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cuenta;
use App\Models\Movimiento;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $userId = auth()->id();

        $inicioMes = now()->startOfMonth()->toDateString();
        $finMes = now()->endOfMonth()->toDateString();

        $saldoTotal = Cuenta::where(
            'user_id',
            $userId
        )->sum('saldo_actual');

        $ingresosMes = Movimiento::query()
            ->where('user_id', $userId)
            ->where('tipo', 'ingreso')
            ->whereBetween('fecha', [
                $inicioMes,
                $finMes,
            ])
            ->sum('monto');

        $gastosMes = Movimiento::query()
            ->where('user_id', $userId)
            ->where('tipo', 'gasto')
            ->whereBetween('fecha', [
                $inicioMes,
                $finMes,
            ])
            ->sum('monto');

        $ultimosMovimientos = Movimiento::query()
            ->with([
                'cuenta',
                'categoria',
            ])
            ->where('user_id', $userId)
            ->orderByDesc('fecha')
            ->orderByDesc('id')
            ->limit(10)
            ->get();

        return response()->json([
            'saldo_total' => (float) $saldoTotal,
            'ingresos_mes' => (float) $ingresosMes,
            'gastos_mes' => (float) $gastosMes,
            'balance_mes' => (float) (
                $ingresosMes - $gastosMes
            ),
            'ultimos_movimientos' => $ultimosMovimientos,
        ]);
    }
}

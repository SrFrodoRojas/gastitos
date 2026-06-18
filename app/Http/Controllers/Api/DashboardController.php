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

        $saldoTotal = 0;

        $cuentas = Cuenta::query()
            ->with('moneda')
            ->where('user_id', $userId)
            ->get();

        foreach ($cuentas as $cuenta) {
            if ($cuenta->moneda_id == 1) {
                $saldoTotal += $cuenta->saldo_actual;

                continue;
            }

            $tipoCambio = \App\Models\TipoCambio::query()
                ->where(
                    'moneda_origen_id',
                    $cuenta->moneda_id
                )
                ->where(
                    'moneda_destino_id',
                    1
                )
                ->latest('fecha')
                ->first();

            if (!$tipoCambio) {
                continue;
            }

            $saldoTotal += (
                $cuenta->saldo_actual
                * $tipoCambio->cotizacion
            );
        }

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
                'cuenta.moneda',
                'categoria',
            ])
            ->where('user_id', $userId)
            ->orderByDesc('fecha')
            ->orderByDesc('id')
            ->limit(10)
            ->get();

        $patrimonio = Cuenta::query()
            ->with('moneda')
            ->where('user_id', $userId)
            ->get()
            ->groupBy(fn($cuenta) => $cuenta->moneda->codigo)
            ->map(fn($cuentas) => round(
                $cuentas->sum('saldo_actual'),
                2
            ));

        return response()->json([
            'saldo_total_pyg' => (float) $saldoTotal,
            'patrimonio' => $patrimonio,
            'ingresos_mes' => (float) $ingresosMes,
            'gastos_mes' => (float) $gastosMes,
            'balance_mes' => (float) (
                $ingresosMes - $gastosMes
            ),
            'cuentas' => $cuentas,
            'ultimos_movimientos' =>
                $ultimosMovimientos,
        ]);
    }
}

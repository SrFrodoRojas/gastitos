<?php

namespace App\Http\Controllers\Api;

use App\Models\Movimiento;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    public function gastosPorCategoria(
        Request $request
    ): JsonResponse {

        $inicioMes = now()->startOfMonth();
        $finMes = now()->endOfMonth();

        $datos = Movimiento::query()
            ->select(
                'categoria_id',
                DB::raw('SUM(monto) as total')
            )
            ->with('categoria')
            ->where(
                'user_id',
                auth()->id()
            )
            ->where(
                'tipo',
                'gasto'
            )
            ->whereBetween(
                'fecha',
                [
                    $inicioMes,
                    $finMes,
                ]
            )
            ->groupBy(
                'categoria_id'
            )
            ->orderByDesc(
                'total'
            )
            ->get();

        return response()->json(
            $datos
        );
    }
}

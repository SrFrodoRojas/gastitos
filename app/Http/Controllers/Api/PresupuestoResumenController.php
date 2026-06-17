<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Movimiento;
use App\Models\Presupuesto;

class PresupuestoResumenController extends Controller
{
    public function index()
    {
        $presupuestos = auth()
            ->user()
            ->presupuestos()
            ->with('categoria')
            ->get();

        $resultado = [];

        foreach ($presupuestos as $presupuesto) {
            $gastado = Movimiento::query()
                ->where('user_id', auth()->id())
                ->where('categoria_id', $presupuesto->categoria_id)
                ->where('tipo', 'gasto')
                ->whereYear(
                    'fecha',
                    $presupuesto->anio
                )
                ->whereMonth(
                    'fecha',
                    $presupuesto->mes
                )
                ->sum('monto');

            $limite = (float) $presupuesto->monto_limite;

            $disponible = max(
                0,
                $limite - $gastado
            );

            $porcentaje = $limite > 0
                ? round(
                    ($gastado / $limite) * 100,
                    2
                )
                : 0;

            $estado = 'ok';
            $color = 'green';

            if ($porcentaje >= 100) {
                $estado = 'danger';
                $color = 'red';
            } elseif ($porcentaje >= 80) {
                $estado = 'warning';
                $color = 'orange';
            }

            $resultado[] = [
                'id' => $presupuesto->id,
                'anio' => $presupuesto->anio,
                'mes' => $presupuesto->mes,
                'categoria' => [
                    'id' => $presupuesto->categoria->id,
                    'nombre' => $presupuesto->categoria->nombre,
                    'tipo' => $presupuesto->categoria->tipo,
                ],
                'limite' => $limite,
                'gastado' => (float) $gastado,
                'disponible' => $disponible,
                'porcentaje' => $porcentaje,
                'estado' => $estado,
                'color' => $color,
            ];
        }

        return response()->json([
            'data' => $resultado,
        ]);
    }
}

<?php

namespace App\Services;

use App\Models\Cuenta;

class SaldoCuentaService
{
    public function recalcular(
        Cuenta $cuenta
    ): void {

        $ingresos = $cuenta
            ->movimientos()
            ->where('tipo', 'ingreso')
            ->sum('monto');

        $gastos = $cuenta
            ->movimientos()
            ->where('tipo', 'gasto')
            ->sum('monto');

        $cuenta->saldo_actual =
            $cuenta->saldo_inicial +
            $ingresos -
            $gastos;

        $cuenta->saveQuietly();
    }
}

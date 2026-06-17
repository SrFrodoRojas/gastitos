<?php

namespace App\Services;

use App\Models\Cuenta;
use App\Models\Movimiento;
use Illuminate\Support\Facades\DB;

class MovimientoService
{
    public function __construct(
        private SaldoCuentaService $saldoService
    ) {
    }

    public function crear(
        int $userId,
        array $data
    ): Movimiento {

        return DB::transaction(
            function () use (
                $userId,
                $data
            ) {

                $cuenta = Cuenta::lockForUpdate()
                    ->findOrFail(
                        $data['cuenta_id']
                    );

                $movimiento = Movimiento::create([
                    'user_id' => $userId,
                    ...$data,
                ]);

                $this->saldoService
                    ->recalcular(
                        $cuenta
                    );

                return $movimiento;
            }
        );
    }

    public function eliminar(
        Movimiento $movimiento
    ): void {

        DB::transaction(
            function () use (
                $movimiento
            ) {

                $cuenta = Cuenta::lockForUpdate()
                    ->findOrFail(
                        $movimiento->cuenta_id
                    );

                $movimiento->delete();

                $this->saldoService
                    ->recalcular(
                        $cuenta
                    );
            }
        );
    }
}

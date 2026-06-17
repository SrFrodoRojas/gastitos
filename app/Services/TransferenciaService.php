<?php

namespace App\Services;

use App\Models\Cuenta;
use App\Models\Transferencia;
use Illuminate\Support\Facades\DB;

class TransferenciaService
{
    public function crear(
        int $userId,
        array $data
    ): Transferencia {

        return DB::transaction(
            function () use ($userId, $data) {

                $origen = Cuenta::lockForUpdate()
                    ->findOrFail(
                        $data['cuenta_origen_id']
                    );

                $destino = Cuenta::lockForUpdate()
                    ->findOrFail(
                        $data['cuenta_destino_id']
                    );

                if (
                    $origen->saldo_actual <
                    $data['monto']
                ) {
                    abort(
                        422,
                        'Saldo insuficiente.'
                    );
                }

                $transferencia =
                    Transferencia::create([
                        'user_id' => $userId,
                        ...$data,
                    ]);

                $origen->decrement(
                    'saldo_actual',
                    $data['monto']
                );

                $destino->increment(
                    'saldo_actual',
                    $data['monto']
                );

                return $transferencia;
            }
        );
    }
}

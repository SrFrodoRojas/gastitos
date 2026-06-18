<?php

namespace App\Services;

use App\Models\Cuenta;
use App\Models\Transferencia;
use App\Models\TipoCambio;
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

                $montoOrigen = $data['monto'];

                if (
                    $origen->saldo_actual <
                    $montoOrigen
                ) {
                    abort(
                        422,
                        'Saldo insuficiente.'
                    );
                }

                if (
                    $origen->moneda_id ==
                    $destino->moneda_id
                ) {

                    $cotizacion = 1;
                    $montoDestino = $montoOrigen;

                } else {

                    $tipoCambio = TipoCambio::query()
                        ->where(
                            'moneda_origen_id',
                            $origen->moneda_id
                        )
                        ->where(
                            'moneda_destino_id',
                            $destino->moneda_id
                        )
                        ->latest('fecha')
                        ->first();

                    if (!$tipoCambio) {
                        abort(
                            422,
                            'No existe cotización para estas monedas.'
                        );
                    }

                    $cotizacion =
                        $tipoCambio->cotizacion;

                    $montoDestino =
                        round(
                            $montoOrigen *
                            $cotizacion,
                            2
                        );
                }

                $transferencia =
                    Transferencia::create([
                        'user_id' => $userId,
                        'cuenta_origen_id' =>
                            $origen->id,
                        'cuenta_destino_id' =>
                            $destino->id,
                        'fecha' =>
                            $data['fecha'],
                        'descripcion' =>
                            $data['descripcion']
                                ?? null,
                        'monto_origen' =>
                            $montoOrigen,
                        'monto_destino' =>
                            $montoDestino,
                        'cotizacion' =>
                            $cotizacion,
                    ]);

                $origen->decrement(
                    'saldo_actual',
                    $montoOrigen
                );

                $destino->increment(
                    'saldo_actual',
                    $montoDestino
                );

                return $transferencia;
            }
        );
    }
}

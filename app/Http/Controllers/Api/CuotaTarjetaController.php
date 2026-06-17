<?php

namespace App\Http\Controllers\Api;

use App\Models\CuotaTarjeta;
use Illuminate\Support\Facades\DB;
use App\Models\TarjetaCredito;
use App\Http\Controllers\Controller;
use App\Http\Resources\CuotaTarjetaResource;

class CuotaTarjetaController extends Controller
{
    public function index()
    {
        return CuotaTarjetaResource::collection(
            CuotaTarjeta::query()
                ->whereHas(
                    'compra.tarjeta',
                    fn ($q) => $q->where(
                        'user_id',
                        auth()->id()
                    )
                )
                ->orderBy('fecha_vencimiento')
                ->get()
        );
    }

    public function show(
        CuotaTarjeta $cuotaTarjeta
    ) {
        $this->authorize(
            'view',
            $cuotaTarjeta
        );

        return new CuotaTarjetaResource(
            $cuotaTarjeta
        );
    }

    public function pagar(
        CuotaTarjeta $cuotaTarjeta
    ) {
        $this->authorize(
            'view',
            $cuotaTarjeta
        );

        if ($cuotaTarjeta->pagada) {
            return response()->json([
                'message' =>
                    'La cuota ya fue pagada',
            ], 422);
        }

        DB::transaction(
            function () use ($cuotaTarjeta) {

                $tarjeta = $cuotaTarjeta
                    ->compra
                    ->tarjeta;

                $tarjeta->decrement(
                    'saldo_actual',
                    $cuotaTarjeta->monto
                );

                $cuotaTarjeta->update([
                    'pagada' => true,
                    'fecha_pago' => now(),
                ]);
            }
        );

        return new CuotaTarjetaResource(
            $cuotaTarjeta->fresh()
        );
    }
}

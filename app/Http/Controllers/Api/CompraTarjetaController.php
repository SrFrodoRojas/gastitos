<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompraTarjetaStoreRequest;
use App\Http\Resources\CompraTarjetaResource;
use App\Models\CompraTarjeta;
use App\Models\CuotaTarjeta;
use App\Models\TarjetaCredito;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CompraTarjetaController extends Controller
{
    public function index()
    {
        return CompraTarjetaResource::collection(
            CompraTarjeta::query()
                ->whereHas(
                    'tarjeta',
                    fn($q) => $q->where(
                        'user_id',
                        auth()->id()
                    )
                )
                ->latest()
                ->get()
        );
    }

    public function store(
        CompraTarjetaStoreRequest $request
    ) {
        return DB::transaction(
            function () use ($request) {
                $tarjeta = TarjetaCredito::where(
                    'user_id',
                    auth()->id()
                )->findOrFail(
                    $request->tarjeta_id
                );

                $compra = CompraTarjeta::create(
                    $request->validated()
                );

                $tarjeta->increment(
                    'saldo_actual',
                    $compra->monto_total
                );

                $montoCuota = round(
                    $compra->monto_total
                        / $compra->cuotas,
                    2
                );

                $primerVencimiento = Carbon::parse(
                    $compra->fecha_compra
                )
                    ->addMonth()
                    ->day(
                        $tarjeta->dia_vencimiento
                    );

                for (
                    $i = 1;
                    $i <= $compra->cuotas;
                    $i++
                ) {
                    CuotaTarjeta::create([
                        'compra_id' => $compra->id,
                        'numero_cuota' => $i,
                        'monto' => $montoCuota,
                        'fecha_vencimiento' => $primerVencimiento
                            ->copy()
                            ->addMonths($i - 1),
                        'pagada' => false,
                    ]);
                }

                return new CompraTarjetaResource(
                    $compra
                );
            }
        );
    }

    public function show(
        CompraTarjeta $compraTarjeta
    ) {
        $this->authorize(
            'view',
            $compraTarjeta
        );

        return new CompraTarjetaResource(
            $compraTarjeta
        );
    }

    public function destroy(
        CompraTarjeta $compraTarjeta
    ) {
        $this->authorize(
            'delete',
            $compraTarjeta
        );

        DB::transaction(
            function () use ($compraTarjeta) {
                $compraTarjeta
                    ->tarjeta
                    ->decrement(
                        'saldo_actual',
                        $compraTarjeta->monto_total
                    );

                $compraTarjeta
                    ->cuotasDetalle()
                    ->delete();

                $compraTarjeta->delete();
            }
        );

        return response()->json([
            'message' =>
                'Compra eliminada correctamente',
        ]);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Models\TipoCambio;
use App\Http\Controllers\Controller;
use App\Http\Resources\TipoCambioResource;
use App\Http\Requests\TipoCambioStoreRequest;
use App\Http\Requests\TipoCambioUpdateRequest;
use Illuminate\Http\Request;

class TipoCambioController extends Controller
{
    public function index()
    {
        return TipoCambioResource::collection(
            TipoCambio::with([
                'monedaOrigen',
                'monedaDestino'
            ])
            ->latest('fecha')
            ->get()
        );
    }

    public function store(TipoCambioUpdateRequest $request, TipoCambio $tipoCambio)
    {
        $tipoCambio = TipoCambio::create(
            $request->validated([
                'moneda_origen_id' =>
                    'required|exists:monedas,id',

                'moneda_destino_id' =>
                    'required|exists:monedas,id',

                'cotizacion' =>
                    'required|numeric|gt:0',

                'fecha' =>
                    'required|date',
            ])
        );

        return new TipoCambioResource(
            $tipoCambio->load([
                'monedaOrigen',
                'monedaDestino'
            ])
        );
    }

    public function show(
        TipoCambio $tipoCambio
    )
    {
        return new TipoCambioResource(
            $tipoCambio->load([
                'monedaOrigen',
                'monedaDestino'
            ])
        );
    }

    public function update(
        Request $request,
        TipoCambio $tipoCambio
    )
    {
        $tipoCambio->update(
            $request->validated([
                'cotizacion' =>
                    'required|numeric|gt:0',
            ])
        );

        return new TipoCambioResource(
            $tipoCambio->fresh()->load([
                'monedaOrigen',
                'monedaDestino'
            ])
        );
    }

    public function destroy(
        TipoCambio $tipoCambio
    )
    {
        $tipoCambio->delete();

        return response()->json([
            'success' => true
        ]);
    }
}

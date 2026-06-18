<?php

namespace App\Http\Controllers\Api;

use App\Models\TipoCambio;
use App\Http\Controllers\Controller;
use App\Http\Resources\TipoCambioResource;
use Illuminate\Http\Request;

class TipoCambioController extends Controller
{
    public function index()
    {
        return TipoCambioResource::collection(
            TipoCambio::latest('fecha')->get()
        );
    }

    public function store(
        Request $request
    ) {
        $data = $request->validate([
            'moneda_origen_id' => [
                'required',
                'exists:monedas,id',
            ],
            'moneda_destino_id' => [
                'required',
                'exists:monedas,id',
            ],
            'cotizacion' => [
                'required',
                'numeric',
                'gt:0',
            ],
            'fecha' => [
                'required',
                'date',
            ],
        ]);

        return new TipoCambioResource(
            TipoCambio::create($data)
        );
    }

    public function show(
        TipoCambio $tipoCambio
    ) {
        return new TipoCambioResource(
            $tipoCambio
        );
    }

    public function update(
        Request $request,
        TipoCambio $tipoCambio
    ) {
        $tipoCambio->update(
            $request->validate([
                'moneda_origen_id' => [
                    'required',
                    'exists:monedas,id',
                ],
                'moneda_destino_id' => [
                    'required',
                    'exists:monedas,id',
                ],
                'cotizacion' => [
                    'required',
                    'numeric',
                    'gt:0',
                ],
                'fecha' => [
                    'required',
                    'date',
                ],
            ])
        );

        return new TipoCambioResource(
            $tipoCambio->fresh()
        );
    }

    public function destroy(
        TipoCambio $tipoCambio
    ) {
        $tipoCambio->delete();

        return response()->json([
            'success' => true,
        ]);
    }
}

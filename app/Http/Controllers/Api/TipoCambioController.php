<?php

namespace App\Http\Controllers\Api;

use App\Models\TipoCambio;
use App\Http\Controllers\Controller;
use App\Http\Resources\TipoCambioResource;
use App\Http\Requests\TipoCambioStoreRequest;
use App\Http\Requests\TipoCambioUpdateRequest;

class TipoCambioController extends Controller
{
    public function index()
    {
        return TipoCambioResource::collection(
            TipoCambio::latest('fecha')
                ->get()
        );
    }

    public function store(
        TipoCambioStoreRequest $request
    ) {
        $tipoCambio =
            TipoCambio::create(
                $request->validated()
            );

        return new TipoCambioResource(
            $tipoCambio
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
        TipoCambioUpdateRequest $request,
        TipoCambio $tipoCambio
    ) {
        $tipoCambio->update(
            $request->validated()
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
            'message' =>
                'Tipo de cambio eliminado correctamente',
        ]);
    }
}

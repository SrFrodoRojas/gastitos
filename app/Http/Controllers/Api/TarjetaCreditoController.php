<?php

namespace App\Http\Controllers\Api;

use App\Models\TarjetaCredito;
use App\Http\Controllers\Controller;
use App\Http\Resources\TarjetaCreditoResource;
use App\Http\Requests\TarjetaCreditoStoreRequest;
use App\Http\Requests\TarjetaCreditoUpdateRequest;
use Illuminate\Http\JsonResponse;

class TarjetaCreditoController extends Controller
{
    public function index()
    {
        return TarjetaCreditoResource::collection(
            auth()->user()
                ->tarjetasCredito()
                ->latest()
                ->get()
        );
    }

    public function store(
        TarjetaCreditoStoreRequest $request
    ) {
        $tarjeta = TarjetaCredito::create([
            ...$request->validated(),
            'user_id' => auth()->id(),
        ]);

        return new TarjetaCreditoResource($tarjeta);
    }

    public function show(
        TarjetaCredito $tarjetaCredito
    ) {
        $this->authorize('view', $tarjetaCredito);

        return new TarjetaCreditoResource(
            $tarjetaCredito
        );
    }

    public function update(
        TarjetaCreditoUpdateRequest $request,
        TarjetaCredito $tarjetaCredito
    ) {
        $this->authorize(
            'update',
            $tarjetaCredito
        );

        $tarjetaCredito->update(
            $request->validated()
        );

        return new TarjetaCreditoResource(
            $tarjetaCredito
        );
    }

    public function destroy(
        TarjetaCredito $tarjetaCredito
    ): JsonResponse {
        $this->authorize(
            'delete',
            $tarjetaCredito
        );

        $tarjetaCredito->delete();

        return response()->json([
            'message' => 'Tarjeta eliminada correctamente',
        ]);
    }
}

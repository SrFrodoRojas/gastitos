<?php

namespace App\Http\Controllers\Api;

use App\Models\Cuenta;
use App\Models\Transferencia;
use App\Http\Controllers\Controller;
use App\Services\TransferenciaService;
use App\Http\Resources\TransferenciaResource;
use App\Http\Requests\TransferenciaStoreRequest;

class TransferenciaController extends Controller
{
    public function __construct(
        private TransferenciaService $service
    ) {
    }

    public function index()
    {
        return TransferenciaResource::collection(
            auth()
                ->user()
                ->transferencias()
                ->with([
                    'cuentaOrigen.moneda',
                    'cuentaDestino.moneda',
                ])
                ->orderByDesc('fecha')
                ->orderByDesc('id')
                ->get()
        );
    }

    public function store(
        TransferenciaStoreRequest $request
    )
    {
        $data = $request->validated();

        $origen = Cuenta::findOrFail(
            $data['cuenta_origen_id']
        );

        $destino = Cuenta::findOrFail(
            $data['cuenta_destino_id']
        );

        $this->authorize(
            'view',
            $origen
        );

        $this->authorize(
            'view',
            $destino
        );

        $transferencia = $this->service->crear(
            auth()->id(),
            $data
        );

        return (new TransferenciaResource(
            $transferencia->load([
                'cuentaOrigen.moneda',
                'cuentaDestino.moneda',
            ])
        ))
            ->response()
            ->setStatusCode(201);
    }

    public function show(
        Transferencia $transferencia
    )
    {
        $this->authorize(
            'view',
            $transferencia
        );

        return new TransferenciaResource(
            $transferencia->load([
                'cuentaOrigen.moneda',
                'cuentaDestino.moneda',
            ])
        );
    }

    public function update()
    {
        abort(405);
    }

    public function destroy()
    {
        abort(405);
    }
}

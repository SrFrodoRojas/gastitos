<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransferenciaStoreRequest;
use App\Http\Resources\TransferenciaResource;
use App\Models\Cuenta;
use App\Models\Transferencia;
use App\Services\TransferenciaService;
use Illuminate\Http\Request;

class TransferenciaController extends Controller
{
    public function __construct(
        private TransferenciaService $service
    ) {}

    public function index(Request $request)
    {
        $query = Transferencia::query()
            ->with([
                'cuentaOrigen.moneda',
                'cuentaDestino.moneda',
            ])
            ->where(
                'user_id',
                auth()->id()
            );

        if ($request->filled('cuenta_id')) {
            $query->where(function ($q) use ($request) {
                $q->where(
                    'cuenta_origen_id',
                    $request->cuenta_id
                )->orWhere(
                    'cuenta_destino_id',
                    $request->cuenta_id
                );
            });
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate(
                'fecha',
                '>=',
                $request->fecha_desde
            );
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate(
                'fecha',
                '<=',
                $request->fecha_hasta
            );
        }

        if ($request->filled('texto')) {
            $query->where(
                'descripcion',
                'like',
                '%' . $request->texto . '%'
            );
        }

        return TransferenciaResource::collection(
            $query
                ->orderByDesc('fecha')
                ->orderByDesc('id')
                ->get()
        );
    }

    public function store(
        TransferenciaStoreRequest $request
    ) {
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
    ) {
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

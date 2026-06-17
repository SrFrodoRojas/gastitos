<?php

namespace App\Http\Controllers\Api;

use App\Models\Cuenta;
use App\Models\Categoria;
use App\Models\Movimiento;
use App\Http\Controllers\Controller;
use App\Services\MovimientoService;
use App\Http\Resources\MovimientoResource;
use App\Http\Requests\MovimientoStoreRequest;
use App\Http\Requests\MovimientoUpdateRequest;

class MovimientoController extends Controller
{
    public function __construct(
        private MovimientoService $service
    ) {
    }

    public function index()
    {
        return MovimientoResource::collection(
            auth()
                ->user()
                ->movimientos()
                ->with([
                    'cuenta.moneda',
                    'categoria',
                ])
                ->orderByDesc('fecha')
                ->orderByDesc('id')
                ->get()
        );
    }

    public function store(
        MovimientoStoreRequest $request
    )
    {
        $data = $request->validated();

        $cuenta = Cuenta::findOrFail(
            $data['cuenta_id']
        );

        $this->authorize(
            'view',
            $cuenta
        );

        $categoria = Categoria::findOrFail(
            $data['categoria_id']
        );

        $this->authorize(
            'view',
            $categoria
        );

        if (
            $categoria->tipo !== $data['tipo']
        ) {
            abort(
                422,
                'La categoría no corresponde al tipo de movimiento.'
            );
        }

        $movimiento = $this->service->crear(
            auth()->id(),
            $data
        );

        return (new MovimientoResource(
            $movimiento->load([
                'cuenta.moneda',
                'categoria',
            ])
        ))
            ->response()
            ->setStatusCode(201);
    }

    public function show(
        Movimiento $movimiento
    )
    {
        $this->authorize(
            'view',
            $movimiento
        );

        return new MovimientoResource(
            $movimiento->load([
                'cuenta.moneda',
                'categoria',
            ])
        );
    }

    public function update(
        MovimientoUpdateRequest $request,
        Movimiento $movimiento
    )
    {
        $this->authorize(
            'update',
            $movimiento
        );

        $movimiento->update(
            $request->validated()
        );

        return new MovimientoResource(
            $movimiento->fresh()->load([
                'cuenta.moneda',
                'categoria',
            ])
        );
    }

    public function destroy(
        Movimiento $movimiento
    )
    {
        $this->authorize(
            'delete',
            $movimiento
        );

        $this->service->eliminar(
            $movimiento
        );

        return response()->json([
            'success' => true,
        ]);
    }
}

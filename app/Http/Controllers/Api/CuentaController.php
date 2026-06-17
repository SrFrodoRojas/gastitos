<?php

namespace App\Http\Controllers\Api;

use App\Models\Cuenta;
use App\Http\Controllers\Controller;
use App\Http\Requests\CuentaStoreRequest;
use App\Http\Requests\CuentaUpdateRequest;
use App\Http\Resources\CuentaResource;

class CuentaController extends Controller
{
    public function index()
    {
        return CuentaResource::collection(
            auth()
                ->user()
                ->cuentas()
                ->with('moneda')
                ->orderBy('nombre')
                ->get()
        );
    }

    public function store(
        CuentaStoreRequest $request
    )
    {
        $data = $request->validated();

        $cuenta = Cuenta::create([
            'user_id' => auth()->id(),
            'moneda_id' => $data['moneda_id'],
            'nombre' => $data['nombre'],
            'tipo' => $data['tipo'],
            'saldo_inicial' => $data['saldo_inicial'],
            'saldo_actual' => $data['saldo_inicial'],
            'activo' => $data['activo'] ?? true,
        ]);

        return (new CuentaResource(
            $cuenta->load('moneda')
        ))
            ->response()
            ->setStatusCode(201);
    }

    public function show(
        Cuenta $cuenta
    )
    {
        $this->authorize(
            'view',
            $cuenta
        );

        return new CuentaResource(
            $cuenta->load('moneda')
        );
    }

    public function update(
        CuentaUpdateRequest $request,
        Cuenta $cuenta
    )
    {
        $this->authorize(
            'update',
            $cuenta
        );

        $data = $request->validated();

        unset($data['saldo_inicial']);

        $cuenta->update($data);

        return new CuentaResource(
            $cuenta->fresh()->load('moneda')
        );
    }

    public function destroy(
        Cuenta $cuenta
    )
    {
        $this->authorize(
            'delete',
            $cuenta
        );

        $cuenta->delete();

        return response()->json([
            'success' => true,
        ]);
    }
}

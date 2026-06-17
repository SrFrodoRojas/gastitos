<?php

namespace App\Http\Controllers\Api;

use App\Models\Categoria;
use App\Models\Presupuesto;
use App\Http\Controllers\Controller;
use App\Http\Resources\PresupuestoResource;
use App\Http\Requests\PresupuestoStoreRequest;
use App\Http\Requests\PresupuestoUpdateRequest;

class PresupuestoController extends Controller
{
    public function index()
    {
        return PresupuestoResource::collection(
            auth()
                ->user()
                ->presupuestos()
                ->with('categoria')
                ->orderByDesc('anio')
                ->orderByDesc('mes')
                ->get()
        );
    }

    public function store(
        PresupuestoStoreRequest $request
    )
    {
        $categoria = Categoria::findOrFail(
            $request->categoria_id
        );

        $this->authorize(
            'view',
            $categoria
        );

        $presupuesto = Presupuesto::create([
            'user_id' => auth()->id(),
            ...$request->validated(),
        ]);

        return (new PresupuestoResource(
            $presupuesto->load('categoria')
        ))
            ->response()
            ->setStatusCode(201);
    }

    public function show(
        Presupuesto $presupuesto
    )
    {
        $this->authorize(
            'view',
            $presupuesto
        );

        return new PresupuestoResource(
            $presupuesto->load('categoria')
        );
    }

    public function update(
        PresupuestoUpdateRequest $request,
        Presupuesto $presupuesto
    )
    {
        $this->authorize(
            'update',
            $presupuesto
        );

        $presupuesto->update(
            $request->validated()
        );

        return new PresupuestoResource(
            $presupuesto->fresh()->load('categoria')
        );
    }

    public function destroy(
        Presupuesto $presupuesto
    )
    {
        $this->authorize(
            'delete',
            $presupuesto
        );

        $presupuesto->delete();

        return response()->json([
            'success' => true,
        ]);
    }
}

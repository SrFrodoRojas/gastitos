<?php

namespace App\Http\Controllers\Api;

use App\Models\MovimientoRecurrente;
use App\Http\Controllers\Controller;
use App\Http\Requests\MovimientoRecurrenteStoreRequest;
use App\Http\Requests\MovimientoRecurrenteUpdateRequest;
use App\Http\Resources\MovimientoRecurrenteResource;

class MovimientoRecurrenteController extends Controller
{
    public function index()
    {
        return MovimientoRecurrenteResource::collection(
            auth()->user()
                ->movimientosRecurrentes()
                ->with(['cuenta.moneda', 'categoria'])
                ->latest()
                ->get()
        );
    }

    public function store(MovimientoRecurrenteStoreRequest $request)
    {
        $item = MovimientoRecurrente::create([
            ...$request->validated(),
            'user_id' => auth()->id(),
        ]);

        return new MovimientoRecurrenteResource(
            $item->load([
                'cuenta.moneda',
                'categoria',
            ])
        );
    }

    public function show(MovimientoRecurrente $movimientoRecurrente)
    {
        abort_unless(
            $movimientoRecurrente->user_id == auth()->id(),
            403
        );

        return new MovimientoRecurrenteResource(
            $movimientoRecurrente->load([
                'cuenta.moneda',
                'categoria',
            ])
        );
    }

    public function update(
        MovimientoRecurrenteUpdateRequest $request,
        MovimientoRecurrente $movimientoRecurrente
    ) {
        abort_unless(
            $movimientoRecurrente->user_id == auth()->id(),
            403
        );

        $movimientoRecurrente->update(
            $request->validated()
        );

        return new MovimientoRecurrenteResource(
            $movimientoRecurrente->fresh()->load([
                'cuenta.moneda',
                'categoria',
            ])
        );
    }

    public function destroy(
        MovimientoRecurrente $movimientoRecurrente
    ) {
        abort_unless(
            $movimientoRecurrente->user_id == auth()->id(),
            403
        );

        $movimientoRecurrente->delete();

        return response()->json([
            'success' => true,
        ]);
    }
}

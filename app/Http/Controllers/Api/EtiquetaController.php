<?php

namespace App\Http\Controllers\Api;

use App\Models\Etiqueta;
use App\Http\Controllers\Controller;
use App\Http\Requests\EtiquetaStoreRequest;
use App\Http\Requests\EtiquetaUpdateRequest;
use App\Http\Resources\EtiquetaResource;

class EtiquetaController extends Controller
{
    public function index()
    {
        return EtiquetaResource::collection(
            Etiqueta::where(
                'user_id',
                auth()->id()
            )
            ->latest()
            ->get()
        );
    }

    public function store(
        EtiquetaStoreRequest $request
    ) {
        $etiqueta = Etiqueta::create([
            ...$request->validated(),
            'user_id' => auth()->id(),
        ]);

        return new EtiquetaResource(
            $etiqueta
        );
    }

    public function show(
        Etiqueta $etiqueta
    ) {
        $this->authorize(
            'view',
            $etiqueta
        );

        return new EtiquetaResource(
            $etiqueta
        );
    }

    public function update(
        EtiquetaUpdateRequest $request,
        Etiqueta $etiqueta
    ) {
        $this->authorize(
            'update',
            $etiqueta
        );

        $etiqueta->update(
            $request->validated()
        );

        return new EtiquetaResource(
            $etiqueta
        );
    }

    public function destroy(
        Etiqueta $etiqueta
    ) {
        $this->authorize(
            'delete',
            $etiqueta
        );

        $etiqueta->delete();

        return response()->json([
            'message' =>
                'Etiqueta eliminada correctamente',
        ]);
    }
}

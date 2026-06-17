<?php

namespace App\Http\Controllers\Api;

use App\Models\Categoria;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoriaStoreRequest;
use App\Http\Requests\CategoriaUpdateRequest;
use App\Http\Resources\CategoriaResource;

class CategoriaController extends Controller
{
    public function index()
    {
        return CategoriaResource::collection(
            auth()
                ->user()
                ->categorias()
                ->orderBy('nombre')
                ->get()
        );
    }

    public function store(
        CategoriaStoreRequest $request
    )
    {
        $categoria = Categoria::create([
            'user_id' => auth()->id(),
            ...$request->validated(),
        ]);

        return (new CategoriaResource(
            $categoria
        ))
            ->response()
            ->setStatusCode(201);
    }

    public function show(
        Categoria $categoria
    )
    {
        $this->authorize(
            'view',
            $categoria
        );

        return new CategoriaResource(
            $categoria
        );
    }

    public function update(
        CategoriaUpdateRequest $request,
        Categoria $categoria
    )
    {
        $this->authorize(
            'update',
            $categoria
        );

        $categoria->update(
            $request->validated()
        );

        return new CategoriaResource(
            $categoria->fresh()
        );
    }

    public function destroy(
        Categoria $categoria
    )
    {
        $this->authorize(
            'delete',
            $categoria
        );

        $categoria->delete();

        return response()->json([
            'success' => true,
        ]);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MetaAhorroStoreRequest;
use App\Http\Requests\MetaAhorroUpdateRequest;
use App\Http\Resources\MetaAhorroResource;
use App\Models\MetaAhorro;
use Illuminate\Http\JsonResponse;

class MetaAhorroController extends Controller
{
    public function index()
    {
        return MetaAhorroResource::collection(
            auth()->user()
                ->metasAhorro()
                ->latest()
                ->get()
        );
    }

    public function store(MetaAhorroStoreRequest $request)
    {
        $meta = MetaAhorro::create([
            ...$request->validated(),
            'user_id' => auth()->id(),
        ]);

        return new MetaAhorroResource($meta);
    }

    public function show(MetaAhorro $metaAhorro)
    {
        $this->authorize('view', $metaAhorro);

        return new MetaAhorroResource($metaAhorro);
    }

    public function update(
        MetaAhorroUpdateRequest $request,
        MetaAhorro $metaAhorro
    ) {
        $this->authorize('update', $metaAhorro);

        $metaAhorro->update(
            $request->validated()
        );

        return new MetaAhorroResource($metaAhorro);
    }

    public function destroy(MetaAhorro $metaAhorro): JsonResponse
    {
        $this->authorize('delete', $metaAhorro);

        $metaAhorro->delete();

        return response()->json([
            'message' => 'Meta eliminada correctamente'
        ]);
    }
}

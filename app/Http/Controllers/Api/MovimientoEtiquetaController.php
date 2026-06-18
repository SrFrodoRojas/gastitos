<?php

namespace App\Http\Controllers\Api;

use App\Models\Etiqueta;
use App\Models\Movimiento;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MovimientoEtiquetaController extends Controller
{
    public function sync(
        Request $request,
        Movimiento $movimiento
    ) {
        $this->authorize(
            'update',
            $movimiento
        );

        $etiquetas = Etiqueta::query()
            ->where(
                'user_id',
                auth()->id()
            )
            ->whereIn(
                'id',
                $request->etiquetas ?? []
            )
            ->pluck('id');

        $movimiento
            ->etiquetas()
            ->sync($etiquetas);

        return response()->json([
            'message' =>
                'Etiquetas actualizadas correctamente',
        ]);
    }

    public function index(
        Movimiento $movimiento
    ) {
        $this->authorize(
            'view',
            $movimiento
        );

        return response()->json([
            'data' => $movimiento
                ->etiquetas
                ->map(fn ($etiqueta) => [
                    'id' => $etiqueta->id,
                    'nombre' => $etiqueta->nombre,
                ]),
        ]);
    }
}

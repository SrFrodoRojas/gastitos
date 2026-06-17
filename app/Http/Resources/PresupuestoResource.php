<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PresupuestoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'anio' => $this->anio,
            'mes' => $this->mes,
            'monto_limite' => (float) $this->monto_limite,

            'categoria' => $this->whenLoaded(
                'categoria',
                fn () => [
                    'id' => $this->categoria->id,
                    'nombre' => $this->categoria->nombre,
                    'tipo' => $this->categoria->tipo,
                ]
            ),
        ];
    }
}

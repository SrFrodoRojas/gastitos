<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovimientoRecurrenteResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'tipo' => $this->tipo,
            'descripcion' => $this->descripcion,
            'monto' => (float) $this->monto,
            'frecuencia' => $this->frecuencia,
            'proxima_fecha' => $this->proxima_fecha?->format('Y-m-d'),
            'activo' => $this->activo,

            'cuenta' => new CuentaResource(
                $this->whenLoaded('cuenta')
            ),

            'categoria' => new CategoriaResource(
                $this->whenLoaded('categoria')
            ),
        ];
    }
}

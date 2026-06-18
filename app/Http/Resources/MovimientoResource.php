<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class MovimientoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'tipo' => $this->tipo,
            'fecha' => $this->fecha?->format('Y-m-d'),
            'descripcion' => $this->descripcion,
            'observacion' => $this->observacion,
            'monto' => (float) $this->monto,
            'cuenta' => $this->whenLoaded(
                'cuenta',
                fn() => new CuentaResource($this->cuenta)
            ),
            'categoria' => $this->whenLoaded(
                'categoria',
                fn() => new CategoriaResource($this->categoria)
            ),
            'comprobante' => $this->comprobante
                ? asset('storage/' . $this->comprobante)
                : null,
        ];
    }
}

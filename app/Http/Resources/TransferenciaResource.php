<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransferenciaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'fecha' => $this->fecha?->format('Y-m-d'),

            'monto' => (float) $this->monto,

            'descripcion' => $this->descripcion,

            'cuenta_origen' => $this->whenLoaded(
                'cuentaOrigen',
                fn () => new CuentaResource($this->cuentaOrigen)
            ),

            'cuenta_destino' => $this->whenLoaded(
                'cuentaDestino',
                fn () => new CuentaResource($this->cuentaDestino)
            ),
        ];
    }
}

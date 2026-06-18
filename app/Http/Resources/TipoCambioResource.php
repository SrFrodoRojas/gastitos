<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TipoCambioResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'moneda_origen' =>
                $this->monedaOrigen?->codigo,

            'moneda_destino' =>
                $this->monedaDestino?->codigo,

            'cotizacion' =>
                (float) $this->cotizacion,

            'fecha' =>
                $this->fecha?->format('Y-m-d'),
        ];
    }
}

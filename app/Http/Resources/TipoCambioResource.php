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

            'moneda_origen_id' =>
                $this->moneda_origen_id,

            'moneda_destino_id' =>
                $this->moneda_destino_id,

            'cotizacion' =>
                $this->cotizacion,

            'fecha' =>
                $this->fecha,

            'created_at' =>
                $this->created_at,

            'updated_at' =>
                $this->updated_at,
        ];
    }
}

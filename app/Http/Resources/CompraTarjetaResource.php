<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompraTarjetaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'tarjeta_id' => $this->tarjeta_id,
            'descripcion' => $this->descripcion,
            'fecha_compra' => $this->fecha_compra,
            'monto_total' => $this->monto_total,
            'cuotas' => $this->cuotas,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

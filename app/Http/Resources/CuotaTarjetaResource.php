<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CuotaTarjetaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'compra_id' => $this->compra_id,
            'numero_cuota' => $this->numero_cuota,
            'monto' => $this->monto,
            'fecha_vencimiento' => $this->fecha_vencimiento,
            'pagada' => $this->pagada,
            'fecha_pago' => $this->fecha_pago,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

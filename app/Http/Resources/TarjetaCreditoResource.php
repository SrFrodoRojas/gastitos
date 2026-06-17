<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TarjetaCreditoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'limite_credito' => $this->limite_credito,
            'saldo_actual' => $this->saldo_actual,
            'credito_disponible' => (
                (float) $this->limite_credito -
                (float) $this->saldo_actual
            ),
            'dia_cierre' => $this->dia_cierre,
            'dia_vencimiento' => $this->dia_vencimiento,
            'activo' => $this->activo,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

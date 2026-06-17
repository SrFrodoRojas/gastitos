<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CuentaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'tipo' => $this->tipo,

            'saldo_inicial' => (float) $this->saldo_inicial,
            'saldo_actual' => (float) $this->saldo_actual,

            'activo' => (bool) $this->activo,

            'moneda' => $this->whenLoaded('moneda', function () {
                return [
                    'id' => $this->moneda->id,
                    'nombre' => $this->moneda->nombre,
                    'codigo' => $this->moneda->codigo,
                    'simbolo' => $this->moneda->simbolo,
                ];
            }),
        ];
    }
}

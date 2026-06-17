<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MetaAhorroResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'monto_objetivo' => $this->monto_objetivo,
            'monto_actual' => $this->monto_actual,
            'porcentaje' => $this->monto_objetivo > 0
                ? round(($this->monto_actual / $this->monto_objetivo) * 100, 2)
                : 0,
            'fecha_objetivo' => $this->fecha_objetivo,
            'estado' => $this->estado,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

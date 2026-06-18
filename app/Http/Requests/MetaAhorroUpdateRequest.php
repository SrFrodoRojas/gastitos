<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MetaAhorroUpdateRequest extends FormRequest
{

dd([
    auth()->id(),
    $metaAhorro->id,
    $metaAhorro->user_id,
]);
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => [
                'sometimes',
                'string',
                'max:255',
            ],

            'descripcion' => [
                'sometimes',
                'nullable',
                'string',
            ],

            'monto_objetivo' => [
                'sometimes',
                'numeric',
                'min:1',
            ],

            'monto_actual' => [
                'sometimes',
                'numeric',
                'min:0',
            ],

            'fecha_objetivo' => [
                'sometimes',
                'nullable',
                'date',
            ],

            'estado' => [
                'sometimes',
                'in:activa,cumplida,cancelada',
            ],
        ];
    }
}

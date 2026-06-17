<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PresupuestoUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'categoria_id' => [
                'sometimes',
                'exists:categorias,id',
            ],

            'anio' => [
                'sometimes',
                'integer',
                'min:2020',
                'max:2100',
            ],

            'mes' => [
                'sometimes',
                'integer',
                'between:1,12',
            ],

            'monto_limite' => [
                'sometimes',
                'numeric',
                'gt:0',
            ],
        ];
    }
}

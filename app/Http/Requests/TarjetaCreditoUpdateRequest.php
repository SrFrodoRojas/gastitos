<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TarjetaCreditoUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['sometimes', 'string', 'max:255'],
            'limite_credito' => ['sometimes', 'numeric', 'min:0'],
            'saldo_actual' => ['sometimes', 'numeric', 'min:0'],
            'dia_cierre' => ['sometimes', 'integer', 'between:1,31'],
            'dia_vencimiento' => ['sometimes', 'integer', 'between:1,31'],
            'activo' => ['sometimes', 'boolean'],
        ];
    }
}

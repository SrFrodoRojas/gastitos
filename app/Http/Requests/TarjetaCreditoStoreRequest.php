<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TarjetaCreditoStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:255'],
            'limite_credito' => ['required', 'numeric', 'min:0'],
            'saldo_actual' => ['nullable', 'numeric', 'min:0'],
            'dia_cierre' => ['required', 'integer', 'between:1,31'],
            'dia_vencimiento' => ['required', 'integer', 'between:1,31'],
            'activo' => ['nullable', 'boolean'],
        ];
    }
}

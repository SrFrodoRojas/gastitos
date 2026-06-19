<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovimientoUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'fecha' => ['sometimes', 'date'],
            'descripcion' => ['sometimes', 'string', 'max:255'],
            'observacion' => ['sometimes', 'nullable', 'string'],
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MetaAhorroStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            'monto_objetivo' => ['required', 'numeric', 'min:1'],
            'monto_actual' => ['nullable', 'numeric', 'min:0'],
            'fecha_objetivo' => ['nullable', 'date'],
            'estado' => ['nullable', 'in:activa,cumplida,cancelada'],
        ];
    }
}

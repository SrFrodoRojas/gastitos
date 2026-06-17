<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CompraTarjetaStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tarjeta_id' => [
                'required',
                Rule::exists('tarjetas_credito', 'id'),
            ],
            'descripcion' => [
                'required',
                'string',
                'max:255',
            ],
            'fecha_compra' => [
                'required',
                'date',
            ],
            'monto_total' => [
                'required',
                'numeric',
                'min:0.01',
            ],
            'cuotas' => [
                'required',
                'integer',
                'min:1',
                'max:120',
            ],
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferenciaStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cuenta_origen_id' => [
                'required',
                'exists:cuentas,id',
                'different:cuenta_destino_id',
            ],

            'cuenta_destino_id' => [
                'required',
                'exists:cuentas,id',
            ],

            'fecha' => [
                'required',
                'date',
            ],

            'monto' => [
                'required',
                'numeric',
                'gt:0',
            ],

            'descripcion' => [
                'nullable',
                'string',
                'max:255',
            ],
        ];
    }
}

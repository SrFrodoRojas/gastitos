<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TipoCambioStoreRequest
    extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'moneda_origen_id' => [
                'required',
                'exists:monedas,id',
            ],

            'moneda_destino_id' => [
                'required',
                'exists:monedas,id',
                'different:moneda_origen_id',
            ],

            'cotizacion' => [
                'required',
                'numeric',
                'gt:0',
            ],

            'fecha' => [
                'required',
                'date',
            ],
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TipoCambioUpdateRequest
    extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
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

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
            'fecha' => [
                'required',
                'date',
            ],

            'descripcion' => [
                'required',
                'string',
                'max:255',
            ],

            'observacion' => [
                'nullable',
                'string',
            ],
        ];
    }
}

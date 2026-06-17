<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovimientoStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cuenta_id' => [
                'required',
                'exists:cuentas,id',
            ],

            'categoria_id' => [
                'required',
                'exists:categorias,id',
            ],

            'tipo' => [
                'required',
                'in:ingreso,gasto',
            ],

            'fecha' => [
                'required',
                'date',
            ],

            'descripcion' => [
                'required',
                'string',
                'max:255',
            ],

            'monto' => [
                'required',
                'numeric',
                'gt:0',
            ],

            'observacion' => [
                'nullable',
                'string',
            ],
        ];
    }
}

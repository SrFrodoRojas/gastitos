<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PresupuestoStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'categoria_id' => [
                'required',
                'exists:categorias,id',
            ],

            'anio' => [
                'required',
                'integer',
                'min:2020',
                'max:2100',
            ],

            'mes' => [
                'required',
                'integer',
                'between:1,12',
            ],

            'monto_limite' => [
                'required',
                'numeric',
                'gt:0',
            ],
        ];
    }
}

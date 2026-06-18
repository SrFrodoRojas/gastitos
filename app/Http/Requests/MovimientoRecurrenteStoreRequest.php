<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovimientoRecurrenteStoreRequest extends FormRequest
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

            'frecuencia' => [
                'required',
                'in:diaria,semanal,mensual,anual',
            ],

            'proxima_fecha' => [
                'required',
                'date',
            ],

            'activo' => [
                'boolean',
            ],
        ];
    }
}

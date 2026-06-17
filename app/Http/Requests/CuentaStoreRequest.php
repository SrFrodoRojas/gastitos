<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CuentaStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'moneda_id' => [
                'required',
                'exists:monedas,id',
            ],

            'nombre' => [
                'required',
                'string',
                'max:255',
                Rule::unique('cuentas')
                    ->where(
                        fn ($query) => $query
                            ->where('user_id', auth()->id())
                    ),
            ],

            'tipo' => [
                'required',
                'in:efectivo,banco,ahorro,tarjeta,billetera',
            ],

            'saldo_inicial' => [
                'required',
                'numeric',
                'min:0',
            ],

            'activo' => [
                'nullable',
                'boolean',
            ],
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoriaStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categorias')
                    ->where(
                        fn($query) => $query
                            ->where('user_id', auth()->id())
                            ->where('tipo', $this->tipo)
                    ),
            ],
            'tipo' => [
                'required',
                'in:ingreso,gasto',
            ],
            'icono' => [
                'nullable',
                'string',
                'max:100',
            ],
            'color' => [
                'nullable',
                'string',
                'max:20',
            ],
            'activo' => [
                'nullable',
                'boolean',
            ],
        ];
    }
}

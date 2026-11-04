<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAsignaturaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'codigo' => [
                'required', 'string', 'max:20',
                Rule::unique('asignaturas')->ignore($this->asignatura)
            ],
            'nombre' => 'required|string|max:150',
            'creditos' => 'required|integer|min:1|max:10',
        ];
    }
}
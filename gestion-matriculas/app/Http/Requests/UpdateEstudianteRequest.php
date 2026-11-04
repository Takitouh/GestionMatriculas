<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEstudianteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'documento_identidad' => [
                'required', 'string', 'max:20',
                Rule::unique('estudiantes')->ignore($this->estudiante) // Ignora el ID actual al validar unicidad
            ],
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'correo' => [
                'required', 'email', 'max:150',
                Rule::unique('estudiantes')->ignore($this->estudiante)
            ],
            'fecha_nacimiento' => 'required|date',
        ];
    }
}
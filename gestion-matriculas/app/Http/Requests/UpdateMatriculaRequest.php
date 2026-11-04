<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMatriculaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'estudiante_id' => 'required|exists:estudiantes,id',
            'periodo_academico' => 'required|string|max:20',
            'fecha_matricula' => 'required|date',
            'estado' => 'required|in:activa,cancelada',
            'grupos' => 'required|array|min:1',
            'grupos.*' => 'exists:grupos,id',
        ];
    }

    public function messages()
    {
        return [
            'grupos.required' => 'Debes mantener al menos un grupo seleccionado.',
        ];
    }
}
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGrupoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'asignatura_id' => 'required|exists:asignaturas,id',
            'nombre_grupo' => 'required|string|max:50',
            'cupo_maximo' => 'required|integer|min:1|max:100',
        ];
    }
}
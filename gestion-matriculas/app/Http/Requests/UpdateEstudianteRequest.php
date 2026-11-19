<?php

namespace App\Http\Requests;

use App\Models\Estudiante;
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
        $estudiante = $this->route('estudiante');

        $uniqueUserEmail = Rule::unique('users', 'email');

        if ($estudiante instanceof Estudiante && $estudiante->user_id) {
            $uniqueUserEmail->ignore($estudiante->user_id);
        }

        return [
            'documento_identidad' => [
                'required',
                'string',
                'max:20',
                Rule::unique('estudiantes', 'documento_identidad')
                    ->ignore($estudiante?->id),
            ],

            'nombres' => [
                'required',
                'string',
                'max:100',
            ],

            'apellidos' => [
                'required',
                'string',
                'max:100',
            ],

            'correo' => [
                'required',
                'email',
                'max:150',
                Rule::unique('estudiantes', 'correo')
                    ->ignore($estudiante?->id),
                $uniqueUserEmail,
            ],

            'fecha_nacimiento' => [
                'required',
                'date',
            ],
        ];
    }
}
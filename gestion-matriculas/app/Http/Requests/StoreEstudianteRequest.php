<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEstudianteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'documento_identidad' => [
                'required',
                'string',
                'max:20',
                'unique:estudiantes,documento_identidad',
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
                'unique:estudiantes,correo',
                'unique:users,email',
            ],

            'fecha_nacimiento' => [
                'required',
                'date',
            ],
        ];
    }
}
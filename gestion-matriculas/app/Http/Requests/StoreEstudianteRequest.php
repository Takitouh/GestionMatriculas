<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEstudianteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Cambiar a lógica de roles cuando se agregue autenticación
    }

    public function rules(): array
    {
        return [
            'documento_identidad' => 'required|string|unique:estudiantes,documento_identidad|max:20',
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'correo' => 'required|email|unique:estudiantes,correo|max:150',
            'fecha_nacimiento' => 'required|date',
        ];
    }
}
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAsignaturaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'codigo' => 'required|string|unique:asignaturas,codigo|max:20',
            'nombre' => 'required|string|max:150',
            'creditos' => 'required|integer|min:1|max:10',
        ];
    }
}
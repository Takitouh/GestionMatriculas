<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asignatura extends Model
{
    use HasFactory;

    // Conserva tus columnas existentes (ej. codigo, nombre, creditos, semestre)
    protected $guarded = ['id'];

    public function grupos()
    {
        return $this->hasMany(Grupo::class);
    }
}
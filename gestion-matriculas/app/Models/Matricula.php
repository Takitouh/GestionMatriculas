<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    use HasFactory;

    // Conserva tus columnas existentes (ej. estudiante_id, periodo, estado, fecha_matricula)
    protected $guarded = ['id'];

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function grupos()
    {
        return $this->belongsToMany(Grupo::class, 'grupo_matricula')
            ->withTimestamps();
    }
}
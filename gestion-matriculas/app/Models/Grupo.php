<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;

    // Conserva tus columnas existentes (ej. asignatura_id, codigo_grupo, docente, horario, salon, cupo_maximo)
    protected $guarded = ['id'];

    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class);
    }

    public function matriculas()
    {
        return $this->belongsToMany(Matricula::class, 'grupo_matricula')
            ->withTimestamps();
    }

    // Helper para calcular cupos disponibles en tiempo real
    public function cuposDisponibles(): int
    {
        $ocupados = $this->matriculas_count ?? $this->matriculas()->count();
        return max(0, ($this->cupo_maximo ?? 30) - $ocupados);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Matricula extends Model
{
    protected $fillable = [
        'estudiante_id',
        'periodo_academico',
        'fecha_matricula',
        'estado',
    ];

    public function estudiante(): BelongsTo
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function grupos(): BelongsToMany
    {
        return $this->belongsToMany(Grupo::class, 'grupo_matricula');
    }
}
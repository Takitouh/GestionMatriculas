<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Grupo extends Model
{
    protected $fillable = [
        'asignatura_id',
        'nombre_grupo',
        'cupo_maximo',
    ];

    public function asignatura(): BelongsTo
    {
        return $this->belongsTo(Asignatura::class);
    }

    public function matriculas(): BelongsToMany
    {
        return $this->belongsToMany(Matricula::class, 'grupo_matricula');
    }
}
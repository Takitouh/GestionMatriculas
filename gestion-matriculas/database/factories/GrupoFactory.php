<?php

namespace Database\Factories;

use App\Models\Asignatura;
use App\Models\Grupo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Grupo>
 */
class GrupoFactory extends Factory
{
    public function definition(): array
    {
        $letras = ['A', 'B', 'C', 'D'];
        $horarios = ['Mañana', 'Tarde', 'Noche'];

        return [
            'asignatura_id' => Asignatura::factory(),
            'nombre_grupo' => 'Grupo '.fake()->randomElement($letras).' - '.fake()->randomElement($horarios),
            'cupo_maximo' => fake()->numberBetween(25, 35),
        ];
    }
}
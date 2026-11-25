<?php

namespace Database\Factories;

use App\Models\Asignatura;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Asignatura>
 */
class AsignaturaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'codigo' => strtoupper(fake()->unique()->bothify('???-###')),
            'nombre' => ucfirst(fake()->unique()->words(2, true)),
            'creditos' => fake()->numberBetween(2, 5),
        ];
    }
}
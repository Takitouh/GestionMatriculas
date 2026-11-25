<?php

namespace Database\Factories;

use App\Models\Estudiante;
use App\Models\Matricula;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Matricula>
 */
class MatriculaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'estudiante_id' => Estudiante::factory(),
            'periodo_academico' => '2026-2',
            'fecha_matricula' => fake()->dateTimeBetween('-6 months', 'now')->format('Y-m-d'),
            'estado' => fake()->randomElement([
                'activa',
                'activa',
                'activa',
                'cancelada',
            ]),
        ];
    }
}
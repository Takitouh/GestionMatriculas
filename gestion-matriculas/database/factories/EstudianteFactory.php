<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Estudiante>
 */
class EstudianteFactory extends Factory
{
    public function definition(): array
    {
        $nombres = fake()->firstName();
        $apellidos = fake()->lastName();
        $correo = fake()->unique()->safeEmail();

        return [
            'user_id' => User::factory()->state([
                'name' => "{$nombres} {$apellidos}",
                'email' => $correo,
                'role' => 'estudiante',
                'email_verified_at' => now(),
            ]),

            'documento_identidad' => fake()->unique()->numerify('##########'),
            'nombres' => $nombres,
            'apellidos' => $apellidos,
            'correo' => $correo,
            'fecha_nacimiento' => fake()->dateTimeBetween('-30 years', '-18 years')->format('Y-m-d'),
        ];
    }
}
<?php

namespace Database\Seeders;

use App\Models\Asignatura;
use App\Models\Estudiante;
use App\Models\Grupo;
use App\Models\Matricula;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Crear administrador principal
        $admin = User::updateOrCreate(
            ['email' => 'admin@edugestion.com'],
            [
                'name' => 'Administrador',
                'role' => 'admin',
                'password' => 'admin123',
            ]
        );

        $admin->forceFill([
            'email_verified_at' => now(),
        ])->save();

        // 2. Crear 25 asignaturas
        $nombresAsignaturas = [
            ['codigo' => 'SIS-101', 'nombre' => 'Programación Web', 'creditos' => 4],
            ['codigo' => 'SIS-102', 'nombre' => 'Bases de Datos', 'creditos' => 4],
            ['codigo' => 'SIS-103', 'nombre' => 'Redes de Computadores', 'creditos' => 3],
            ['codigo' => 'MAT-201', 'nombre' => 'Cálculo Multivariable', 'creditos' => 4],
            ['codigo' => 'FIS-202', 'nombre' => 'Electromagnetismo', 'creditos' => 3],
            ['codigo' => 'SIS-104', 'nombre' => 'Ingeniería de Software', 'creditos' => 4],
            ['codigo' => 'SIS-105', 'nombre' => 'Sistemas Operativos', 'creditos' => 3],
            ['codigo' => 'SIS-106', 'nombre' => 'Programación Orientada a Objetos', 'creditos' => 4],
            ['codigo' => 'SIS-107', 'nombre' => 'Estructuras de Datos', 'creditos' => 4],
            ['codigo' => 'SIS-108', 'nombre' => 'Arquitectura de Computadores', 'creditos' => 3],
            ['codigo' => 'MAT-202', 'nombre' => 'Estadística y Probabilidad', 'creditos' => 3],
            ['codigo' => 'MAT-203', 'nombre' => 'Álgebra Lineal', 'creditos' => 3],
            ['codigo' => 'SIS-109', 'nombre' => 'Inteligencia Artificial', 'creditos' => 4],
            ['codigo' => 'SIS-110', 'nombre' => 'Seguridad Informática', 'creditos' => 3],
            ['codigo' => 'SIS-111', 'nombre' => 'Desarrollo Móvil', 'creditos' => 4],
            ['codigo' => 'SIS-112', 'nombre' => 'Desarrollo de Aplicaciones Web', 'creditos' => 4],
            ['codigo' => 'SIS-113', 'nombre' => 'Computación en la Nube', 'creditos' => 3],
            ['codigo' => 'SIS-114', 'nombre' => 'Análisis de Algoritmos', 'creditos' => 3],
            ['codigo' => 'SIS-115', 'nombre' => 'Gestión de Proyectos', 'creditos' => 3],
            ['codigo' => 'SIS-116', 'nombre' => 'Interacción Humano Computador', 'creditos' => 3],
            ['codigo' => 'SIS-117', 'nombre' => 'Inteligencia de Negocios', 'creditos' => 3],
            ['codigo' => 'SIS-118', 'nombre' => 'Sistemas Distribuidos', 'creditos' => 4],
            ['codigo' => 'SIS-119', 'nombre' => 'Desarrollo de Software Seguro', 'creditos' => 3],
            ['codigo' => 'SIS-120', 'nombre' => 'Fundamentos de Electrónica', 'creditos' => 3],
            ['codigo' => 'HUM-101', 'nombre' => 'Ética Profesional', 'creditos' => 2],
        ];

        $asignaturas = collect();

        foreach ($nombresAsignaturas as $datos) {
            $asignaturas->push(
                Asignatura::firstOrCreate(
                    ['codigo' => $datos['codigo']],
                    [
                        'nombre' => $datos['nombre'],
                        'creditos' => $datos['creditos'],
                    ]
                )
            );
        }

        // 3. Crear tres grupos por asignatura: 75 grupos
        $nombresGrupos = [
            'Grupo A - Mañana',
            'Grupo B - Tarde',
            'Grupo C - Noche',
        ];

        $grupos = collect();

        foreach ($asignaturas as $asignatura) {
            foreach ($nombresGrupos as $nombreGrupo) {
                $grupos->push(
                    Grupo::firstOrCreate(
                        [
                            'asignatura_id' => $asignatura->id,
                            'nombre_grupo' => $nombreGrupo,
                        ],
                        [
                            'cupo_maximo' => 30,
                        ]
                    )
                );
            }
        }

        // 4. Crear 500 estudiantes y sus usuarios asociados
        $estudiantes = Estudiante::factory()
            ->count(500)
            ->create();

        // 5. Inicializar ocupación de los grupos
        $ocupacionGrupos = $grupos->mapWithKeys(function ($grupo) {
            return [
                $grupo->id => $grupo->matriculas()->count(),
            ];
        });

        // 6. Crear una matrícula por estudiante
        foreach ($estudiantes as $estudiante) {
            $matricula = Matricula::factory()->create([
                'estudiante_id' => $estudiante->id,
            ]);

            // Las matrículas canceladas no reciben grupos
            if ($matricula->estado === 'cancelada') {
                continue;
            }

            // Cada estudiante cursará entre 2 y 3 asignaturas diferentes
            $cantidadGrupos = fake()->numberBetween(2, 3);

            $asignaturasElegidas = $asignaturas
                ->shuffle()
                ->take($cantidadGrupos);

            $gruposElegidos = [];

            foreach ($asignaturasElegidas as $asignatura) {

                // Buscar un grupo de la asignatura con capacidad disponible
                $grupo = $grupos
                    ->where('asignatura_id', $asignatura->id)
                    ->filter(function ($grupo) use ($ocupacionGrupos) {
                        return $ocupacionGrupos[$grupo->id] < $grupo->cupo_maximo;
                    })
                    ->sortBy(function ($grupo) use ($ocupacionGrupos) {
                        return $ocupacionGrupos[$grupo->id];
                    })
                    ->first();

                if ($grupo) {
                     $gruposElegidos[] = $grupo->id;

                    // Actualizar ocupación en memoria
                     $ocupacionGrupos->put(
                    $grupo->id,
                     $ocupacionGrupos->get($grupo->id) + 1
    );
}
            }

            // Asociar grupos a la matrícula
            if (!empty($gruposElegidos)) {
                $matricula->grupos()->attach($gruposElegidos);
            }
        }

        $this->command->info('Base de datos poblada correctamente.');
        $this->command->info('Administrador: 1');
        $this->command->info('Estudiantes: '.$estudiantes->count());
        $this->command->info('Asignaturas: '.$asignaturas->count());
        $this->command->info('Grupos: '.$grupos->count());
        $this->command->info('Matrículas: '.$estudiantes->count());
    }
}

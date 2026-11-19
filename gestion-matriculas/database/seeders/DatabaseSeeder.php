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
        // 1. Administrador
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

        // 2. Asignaturas
        $asignaturas = [
            Asignatura::firstOrCreate(
                ['codigo' => 'SIS-101'],
                ['nombre' => 'Programación Web', 'creditos' => 4]
            ),

            Asignatura::firstOrCreate(
                ['codigo' => 'SIS-102'],
                ['nombre' => 'Bases de Datos', 'creditos' => 4]
            ),

            Asignatura::firstOrCreate(
                ['codigo' => 'SIS-103'],
                ['nombre' => 'Redes de Computadores', 'creditos' => 3]
            ),

            Asignatura::firstOrCreate(
                ['codigo' => 'MAT-201'],
                ['nombre' => 'Cálculo Multivariable', 'creditos' => 4]
            ),

            Asignatura::firstOrCreate(
                ['codigo' => 'FIS-202'],
                ['nombre' => 'Electromagnetismo', 'creditos' => 3]
            ),
        ];

        // 3. Grupos
        $grupos = [
            Grupo::firstOrCreate(
                [
                    'asignatura_id' => $asignaturas[0]->id,
                    'nombre_grupo' => 'Grupo A - Mañana',
                ],
                ['cupo_maximo' => 25]
            ),

            Grupo::firstOrCreate(
                [
                    'asignatura_id' => $asignaturas[1]->id,
                    'nombre_grupo' => 'Grupo B - Tarde',
                ],
                ['cupo_maximo' => 20]
            ),

            Grupo::firstOrCreate(
                [
                    'asignatura_id' => $asignaturas[2]->id,
                    'nombre_grupo' => 'Grupo A - Noche',
                ],
                ['cupo_maximo' => 25]
            ),

            Grupo::firstOrCreate(
                [
                    'asignatura_id' => $asignaturas[3]->id,
                    'nombre_grupo' => 'Grupo C - Mañana',
                ],
                ['cupo_maximo' => 30]
            ),

            Grupo::firstOrCreate(
                [
                    'asignatura_id' => $asignaturas[4]->id,
                    'nombre_grupo' => 'Grupo ÚNICO - Sábado',
                ],
                ['cupo_maximo' => 20]
            ),
        ];

        // 4. Estudiantes de prueba
        $listaEstudiantes = [
            [
                'doc' => '1001',
                'nombres' => 'Juan David',
                'apellidos' => 'Martínez',
                'email' => 'juan@edugestion.com',
                'nac' => '2005-03-12',
            ],
            [
                'doc' => '1002',
                'nombres' => 'María Camila',
                'apellidos' => 'Rodríguez',
                'email' => 'maria@edugestion.com',
                'nac' => '2006-07-24',
            ],
            [
                'doc' => '1003',
                'nombres' => 'Andrés Felipe',
                'apellidos' => 'López',
                'email' => 'andres@edugestion.com',
                'nac' => '2004-11-05',
            ],
            [
                'doc' => '1004',
                'nombres' => 'Valentina',
                'apellidos' => 'Hernández',
                'email' => 'valentina@edugestion.com',
                'nac' => '2005-09-18',
            ],
            [
                'doc' => '1005',
                'nombres' => 'Sebastián',
                'apellidos' => 'Castro',
                'email' => 'sebastian@edugestion.com',
                'nac' => '2006-01-30',
            ],
        ];

        foreach ($listaEstudiantes as $index => $est) {

            $user = User::updateOrCreate(
                ['email' => $est['email']],
                [
                    'name' => $est['nombres'].' '.$est['apellidos'],
                    'role' => 'estudiante',
                    'password' => '12345678',
                ]
            );

            // Las cuentas de demostración quedan verificadas.
            $user->forceFill([
                'email_verified_at' => now(),
            ])->save();

            $estudiante = Estudiante::updateOrCreate(
                ['documento_identidad' => $est['doc']],
                [
                    'user_id' => $user->id,
                    'nombres' => $est['nombres'],
                    'apellidos' => $est['apellidos'],
                    'correo' => $est['email'],
                    'fecha_nacimiento' => $est['nac'],
                ]
            );

            $matricula = Matricula::firstOrCreate(
                [
                    'estudiante_id' => $estudiante->id,
                    'periodo_academico' => '2026-2',
                ],
                [
                    'fecha_matricula' => now()->toDateString(),
                    'estado' => 'activa',
                ]
            );

            $matricula->grupos()->syncWithoutDetaching([
                $grupos[$index % 5]->id,
                $grupos[($index + 1) % 5]->id,
            ]);
        }
    }
}
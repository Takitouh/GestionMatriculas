<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Asignatura;
use App\Models\Grupo;
use App\Models\Matricula;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.index', [
            'totalEstudiantes' => Estudiante::count(),
            'totalAsignaturas' => Asignatura::count(),
            'totalGrupos'      => Grupo::count(),
            'totalMatriculas'  => Matricula::count(),
        ]);
    }
}
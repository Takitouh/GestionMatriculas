<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Asignatura;
use App\Models\Grupo;
use App\Models\Matricula;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $totalEstudiantes = Estudiante::count();
        $totalAsignaturas = Asignatura::count();
        $totalGrupos = Grupo::count();
        $totalMatriculas = Matricula::count();

        $matriculasActivas = Matricula::where('estado', 'activa')->count();
        $matriculasCanceladas = Matricula::where('estado', 'cancelada')->count();

        $cuposTotales = Grupo::sum('cupo_maximo');

        $cuposOcupados = DB::table('grupo_matricula')
            ->join('matriculas', 'grupo_matricula.matricula_id', '=', 'matriculas.id')
            ->where('matriculas.estado', 'activa')
            ->count();

        $porcentajeOcupacion = $cuposTotales > 0
            ? round(($cuposOcupados / $cuposTotales) * 100, 1)
            : 0;

        $periodoDestacado = Matricula::where('estado', 'activa')
            ->select('periodo_academico')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('periodo_academico')
            ->orderByDesc('total')
            ->first();

        return view('home.index', compact(
            'totalEstudiantes',
            'totalAsignaturas',
            'totalGrupos',
            'totalMatriculas',
            'matriculasActivas',
            'matriculasCanceladas',
            'cuposTotales',
            'cuposOcupados',
            'porcentajeOcupacion',
            'periodoDestacado'
        ));
    }
}

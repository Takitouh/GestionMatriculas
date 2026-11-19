<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Asignatura;
use App\Models\Grupo;
use App\Models\Matricula;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class PanelAcademicoController extends Controller
{
    public function index(Request $request)
{
    // Opciones permitidas de paginación
    $opcionesPorPagina = [5, 10, 15, 25, 50];

    $porPagina = (int) $request->query('per_page', 10);

    if (!in_array($porPagina, $opcionesPorPagina, true)) {
        $porPagina = 10;
    }

    // Estadísticas generales
    $totalMatriculas = Matricula::count();

    $matriculasActivas = Matricula::whereRaw('LOWER(estado) = ?', ['activa'])->count();

    $matriculasCanceladas = Matricula::whereRaw('LOWER(estado) = ?', ['cancelada'])->count();

    // Ocupación
    $cuposTotales = Grupo::sum('cupo_maximo');

    $cuposOcupados = DB::table('grupo_matricula')
        ->join('matriculas', 'grupo_matricula.matricula_id', '=', 'matriculas.id')
        ->whereRaw('LOWER(matriculas.estado) = ?', ['activa'])
        ->count();

    $cuposDisponibles = max(0, $cuposTotales - $cuposOcupados);

    $porcentajeOcupacion = $cuposTotales > 0
        ? round(($cuposOcupados / $cuposTotales) * 100, 1)
        : 0;

    // Periodo destacado
    $periodoDestacado = Matricula::whereRaw('LOWER(estado) = ?', ['activa'])
        ->select('periodo_academico')
        ->selectRaw('COUNT(*) as total')
        ->groupBy('periodo_academico')
        ->orderByDesc('total')
        ->first();

    // Matrículas con estudiantes, grupos y asignaturas
    $matriculasRecientes = Matricula::with([
        'estudiante',
        'grupos.asignatura'
    ])
        ->orderByDesc('fecha_matricula')
        ->orderByDesc('id')
        ->paginate($porPagina)
        ->appends(['per_page' => $porPagina]);

    return view('panel-academico.index', compact(
        'totalMatriculas',
        'matriculasActivas',
        'matriculasCanceladas',
        'cuposTotales',
        'cuposOcupados',
        'cuposDisponibles',
        'porcentajeOcupacion',
        'periodoDestacado',
        'matriculasRecientes',
        'porPagina'
    ));
}
}

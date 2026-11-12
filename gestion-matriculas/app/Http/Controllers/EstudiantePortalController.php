<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\Matricula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EstudiantePortalController extends Controller
{
    private const PERIODO_ACTUAL = '2026-2';
    private const MAX_CREDITOS = 20;

    public function index(Request $request)
    {
        $user = Auth::user();
        $estudiante = $user->estudiante;

        if (!$estudiante) {
            return redirect()->route('home')->with('error', 'Esta cuenta no tiene un perfil de estudiante asociado.');
        }

        // Busca la matrícula del periodo actual (o la más reciente)
        $matriculaActual = $estudiante->matriculas()
            ->with(['grupos.asignatura'])
            ->where('periodo_academico', self::PERIODO_ACTUAL)
            ->first()
            ?? $estudiante->matriculas()->with(['grupos.asignatura'])->latest()->first();

        $gruposMatriculados = $matriculaActual ? $matriculaActual->grupos : collect();
        $totalCreditos = $gruposMatriculados->sum(fn($g) => $g->asignatura->creditos ?? 0);

        // IDs para marcar en la interfaz qué grupos o asignaturas ya inscribió
        $gruposInscritosIds = $gruposMatriculados->pluck('id')->toArray();
        $asignaturasInscritasIds = $gruposMatriculados->pluck('asignatura_id')->toArray();

        // Oferta académica con buscador
        $busqueda = $request->input('buscar');
        $gruposDisponibles = Grupo::with('asignatura')
            ->withCount('matriculas')
            ->when($busqueda, function ($query, $busqueda) {
                $query->whereHas('asignatura', function ($q) use ($busqueda) {
                    $q->where('nombre', 'like', "%{$busqueda}%")
                      ->orWhere('codigo', 'like', "%{$busqueda}%");
                })->orWhere('docente', 'like', "%{$busqueda}%");
            })
            ->get();

        return view('estudiante.dashboard', [
            'estudiante'              => $estudiante,
            'matriculaActual'         => $matriculaActual,
            'gruposMatriculados'      => $gruposMatriculados,
            'totalCreditos'           => $totalCreditos,
            'maxCreditos'             => self::MAX_CREDITOS,
            'gruposDisponibles'       => $gruposDisponibles,
            'gruposInscritosIds'      => $gruposInscritosIds,
            'asignaturasInscritasIds' => $asignaturasInscritasIds,
            'busqueda'                => $busqueda,
            'periodoActual'           => self::PERIODO_ACTUAL,
        ]);
    }

    public function matricular(Grupo $grupo)
    {
        $estudiante = Auth::user()->estudiante;
        $grupo->loadMissing('asignatura')->loadCount('matriculas');

        // 1. Validar cupos disponibles
        if ($grupo->cuposDisponibles() <= 0) {
            return back()->with('error', 'El grupo seleccionado ya no tiene cupos disponibles.');
        }

        return DB::transaction(function () use ($estudiante, $grupo) {
            // Obtener o crear la matrícula activa del periodo
            $matricula = Matricula::firstOrCreate(
                [
                    'estudiante_id'     => $estudiante->id,
                    'periodo_academico' => self::PERIODO_ACTUAL,
                ],
                [
                    'fecha_matricula' => now()->toDateString(),
                    'estado'          => 'Activa',
                ]
            );

            $gruposActuales = $matricula->grupos()->with('asignatura')->get();

            // 2. Validar que no esté inscrito en el mismo grupo
            if ($gruposActuales->contains('id', $grupo->id)) {
                return back()->with('error', 'Ya te encuentras matriculado en este grupo.');
            }

            // 3. Validar que no inscriba otro grupo de la misma asignatura
            if ($gruposActuales->contains('asignatura_id', $grupo->asignatura_id)) {
                return back()->with('error', 'Ya tienes inscrito otro grupo de la asignatura ' . ($grupo->asignatura->nombre ?? '') . '.');
            }

            // 4. Validar cruce exacto de horario (si ambos tienen horario definido)
            if (!empty($grupo->horario) && $gruposActuales->contains('horario', $grupo->horario)) {
                return back()->with('error', 'Cruce de horario detectado (' . $grupo->horario . ') con una materia ya inscrita.');
            }

            // 5. Validar límite máximo de créditos
            $creditosActuales = $gruposActuales->sum(fn($g) => $g->asignatura->creditos ?? 0);
            $creditosNuevos = $grupo->asignatura->creditos ?? 0;

            if (($creditosActuales + $creditosNuevos) > self::MAX_CREDITOS) {
                return back()->with('error', 'Superas el límite máximo de ' . self::MAX_CREDITOS . ' créditos permitidos por periodo.');
            }

            $matricula->grupos()->attach($grupo->id);

            return back()->with('success', 'Grupo inscrito correctamente en tu matrícula.');
        });
    }

    public function retirar(Grupo $grupo)
    {
        $estudiante = Auth::user()->estudiante;

        $matricula = $estudiante->matriculas()
            ->where('periodo_academico', self::PERIODO_ACTUAL)
            ->first();

        if ($matricula) {
            $matricula->grupos()->detach($grupo->id);
        }

        return back()->with('success', 'El grupo fue retirado de tu matrícula.');
    }

    public function comprobante()
    {
        $estudiante = Auth::user()->estudiante;

        $matriculaActual = $estudiante->matriculas()
            ->with(['grupos.asignatura'])
            ->where('periodo_academico', self::PERIODO_ACTUAL)
            ->first()
            ?? $estudiante->matriculas()->with(['grupos.asignatura'])->latest()->first();

        $gruposMatriculados = $matriculaActual ? $matriculaActual->grupos : collect();
        $totalCreditos = $gruposMatriculados->sum(fn($g) => $g->asignatura->creditos ?? 0);

        return view('estudiante.comprobante', compact(
            'estudiante',
            'matriculaActual',
            'gruposMatriculados',
            'totalCreditos'
        ));
    }
}
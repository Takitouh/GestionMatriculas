<?php

namespace App\Http\Controllers;

use App\Models\Matricula;
use App\Models\Estudiante;
use App\Models\Grupo;
use App\Http\Requests\StoreMatriculaRequest;
use App\Http\Requests\UpdateMatriculaRequest;
use Illuminate\Http\Request;

class MatriculaController extends Controller
{
    public function index(Request $request)
{
    $opcionesPorPagina = [5, 10, 15, 25, 50];

    $porPagina = (int) $request->query('per_page', 10);

    if (!in_array($porPagina, $opcionesPorPagina, true)) {
        $porPagina = 10;
    }

    $matriculas = Matricula::with([
        'estudiante',
        'grupos.asignatura'
    ])
        ->latest()
        ->paginate($porPagina)
        ->appends(['per_page' => $porPagina]);

    return view('matriculas.index', compact(
        'matriculas',
        'porPagina'
    ));
}

    public function create()
    {
        $estudiantes = Estudiante::orderBy('apellidos')->get();
        // Traemos los grupos con su asignatura para mostrar el nombre completo
        $grupos = Grupo::with('asignatura')->get()->sortBy(function($grupo) {
            return $grupo->asignatura->nombre;
        });
        
        return view('matriculas.create', compact('estudiantes', 'grupos'));
    }

    public function store(StoreMatriculaRequest $request)
    {
        // Creamos la matrícula sin el arreglo de grupos
        $matricula = Matricula::create($request->safe()->except('grupos'));
        
        // Sincronizamos los grupos en la tabla pivote (grupo_matricula)
        $matricula->grupos()->sync($request->grupos);
        
        return redirect()->route('matriculas.index')->with('success', 'Matrícula registrada exitosamente.');
    }

    public function edit(Matricula $matricula)
    {
        $estudiantes = Estudiante::orderBy('apellidos')->get();
        $grupos = Grupo::with('asignatura')->get()->sortBy(function($grupo) {
            return $grupo->asignatura->nombre;
        });
        
        return view('matriculas.edit', compact('matricula', 'estudiantes', 'grupos'));
    }

    public function update(UpdateMatriculaRequest $request, Matricula $matricula)
    {
        $matricula->update($request->safe()->except('grupos'));
        
        // Actualizamos la tabla pivote de manera automática
        $matricula->grupos()->sync($request->grupos);
        
        return redirect()->route('matriculas.index')->with('success', 'Matrícula actualizada correctamente.');
    }

    public function destroy(Matricula $matricula)
    {
        $matricula->delete(); // Gracias al cascade on delete de la migración, se borra de la tabla pivote también
        return redirect()->route('matriculas.index')->with('success', 'Matrícula eliminada del sistema.');
    }
}
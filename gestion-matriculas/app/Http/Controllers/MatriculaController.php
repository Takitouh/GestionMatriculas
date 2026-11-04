<?php

namespace App\Http\Controllers;

use App\Models\Matricula;
use App\Models\Estudiante;
use App\Models\Grupo;
use App\Http\Requests\StoreMatriculaRequest;
use App\Http\Requests\UpdateMatriculaRequest;

class MatriculaController extends Controller
{
    public function index()
    {
        // Traemos las matrículas con sus relaciones para evitar consultas N+1
        $matriculas = Matricula::with(['estudiante', 'grupos'])->latest()->paginate(10);
        return view('matriculas.index', compact('matriculas'));
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
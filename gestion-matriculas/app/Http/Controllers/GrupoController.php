<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\Asignatura;
use App\Http\Requests\StoreGrupoRequest;
use App\Http\Requests\UpdateGrupoRequest;

class GrupoController extends Controller
{
    public function index()
    {
        // Eager loading de la relación 'asignatura' para optimizar la base de datos
        $grupos = Grupo::with('asignatura')->latest()->paginate(10);
        return view('grupos.index', compact('grupos'));
    }

    public function create()
    {
        $asignaturas = Asignatura::orderBy('nombre')->get();
        return view('grupos.create', compact('asignaturas'));
    }

    public function store(StoreGrupoRequest $request)
    {
        Grupo::create($request->validated());
        return redirect()->route('grupos.index')->with('success', 'Grupo creado correctamente.');
    }

    public function edit(Grupo $grupo)
    {
        $asignaturas = Asignatura::orderBy('nombre')->get();
        return view('grupos.edit', compact('grupo', 'asignaturas'));
    }

    public function update(UpdateGrupoRequest $request, Grupo $grupo)
    {
        $grupo->update($request->validated());
        return redirect()->route('grupos.index')->with('success', 'Grupo actualizado correctamente.');
    }

    public function destroy(Grupo $grupo)
    {
        $grupo->delete();
        return redirect()->route('grupos.index')->with('success', 'Grupo eliminado del sistema.');
    }
}
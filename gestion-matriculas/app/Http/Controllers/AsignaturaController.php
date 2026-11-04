<?php

namespace App\Http\Controllers;

use App\Models\Asignatura;
use App\Http\Requests\StoreAsignaturaRequest;
use App\Http\Requests\UpdateAsignaturaRequest;

class AsignaturaController extends Controller
{
    public function index()
    {
        $asignaturas = Asignatura::latest()->paginate(10);
        return view('asignaturas.index', compact('asignaturas'));
    }

    public function create()
    {
        return view('asignaturas.create');
    }

    public function store(StoreAsignaturaRequest $request)
    {
        Asignatura::create($request->validated());
        return redirect()->route('asignaturas.index')->with('success', 'Asignatura creada correctamente.');
    }

    public function edit(Asignatura $asignatura)
    {
        return view('asignaturas.edit', compact('asignatura'));
    }

    public function update(UpdateAsignaturaRequest $request, Asignatura $asignatura)
    {
        $asignatura->update($request->validated());
        return redirect()->route('asignaturas.index')->with('success', 'Asignatura actualizada correctamente.');
    }

    public function destroy(Asignatura $asignatura)
    {
        $asignatura->delete();
        return redirect()->route('asignaturas.index')->with('success', 'Asignatura eliminada del sistema.');
    }
}
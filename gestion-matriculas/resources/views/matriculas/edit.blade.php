@extends('layouts.app')

@section('title', 'Editar Matrícula - EduGestión')

@section('content')
<div class="mb-6 flex items-center gap-4">
    <a href="{{ route('matriculas.index') }}" class="text-slate-400 hover:text-slate-600 transition-colors">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
    </a>
    <h2 class="text-2xl font-bold text-slate-800">Editar Matrícula</h2>
</div>

<form action="{{ route('matriculas.update', $matricula) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Columna Izquierda -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-bold text-slate-800 mb-4 border-b border-slate-100 pb-2">Datos de la Matrícula</h3>
                
                <div class="space-y-4">
                    <!-- Estudiante -->
                    <div>
                        <label for="estudiante_id" class="block text-sm font-medium text-slate-700 mb-1">Estudiante <span class="text-red-500">*</span></label>
                        <select name="estudiante_id" id="estudiante_id" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2 border bg-white @error('estudiante_id') border-red-500 @enderror">
                            @foreach($estudiantes as $estudiante)
                                <option value="{{ $estudiante->id }}" {{ old('estudiante_id', $matricula->estudiante_id) == $estudiante->id ? 'selected' : '' }}>
                                    {{ $estudiante->apellidos }}, {{ $estudiante->nombres }}
                                </option>
                            @endforeach
                        </select>
                        @error('estudiante_id') <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Periodo -->
                    <div>
                        <label for="periodo_academico" class="block text-sm font-medium text-slate-700 mb-1">Periodo Académico <span class="text-red-500">*</span></label>
                        <input type="text" name="periodo_academico" id="periodo_academico" value="{{ old('periodo_academico', $matricula->periodo_academico) }}" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2 border @error('periodo_academico') border-red-500 @enderror">
                        @error('periodo_academico') <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Fecha -->
                    <div>
                        <label for="fecha_matricula" class="block text-sm font-medium text-slate-700 mb-1">Fecha de Matrícula <span class="text-red-500">*</span></label>
                        <input type="date" name="fecha_matricula" id="fecha_matricula" value="{{ old('fecha_matricula', $matricula->fecha_matricula) }}" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2 border @error('fecha_matricula') border-red-500 @enderror">
                        @error('fecha_matricula') <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Estado -->
                    <div>
                        <label for="estado" class="block text-sm font-medium text-slate-700 mb-1">Estado <span class="text-red-500">*</span></label>
                        <select name="estado" id="estado" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2 border bg-white @error('estado') border-red-500 @enderror">
                            <option value="activa" {{ old('estado', $matricula->estado) == 'activa' ? 'selected' : '' }}>Activa</option>
                            <option value="cancelada" {{ old('estado', $matricula->estado) == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                        </select>
                        @error('estado') <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Columna Derecha: Selección de Grupos -->
        <div class="lg:col-span-2">
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-6 h-full">
                <h3 class="text-lg font-bold text-slate-800 mb-1 border-b border-slate-100 pb-2">Selección de Grupos <span class="text-red-500">*</span></h3>
                <p class="text-sm text-slate-500 mb-4">Modifica las materias inscritas.</p>
                
                @error('grupos') 
                    <div class="mb-4 p-3 bg-red-50 text-red-700 border border-red-200 rounded-lg text-sm">{{ $message }}</div> 
                @enderror

                @php
                    // Obtenemos los IDs de los grupos ya guardados en BD para chequearlos por defecto
                    $gruposSeleccionados = old('grupos', $matricula->grupos->pluck('id')->toArray());
                @endphp

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 max-h-[400px] overflow-y-auto pr-2">
                    @foreach($grupos as $grupo)
                        <label class="flex items-start space-x-3 p-3 border border-slate-200 rounded-lg hover:bg-slate-50 cursor-pointer transition-colors {{ in_array($grupo->id, $gruposSeleccionados) ? 'bg-indigo-50 border-indigo-200' : '' }}">
                            <input type="checkbox" name="grupos[]" value="{{ $grupo->id }}" class="mt-1 w-4 h-4 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500" {{ in_array($grupo->id, $gruposSeleccionados) ? 'checked' : '' }}>
                            <div>
                                <p class="text-sm font-bold text-slate-800">{{ $grupo->asignatura->nombre }}</p>
                                <p class="text-xs text-slate-500">Grupo: {{ $grupo->nombre_grupo }} (Cupos: {{ $grupo->cupo_maximo }})</p>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6 flex justify-end gap-3">
        <a href="{{ route('matriculas.index') }}" class="bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 px-5 py-2.5 rounded-lg font-medium text-sm transition-colors">Cancelar</a>
        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg font-medium text-sm transition-colors shadow-sm">
            Actualizar Matrícula
        </button>
    </div>
</form>
@endsection
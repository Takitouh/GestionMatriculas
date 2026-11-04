@extends('layouts.app')

@section('title', 'Editar Grupo - EduGestión')

@section('content')
<div class="mb-6 flex items-center gap-4">
    <a href="{{ route('grupos.index') }}" class="text-slate-400 hover:text-slate-600 transition-colors">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
    </a>
    <h2 class="text-2xl font-bold text-slate-800">Editar Grupo</h2>
</div>

<div class="bg-white border border-slate-200 rounded-xl shadow-sm max-w-3xl">
    <form action="{{ route('grupos.update', $grupo) }}" method="POST" class="p-6 md:p-8">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Asignatura (Select) -->
            <div class="md:col-span-2">
                <label for="asignatura_id" class="block text-sm font-medium text-slate-700 mb-1">Asignatura <span class="text-red-500">*</span></label>
                <select name="asignatura_id" id="asignatura_id" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2 border bg-white @error('asignatura_id') border-red-500 @enderror">
                    @foreach($asignaturas as $asignatura)
                        <option value="{{ $asignatura->id }}" {{ old('asignatura_id', $grupo->asignatura_id) == $asignatura->id ? 'selected' : '' }}>
                            {{ $asignatura->codigo }} - {{ $asignatura->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('asignatura_id') <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Nombre del Grupo -->
            <div>
                <label for="nombre_grupo" class="block text-sm font-medium text-slate-700 mb-1">Nombre/Código del Grupo <span class="text-red-500">*</span></label>
                <input type="text" name="nombre_grupo" id="nombre_grupo" value="{{ old('nombre_grupo', $grupo->nombre_grupo) }}" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2 border @error('nombre_grupo') border-red-500 @enderror">
                @error('nombre_grupo') <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Cupo Máximo -->
            <div>
                <label for="cupo_maximo" class="block text-sm font-medium text-slate-700 mb-1">Cupo Máximo <span class="text-red-500">*</span></label>
                <input type="number" name="cupo_maximo" id="cupo_maximo" value="{{ old('cupo_maximo', $grupo->cupo_maximo) }}" min="1" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2 border @error('cupo_maximo') border-red-500 @enderror">
                @error('cupo_maximo') <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="mt-8 pt-6 border-t border-slate-100 flex justify-end gap-3">
            <a href="{{ route('grupos.index') }}" class="bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 px-5 py-2.5 rounded-lg font-medium text-sm transition-colors">Cancelar</a>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg font-medium text-sm transition-colors shadow-sm">
                Actualizar Grupo
            </button>
        </div>
    </form>
</div>
@endsection
@extends('layouts.app')

@section('title', 'Editar Asignatura - EduGestión')

@section('content')
<div class="mb-6 flex items-center gap-4">
    <a href="{{ route('asignaturas.index') }}" class="text-slate-400 hover:text-slate-600 transition-colors">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
    </a>
    <h2 class="text-2xl font-bold text-slate-800">Editar Asignatura</h2>
</div>

<div class="bg-white border border-slate-200 rounded-xl shadow-sm max-w-3xl">
    <form action="{{ route('asignaturas.update', $asignatura) }}" method="POST" class="p-6 md:p-8">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Código -->
            <div>
                <label for="codigo" class="block text-sm font-medium text-slate-700 mb-1">Código de Asignatura <span class="text-red-500">*</span></label>
                <input type="text" name="codigo" id="codigo" value="{{ old('codigo', $asignatura->codigo) }}" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2 border @error('codigo') border-red-500 @enderror">
                @error('codigo') <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Créditos -->
            <div>
                <label for="creditos" class="block text-sm font-medium text-slate-700 mb-1">Número de Créditos <span class="text-red-500">*</span></label>
                <input type="number" name="creditos" id="creditos" value="{{ old('creditos', $asignatura->creditos) }}" min="1" max="10" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2 border @error('creditos') border-red-500 @enderror">
                @error('creditos') <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Nombre -->
            <div class="md:col-span-2">
                <label for="nombre" class="block text-sm font-medium text-slate-700 mb-1">Nombre de la Asignatura <span class="text-red-500">*</span></label>
                <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $asignatura->nombre) }}" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2 border @error('nombre') border-red-500 @enderror">
                @error('nombre') <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="mt-8 pt-6 border-t border-slate-100 flex justify-end gap-3">
            <a href="{{ route('asignaturas.index') }}" class="bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 px-5 py-2.5 rounded-lg font-medium text-sm transition-colors">Cancelar</a>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg font-medium text-sm transition-colors shadow-sm">
                Actualizar Asignatura
            </button>
        </div>
    </form>
</div>
@endsection
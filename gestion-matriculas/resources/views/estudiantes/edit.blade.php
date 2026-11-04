@extends('layouts.app')

@section('title', 'Editar Estudiante - EduGestión')

@section('content')
<div class="mb-6 flex items-center gap-4">
    <a href="{{ route('estudiantes.index') }}" class="text-slate-400 hover:text-slate-600 transition-colors">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
    </a>
    <h2 class="text-2xl font-bold text-slate-800">Editar Estudiante</h2>
</div>

<div class="bg-white border border-slate-200 rounded-xl shadow-sm max-w-3xl">
    <form action="{{ route('estudiantes.update', $estudiante) }}" method="POST" class="p-6 md:p-8">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Documento -->
            <div>
                <label for="documento_identidad" class="block text-sm font-medium text-slate-700 mb-1">Documento de Identidad <span class="text-red-500">*</span></label>
                <input type="text" name="documento_identidad" id="documento_identidad" value="{{ old('documento_identidad', $estudiante->documento_identidad) }}" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2 border @error('documento_identidad') border-red-500 @enderror">
                @error('documento_identidad') <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Nombres -->
            <div>
                <label for="nombres" class="block text-sm font-medium text-slate-700 mb-1">Nombres <span class="text-red-500">*</span></label>
                <input type="text" name="nombres" id="nombres" value="{{ old('nombres', $estudiante->nombres) }}" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2 border @error('nombres') border-red-500 @enderror">
                @error('nombres') <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Apellidos -->
            <div>
                <label for="apellidos" class="block text-sm font-medium text-slate-700 mb-1">Apellidos <span class="text-red-500">*</span></label>
                <input type="text" name="apellidos" id="apellidos" value="{{ old('apellidos', $estudiante->apellidos) }}" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2 border @error('apellidos') border-red-500 @enderror">
                @error('apellidos') <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Correo -->
            <div>
                <label for="correo" class="block text-sm font-medium text-slate-700 mb-1">Correo Electrónico <span class="text-red-500">*</span></label>
                <input type="email" name="correo" id="correo" value="{{ old('correo', $estudiante->correo) }}" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2 border @error('correo') border-red-500 @enderror">
                @error('correo') <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- Fecha de Nacimiento -->
            <div>
                <label for="fecha_nacimiento" class="block text-sm font-medium text-slate-700 mb-1">Fecha de Nacimiento <span class="text-red-500">*</span></label>
                <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" value="{{ old('fecha_nacimiento', $estudiante->fecha_nacimiento) }}" class="w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2 border @error('fecha_nacimiento') border-red-500 @enderror">
                @error('fecha_nacimiento') <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="mt-8 pt-6 border-t border-slate-100 flex justify-end gap-3">
            <a href="{{ route('estudiantes.index') }}" class="bg-white border border-slate-300 text-slate-700 hover:bg-slate-50 px-5 py-2.5 rounded-lg font-medium text-sm transition-colors">Cancelar</a>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg font-medium text-sm transition-colors shadow-sm">
                Actualizar Estudiante
            </button>
        </div>
    </form>
</div>
@endsection
@extends('layouts.app')

@section('title', 'Grupos - EduGestión')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Gestión de Grupos</h2>
        <p class="text-slate-500 text-sm mt-1">Administra los grupos y cupos por asignatura.</p>
    </div>
    <a href="{{ route('grupos.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg font-medium text-sm transition-colors shadow-sm flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
        Nuevo Grupo
    </a>
</div>

@if(session('success'))
<div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-3">
    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    {{ session('success') }}
</div>
@endif

<div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead class="bg-slate-50 border-b border-slate-200 text-slate-600">
                <tr>
                    <th class="px-6 py-4 font-semibold">Grupo</th>
                    <th class="px-6 py-4 font-semibold">Asignatura</th>
                    <th class="px-6 py-4 font-semibold">Cupo Máximo</th>
                    <th class="px-6 py-4 font-semibold text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($grupos as $grupo)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4 text-slate-800 font-bold">{{ $grupo->nombre_grupo }}</td>
                    <td class="px-6 py-4 text-slate-600">
                        <span class="block text-xs text-slate-400">{{ $grupo->asignatura->codigo }}</span>
                        {{ $grupo->asignatura->nombre }}
                    </td>
                    <td class="px-6 py-4 text-slate-500">
                        <span class="bg-violet-100 text-violet-700 px-2.5 py-0.5 rounded-full text-xs font-semibold">
                            {{ $grupo->cupo_maximo }} estudiantes
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('grupos.edit', $grupo) }}" class="text-blue-600 hover:text-blue-800 font-medium">Editar</a>
                            <form action="{{ route('grupos.destroy', $grupo) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro de eliminar este grupo?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Eliminar</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-10 text-center text-slate-500">
                        No hay grupos registrados en el sistema.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($grupos->hasPages())
    <div class="px-6 py-4 border-t border-slate-200">
        {{ $grupos->links() }}
    </div>
    @endif
</div>
@endsection
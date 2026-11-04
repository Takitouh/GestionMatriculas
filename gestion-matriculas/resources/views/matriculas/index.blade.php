@extends('layouts.app')

@section('title', 'Matrículas - EduGestión')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Control de Matrículas</h2>
        <p class="text-slate-500 text-sm mt-1">Gestiona las inscripciones académicas de los estudiantes.</p>
    </div>
    <a href="{{ route('matriculas.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg font-medium text-sm transition-colors shadow-sm flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
        Nueva Matrícula
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
                    <th class="px-6 py-4 font-semibold">Estudiante</th>
                    <th class="px-6 py-4 font-semibold">Periodo</th>
                    <th class="px-6 py-4 font-semibold">Grupos Inscritos</th>
                    <th class="px-6 py-4 font-semibold">Estado</th>
                    <th class="px-6 py-4 font-semibold text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($matriculas as $matricula)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <p class="text-slate-800 font-bold">{{ $matricula->estudiante->apellidos }}, {{ $matricula->estudiante->nombres }}</p>
                        <p class="text-slate-500 text-xs">{{ $matricula->estudiante->documento_identidad }}</p>
                    </td>
                    <td class="px-6 py-4 text-slate-600">{{ $matricula->periodo_academico }}</td>
                    <td class="px-6 py-4 text-slate-600">
                        <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                            {{ $matricula->grupos->count() }} grupos
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @if($matricula->estado === 'activa')
                            <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-md text-xs font-medium bg-emerald-100 text-emerald-800 border border-emerald-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Activa
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-md text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Cancelada
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('matriculas.edit', $matricula) }}" class="text-blue-600 hover:text-blue-800 font-medium">Editar</a>
                            <form action="{{ route('matriculas.destroy', $matricula) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Eliminar esta matrícula permanentemente?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Eliminar</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-10 text-center text-slate-500">
                        No hay matrículas registradas.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($matriculas->hasPages())
    <div class="px-6 py-4 border-t border-slate-200">
        {{ $matriculas->links() }}
    </div>
    @endif
</div>
@endsection
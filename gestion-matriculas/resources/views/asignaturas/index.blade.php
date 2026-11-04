@extends('layouts.app')

@section('title', 'Asignaturas - EduGestión')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Gestión de Asignaturas</h2>
        <p class="text-slate-500 text-sm mt-1">Administra el pensum y materias disponibles.</p>
    </div>
    <a href="{{ route('asignaturas.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg font-medium text-sm transition-colors shadow-sm flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
        Nueva Asignatura
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
                    <th class="px-6 py-4 font-semibold">Código</th>
                    <th class="px-6 py-4 font-semibold">Nombre de la Asignatura</th>
                    <th class="px-6 py-4 font-semibold">Créditos</th>
                    <th class="px-6 py-4 font-semibold text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($asignaturas as $asignatura)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4 text-slate-800 font-medium">{{ $asignatura->codigo }}</td>
                    <td class="px-6 py-4 text-slate-600">{{ $asignatura->nombre }}</td>
                    <td class="px-6 py-4 text-slate-500">
                        <span class="bg-indigo-100 text-indigo-700 px-2.5 py-0.5 rounded-full text-xs font-semibold">
                            {{ $asignatura->creditos }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('asignaturas.edit', $asignatura) }}" class="text-blue-600 hover:text-blue-800 font-medium">Editar</a>
                            <form action="{{ route('asignaturas.destroy', $asignatura) }}" method="POST" class="inline-block" onsubmit="return confirm('Al eliminar esta asignatura se pueden ver afectados los grupos relacionados. ¿Deseas continuar?');">
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
                        No hay asignaturas registradas.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($asignaturas->hasPages())
    <div class="px-6 py-4 border-t border-slate-200">
        {{ $asignaturas->links() }}
    </div>
    @endif
</div>
@endsection
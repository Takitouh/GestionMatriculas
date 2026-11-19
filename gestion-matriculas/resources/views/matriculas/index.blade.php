
@extends('layouts.app')

@section('title', 'Matrículas - EduGestión')

@section('content')

{{-- Encabezado --}}
<div class="mb-6 flex flex-col lg:flex-row lg:justify-between lg:items-center gap-4">

    <div>
        <h2 class="text-2xl font-bold text-slate-800">
            Control de Matrículas
        </h2>
        <p class="text-slate-500 text-sm mt-1">
            Gestiona las inscripciones académicas de los estudiantes.
        </p>
    </div>

    <div class="flex flex-wrap items-center gap-3">

        {{-- Selector de registros por página --}}
        <form method="GET"
              action="{{ route('matriculas.index') }}"
              class="flex items-center gap-2">

            <label for="per_page" class="text-sm text-slate-600 whitespace-nowrap">
                Mostrar:
            </label>

            <select
                name="per_page"
                id="per_page"
                class="border border-slate-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">

                @foreach([5, 10, 15, 25, 50] as $cantidad)
                    <option value="{{ $cantidad }}"
                        {{ (int)($porPagina ?? request('per_page', 10)) === $cantidad ? 'selected' : '' }}>
                        {{ $cantidad }}
                    </option>
                @endforeach

            </select>

            <button type="submit"
                    class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors">
                Aplicar
            </button>

        </form>

        {{-- Nueva matrícula --}}
        <a href="{{ route('matriculas.create') }}"
           class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg font-medium text-sm transition-colors shadow-sm flex items-center gap-2">

            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                 stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>

            Nueva Matrícula
        </a>

    </div>

</div>


{{-- Mensaje de éxito --}}
@if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-lg mb-6 flex items-center gap-3">

        <svg class="w-5 h-5 text-emerald-500" fill="none"
             stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>

        {{ session('success') }}

    </div>
@endif


{{-- Tabla de matrículas --}}
<div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">

    <div class="overflow-x-auto">

        <table class="w-full text-left text-sm whitespace-nowrap">

            <thead class="bg-slate-50 border-b border-slate-200 text-slate-600">

                <tr>
                    <th class="px-6 py-4 font-semibold">Estudiante</th>
                    <th class="px-6 py-4 font-semibold">Periodo</th>
                    <th class="px-6 py-4 font-semibold">Asignaturas Inscritas</th>
                    <th class="px-6 py-4 font-semibold">Estado</th>
                    <th class="px-6 py-4 font-semibold text-right">Acciones</th>
                </tr>

            </thead>


            <tbody class="divide-y divide-slate-100">

                @forelse($matriculas as $matricula)

                    <tr class="hover:bg-slate-50/50 transition-colors">

                        {{-- Información del estudiante --}}
                        <td class="px-6 py-4">

                            <p class="text-slate-800 font-bold">
                                {{ $matricula->estudiante->apellidos }},
                                {{ $matricula->estudiante->nombres }}
                            </p>

                            <p class="text-slate-500 text-xs">
                                {{ $matricula->estudiante->documento_identidad }}
                            </p>

                        </td>


                        {{-- Periodo académico --}}
                        <td class="px-6 py-4 text-slate-600">
                            {{ $matricula->periodo_academico }}
                        </td>


                        {{-- Asignaturas inscritas --}}
                        <td class="px-6 py-4 min-w-[300px]">

                            <div class="flex flex-col gap-2">

                                @forelse($matricula->grupos as $grupo)

                                    <div class="bg-indigo-50 border border-indigo-100 rounded-lg px-3 py-2">

                                        <p class="font-semibold text-indigo-800">
                                            {{ $grupo->asignatura->nombre ?? 'Asignatura no disponible' }}
                                        </p>

                                        <p class="text-xs text-indigo-600 mt-1">

                                            Código:
                                            {{ $grupo->asignatura->codigo ?? 'N/A' }}

                                            <span class="mx-1">|</span>

                                            {{ $grupo->nombre_grupo }}

                                        </p>

                                    </div>

                                @empty

                                    <span class="text-slate-400 italic">
                                        Sin asignaturas inscritas
                                    </span>

                                @endforelse

                            </div>

                        </td>


                        {{-- Estado --}}
                        <td class="px-6 py-4">

                            @if(strtolower($matricula->estado) === 'activa')

                                <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-md text-xs font-medium bg-emerald-100 text-emerald-800 border border-emerald-200">

                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>

                                    Activa

                                </span>

                            @else

                                <span class="inline-flex items-center gap-1.5 py-1 px-2.5 rounded-md text-xs font-medium bg-red-100 text-red-800 border border-red-200">

                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>

                                    Cancelada

                                </span>

                            @endif

                        </td>


                        {{-- Acciones --}}
                        <td class="px-6 py-4 text-right">

                            <div class="flex items-center justify-end gap-3">

                                <a href="{{ route('matriculas.edit', $matricula) }}"
                                   class="text-blue-600 hover:text-blue-800 font-medium">
                                    Editar
                                </a>

                                <form action="{{ route('matriculas.destroy', $matricula) }}"
                                      method="POST"
                                      class="inline-block"
                                      onsubmit="return confirm('¿Eliminar esta matrícula permanentemente?');">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="text-red-600 hover:text-red-800 font-medium">
                                        Eliminar
                                    </button>

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


    {{-- Información y paginación --}}
    <div class="px-6 py-4 border-t border-slate-200 flex flex-col sm:flex-row justify-between items-center gap-4">

        <p class="text-sm text-slate-500">
            Mostrando
            <strong>{{ $matriculas->firstItem() ?? 0 }}</strong>
            a
            <strong>{{ $matriculas->lastItem() ?? 0 }}</strong>
            de
            <strong>{{ $matriculas->total() }}</strong>
            matrículas.
        </p>

        @if($matriculas->hasPages())

            <div>
                {{ $matriculas->appends(request()->query())->links() }}
            </div>

        @endif

    </div>

</div>

@endsection


@extends('layouts.app')

@section('title', 'Panel Académico - EduGestión')

@section('content')

{{-- Encabezado --}}
<div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">

    <div>
        <h2 class="text-2xl font-bold text-slate-800">
            Panel Académico
        </h2>

        <p class="text-slate-500 text-sm mt-1">
            Visualiza el comportamiento de las matrículas y la ocupación académica.
        </p>
    </div>

    <a href="{{ route('matriculas.index') }}"
       class="inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-3 rounded-xl font-semibold text-sm transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor"
             stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M9 12h3.75M9 15h3.75M9 18h3.75"/>
        </svg>
        Gestionar Matrículas
    </a>

</div>


{{-- Indicadores --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 border-l-4 border-l-indigo-500 p-6">
        <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">
            Total de matrículas
        </p>

        <h3 class="text-3xl font-black text-slate-800 mt-2">
            {{ $totalMatriculas }}
        </h3>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 border-l-4 border-l-emerald-500 p-6">
        <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">
            Matrículas activas
        </p>

        <h3 class="text-3xl font-black text-emerald-600 mt-2">
            {{ $matriculasActivas }}
        </h3>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 border-l-4 border-l-red-500 p-6">
        <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">
            Matrículas canceladas
        </p>

        <h3 class="text-3xl font-black text-red-600 mt-2">
            {{ $matriculasCanceladas }}
        </h3>
    </div>

</div>


{{-- Gráficos --}}
<section class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

    {{-- Gráfico de matrículas --}}
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-200 p-6">

        <div class="mb-5">
            <h3 class="text-lg font-bold text-slate-800">
                Estado de las matrículas
            </h3>

            <p class="text-sm text-slate-500 mt-1">
                Distribución de matrículas activas y canceladas.
            </p>
        </div>

        <div class="relative h-64">
            <canvas id="graficaMatriculas"></canvas>
        </div>

    </div>


    {{-- Ocupación de grupos --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">

        <h3 class="text-lg font-bold text-slate-800">
            Ocupación de grupos
        </h3>

        <p class="text-sm text-slate-500 mt-1">
            Cupos ocupados frente a la capacidad total.
        </p>

        <div class="mt-8">

            <div class="flex justify-between items-end mb-2">

                <span class="text-3xl font-black text-indigo-600">
                    {{ $porcentajeOcupacion }}%
                </span>

                <span class="text-xs text-slate-500">
                    Ocupación
                </span>

            </div>

            <div class="w-full bg-slate-100 rounded-full h-3">

                <div
                    class="bg-indigo-600 h-3 rounded-full transition-all"
                    style="width: {{ min(100, $porcentajeOcupacion) }}%">
                </div>

            </div>

            <div class="flex justify-between text-sm mt-5">
                <span class="text-slate-500">Cupos ocupados</span>
                <strong>{{ $cuposOcupados }}</strong>
            </div>

            <div class="flex justify-between text-sm mt-3">
                <span class="text-slate-500">Capacidad total</span>
                <strong>{{ $cuposTotales }}</strong>
            </div>

            <div class="flex justify-between text-sm mt-3">
                <span class="text-slate-500">Cupos disponibles</span>

                <strong class="text-emerald-600">
                    {{ $cuposDisponibles }}
                </strong>
            </div>

        </div>

    </div>

</section>


{{-- Periodo académico --}}
<section class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 mb-8">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

        <div>

            <p class="text-sm text-slate-500 font-medium">
                Periodo académico destacado
            </p>

            @if($periodoDestacado)

                <h3 class="text-2xl font-bold text-indigo-700 mt-1">
                    {{ $periodoDestacado->periodo_academico }}
                </h3>

                <p class="text-sm text-slate-500 mt-1">
                    {{ $periodoDestacado->total }}
                    matrículas activas registradas.
                </p>

            @else

                <h3 class="text-lg font-semibold text-slate-700 mt-1">
                    Sin matrículas activas
                </h3>

                <p class="text-sm text-slate-500 mt-1">
                    Todavía no hay información para mostrar.
                </p>

            @endif

        </div>

        <div class="bg-indigo-50 text-indigo-700 rounded-xl px-5 py-4">
            <p class="text-xs font-semibold uppercase tracking-wider">
                Periodo con mayor actividad
            </p>

            <p class="text-sm mt-1">
                Según cantidad de matrículas activas.
            </p>
        </div>

    </div>

</section>


{{-- Tabla de matrículas --}}
<section class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

    <div class="p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

        <div>
            <h3 class="text-xl font-bold text-slate-800">
                Matrículas de estudiantes
            </h3>

            <p class="text-sm text-slate-500 mt-1">
                Consulta las asignaturas inscritas por cada estudiante.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-4">

    <span class="text-sm text-slate-500">
        {{ $matriculasRecientes->total() }} registros encontrados
    </span>

    <form method="GET"
          action="{{ route('panel-academico.index') }}"
          class="flex flex-wrap items-center gap-2">

        <label for="per_page" class="text-sm text-slate-600">
            Mostrar:
        </label>

        <select name="per_page"
                id="per_page"
                class="border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 outline-none">

            @foreach([5, 10, 15, 25, 50] as $cantidad)

                <option value="{{ $cantidad }}"
                    {{ $porPagina == $cantidad ? 'selected' : '' }}>

                    {{ $cantidad }}

                </option>

            @endforeach

        </select>

        <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-2 rounded-lg text-sm font-medium transition">

            Aplicar

        </button>

    </form>

</div>

    </div>


    <div class="overflow-x-auto">

        <table class="w-full text-left text-sm">

            <thead class="bg-slate-50 border-y border-slate-200 text-slate-600">

                <tr>
                    <th class="px-6 py-4 font-semibold">Estudiante</th>
                    <th class="px-6 py-4 font-semibold">Asignaturas inscritas</th>
                    <th class="px-6 py-4 font-semibold">Periodo</th>
                    <th class="px-6 py-4 font-semibold">Fecha</th>
                    <th class="px-6 py-4 font-semibold">Estado</th>
                </tr>

            </thead>

            <tbody class="divide-y divide-slate-100">

                @forelse($matriculasRecientes as $matricula)

                    <tr class="hover:bg-slate-50 transition-colors">

                        {{-- Estudiante --}}
                        <td class="px-6 py-4 whitespace-nowrap">

                            <p class="font-bold text-slate-800">
                                {{ $matricula->estudiante->apellidos }},
                                {{ $matricula->estudiante->nombres }}
                            </p>

                            <p class="text-xs text-slate-500 mt-1">
                                Documento:
                                {{ $matricula->estudiante->documento_identidad }}
                            </p>

                        </td>


                        {{-- Asignaturas --}}
                        <td class="px-6 py-4">

                            <div class="flex flex-col gap-2 min-w-[250px]">

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


                        {{-- Periodo --}}
                        <td class="px-6 py-4 whitespace-nowrap text-slate-600">
                            {{ $matricula->periodo_academico }}
                        </td>


                        {{-- Fecha --}}
                        <td class="px-6 py-4 whitespace-nowrap text-slate-600">
                            {{ \Carbon\Carbon::parse($matricula->fecha_matricula)->format('d/m/Y') }}
                        </td>


                        {{-- Estado --}}
                        <td class="px-6 py-4 whitespace-nowrap">

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

                    </tr>

                @empty

                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-slate-500">
                            No hay matrículas registradas.
                        </td>
                    </tr>

                @endforelse

            </tbody>

            {{-- Paginación --}}
        @if($matriculasRecientes->hasPages())

    <div class="px-6 py-4 border-t border-slate-200">

        {{ $matriculasRecientes->links() }}

    </div>

@endif

        </table>

    </div>


    {{-- Paginación --}}
    @if($matriculasRecientes->hasPages())

        <div class="px-6 py-4 border-t border-slate-200">
            {{ $matriculasRecientes->links() }}
        </div>

    @endif

</section>


{{-- Gráfico Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const contexto = document.getElementById('graficaMatriculas');

    new Chart(contexto, {
        type: 'doughnut',

        data: {
            labels: ['Activas', 'Canceladas'],

            datasets: [{
                data: [
                    @json($matriculasActivas),
                    @json($matriculasCanceladas)
                ],

                backgroundColor: [
                    '#10b981',
                    '#f59e0b'
                ],

                borderWidth: 0,
                hoverOffset: 8
            }]
        },

        options: {
            responsive: true,
            maintainAspectRatio: false,

            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 20
                    }
                }
            },

            cutout: '65%'
        }
    });
</script>

@endsection

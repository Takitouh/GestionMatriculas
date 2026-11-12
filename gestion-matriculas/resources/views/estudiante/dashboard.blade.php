<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Matrícula Académica - EduGestión</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-100 text-slate-800 min-h-screen">

    <!-- Barra Superior -->
    <nav class="bg-indigo-700 text-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="font-bold text-xl tracking-tight">EduGestión</span>
                <span class="text-xs bg-indigo-900/60 px-2.5 py-1 rounded-full">Portal Estudiantil</span>
            </div>

            <div class="flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-semibold leading-tight">{{ $estudiante->nombre_completo }}</p>
                    <p class="text-xs text-indigo-200">Doc: {{ $estudiante->documento_identidad }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-indigo-800 hover:bg-indigo-900 px-3 py-1.5 rounded-lg text-sm font-medium transition">
                        Cerrar Sesión
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

        <!-- Alertas -->
        @if (session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-medium">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 text-sm font-medium">
                {{ session('error') }}
            </div>
        @endif

        <!-- Tarjetas de Resumen Académico -->
        <section class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200">
                <p class="text-xs uppercase font-semibold text-slate-400">Periodo Académico</p>
                <p class="text-2xl font-bold text-slate-800 mt-1">{{ $matriculaActual->periodo_academico ?? $periodoActual }}</p>
                <p class="text-xs text-slate-500 mt-1">Registro oficial vigente</p>
            </div>

            <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200">
                <p class="text-xs uppercase font-semibold text-slate-400">Estado de Matrícula</p>
                <div class="mt-1 flex items-center gap-2">
                    <span class="px-2.5 py-0.5 rounded-full text-sm font-semibold {{ $gruposMatriculados->isNotEmpty() ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                        {{ $gruposMatriculados->isNotEmpty() ? ($matriculaActual->estado ?? 'Activa') : 'Sin inscribir' }}
                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-2">
                    {{ $matriculaActual?->fecha_matricula ? 'Fecha: ' . \Carbon\Carbon::parse($matriculaActual->fecha_matricula)->format('d/m/Y') : 'Inscribe tus grupos abajo' }}
                </p>
            </div>

            <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200">
                <p class="text-xs uppercase font-semibold text-slate-400">Créditos Inscritos</p>
                <p class="text-2xl font-bold text-indigo-600 mt-1">{{ $totalCreditos }} <span class="text-sm font-normal text-slate-400">/ {{ $maxCreditos }}</span></p>
                <div class="w-full bg-slate-200 h-2 rounded-full mt-2 overflow-hidden">
                    <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ min(100, ($totalCreditos / $maxCreditos) * 100) }}%"></div>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200 flex flex-col justify-between">
                <div>
                    <p class="text-xs uppercase font-semibold text-slate-400">Grupos Matriculados</p>
                    <p class="text-2xl font-bold text-slate-800 mt-1">{{ $gruposMatriculados->count() }} materias</p>
                </div>
                @if ($gruposMatriculados->isNotEmpty())
                    <a href="{{ route('estudiante.comprobante') }}" target="_blank"
                       class="mt-2 inline-flex items-center justify-center text-xs font-semibold text-indigo-600 hover:text-indigo-800 bg-indigo-50 py-1.5 px-3 rounded-lg transition">
                        Ver / Imprimir Sábana de Matrícula
                    </a>
                @endif
            </div>
        </section>

        <!-- SECCIÓN 1: Mis Grupos Matriculados -->
        <section class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200">
                <h2 class="text-lg font-bold text-slate-800">Mis Grupos Matriculados</h2>
                <p class="text-sm text-slate-500">Asignaturas y grupos registrados en tu carga académica actual</p>
            </div>

            @if ($gruposMatriculados->isEmpty())
                <div class="p-10 text-center text-slate-500">
                    <p class="font-medium">Aún no tienes grupos matriculados en este periodo.</p>
                    <p class="text-sm mt-1">Selecciona los grupos disponibles en la sección inferior para armar tu matrícula.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-xs uppercase text-slate-500 border-b border-slate-200">
                                <th class="py-3 px-6">Asignatura</th>
                                <th class="py-3 px-4">Grupo</th>
                                <th class="py-3 px-4 text-center">Cupo Máximo</th>
                                <th class="py-3 px-4 text-center">Créditos</th>
                                <th class="py-3 px-6 text-right">Acción</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            @foreach ($gruposMatriculados as $grupo)
                                <tr class="hover:bg-slate-50/70">
                                    <td class="py-3.5 px-6">
                                        <p class="font-semibold text-slate-800">{{ $grupo->asignatura->nombre ?? 'Asignatura' }}</p>
                                        <p class="text-xs text-slate-400">Código: {{ $grupo->asignatura->codigo ?? 'N/A' }}</p>
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <span class="px-2.5 py-1 rounded-md bg-indigo-50 text-indigo-700 font-semibold text-xs">
                                            {{ $grupo->nombre_grupo }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 text-center text-slate-600">{{ $grupo->cupo_maximo }} estudiantes</td>
                                    <td class="py-3.5 px-4 text-center font-semibold">{{ $grupo->asignatura->creditos ?? 0 }}</td>
                                    <td class="py-3.5 px-6 text-right">
                                        <form method="POST" action="{{ route('estudiante.retirar', $grupo) }}"
                                              onsubmit="return confirm('¿Deseas retirar este grupo de tu matrícula?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs font-semibold text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition">
                                                Retirar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>

        <!-- SECCIÓN 2: Oferta Académica Disponible -->
        <section class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h2 class="text-lg font-bold text-slate-800">Oferta Académica (Grupos Disponibles)</h2>
                    <p class="text-sm text-slate-500">Consulta cupos en tiempo real e inscribe tus materias</p>
                </div>

                <!-- Buscador -->
                <form method="GET" action="{{ route('estudiante.dashboard') }}" class="flex gap-2">
                    <input type="text" name="buscar" value="{{ $busqueda }}" placeholder="Buscar materia o código..."
                           class="rounded-lg border-slate-300 text-sm focus:border-indigo-500 focus:ring-indigo-500 w-64">
                    <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                        Buscar
                    </button>
                    @if ($busqueda)
                        <a href="{{ route('estudiante.dashboard') }}" class="px-3 py-2 text-sm text-slate-500 hover:text-slate-700">Limpiar</a>
                    @endif
                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-6">
                @forelse ($gruposDisponibles as $grupo)
                    @php
                        $cupoMax = $grupo->cupo_maximo ?? 30;
                        $disponibles = $grupo->cuposDisponibles();
                        $yaInscritoEsteGrupo = in_array($grupo->id, $gruposInscritosIds);
                        $yaInscritaMateria = in_array($grupo->asignatura_id, $asignaturasInscritasIds);
                    @endphp

                    <div class="border rounded-xl p-5 flex flex-col justify-between {{ $yaInscritoEsteGrupo ? 'border-emerald-300 bg-emerald-50/30' : 'border-slate-200 bg-white' }}">
                        <div>
                            <div class="flex items-start justify-between gap-2">
                                <span class="text-xs font-bold uppercase tracking-wider text-indigo-600 bg-indigo-50 px-2.5 py-0.5 rounded">
                                    {{ $grupo->asignatura->codigo ?? 'COD' }}
                                </span>
                                <span class="text-xs font-semibold text-slate-500">
                                    {{ $grupo->asignatura->creditos ?? 0 }} créditos
                                </span>
                            </div>

                            <h3 class="font-bold text-slate-800 text-base mt-2">
                                {{ $grupo->asignatura->nombre ?? 'Asignatura sin nombre' }}
                            </h3>

                            <p class="mt-2 text-xs font-medium text-slate-600">
                                <span class="font-semibold">Sección:</span> {{ $grupo->nombre_grupo }}
                            </p>
                        </div>

                        <div class="mt-4 pt-3 border-t border-slate-100">
                            <div class="flex justify-between text-xs mb-1">
                                <span class="text-slate-500">Cupos disponibles</span>
                                <span class="font-bold {{ $disponibles > 5 ? 'text-emerald-600' : ($disponibles > 0 ? 'text-amber-600' : 'text-red-600') }}">
                                    {{ $disponibles }} / {{ $cupoMax }}
                                </span>
                            </div>

                            @if ($yaInscritoEsteGrupo)
                                <button disabled class="w-full mt-2 py-2 px-4 rounded-lg bg-emerald-100 text-emerald-700 text-xs font-bold cursor-default">
                                    ✓ Grupo Matriculado
                                </button>
                            @elseif ($yaInscritaMateria)
                                <button disabled class="w-full mt-2 py-2 px-4 rounded-lg bg-slate-100 text-slate-400 text-xs font-semibold cursor-not-allowed">
                                    Asignatura ya inscrita en otro grupo
                                </button>
                            @elseif ($disponibles <= 0)
                                <button disabled class="w-full mt-2 py-2 px-4 rounded-lg bg-red-50 text-red-400 text-xs font-semibold cursor-not-allowed">
                                    Sin Cupos Disponibles
                                </button>
                            @else
                                <form method="POST" action="{{ route('estudiante.matricular', $grupo) }}" class="mt-2">
                                    @csrf
                                    <button type="submit" class="w-full py-2 px-4 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold shadow-sm transition">
                                        + Inscribir Grupo
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-8 text-slate-500 text-sm">
                        No se encontraron grupos disponibles con los criterios de búsqueda.
                    </div>
                @endforelse
            </div>
        </section>
    </main>
</body>
</html>
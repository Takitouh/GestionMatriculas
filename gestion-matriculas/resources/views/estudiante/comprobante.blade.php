<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sábana de Matrícula - {{ $estudiante->documento_identidad }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @media print { .no-print { display: none; } }
    </style>
</head>
<body class="bg-white text-slate-800 p-8 max-w-4xl mx-auto">

    <div class="no-print flex justify-between items-center mb-6 pb-4 border-b">
        <a href="{{ route('estudiante.dashboard') }}" class="text-sm text-indigo-600 hover:underline">← Volver al portal</a>
        <button onclick="window.print()" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-indigo-700">
            Imprimir / Guardar PDF
        </button>
    </div>

    <header class="border-b-2 border-slate-800 pb-4 mb-6 flex justify-between items-end">
        <div>
            <h1 class="text-2xl font-bold uppercase tracking-wide">Comprobante de Matrícula Académica</h1>
            <p class="text-sm text-slate-500">Sistema EduGestión • Periodo {{ $matriculaActual->periodo_academico ?? '2026-2' }}</p>
        </div>
        <div class="text-right text-xs text-slate-500">
            <p>Generado: {{ now()->format('d/m/Y H:i') }}</p>
            <p class="font-bold text-emerald-700 uppercase mt-1">Estado: {{ $matriculaActual->estado ?? 'Activa' }}</p>
        </div>
    </header>

    <section class="grid grid-cols-2 gap-4 bg-slate-50 p-4 rounded-lg border border-slate-200 mb-6 text-sm">
        <div>
            <p class="text-xs text-slate-400 uppercase">Estudiante</p>
            <p class="font-bold">{{ $estudiante->nombre_completo }}</p>
        </div>
        <div>
            <p class="text-xs text-slate-400 uppercase">Documento de Identidad</p>
            <p class="font-bold">{{ $estudiante->documento_identidad }}</p>
        </div>
        <div>
            <p class="text-xs text-slate-400 uppercase">Correo Institucional</p>
            <p>{{ $estudiante->correo }}</p>
        </div>
        <div>
            <p class="text-xs text-slate-400 uppercase">Total Créditos Matriculados</p>
            <p class="font-bold">{{ $totalCreditos }} Créditos</p>
        </div>
    </section>

    <table class="w-full text-left border-collapse border border-slate-300 text-sm">
        <thead>
            <tr class="bg-slate-100 border-b border-slate-300">
                <th class="p-3 border-r border-slate-300">Código</th>
                <th class="p-3 border-r border-slate-300">Asignatura</th>
                <th class="p-3 border-r border-slate-300">Grupo</th>
                <th class="p-3 text-center">Créditos</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($gruposMatriculados as $grupo)
                <tr class="border-b border-slate-200">
                    <td class="p-3 border-r border-slate-300 font-mono text-xs">{{ $grupo->asignatura->codigo ?? '-' }}</td>
                    <td class="p-3 border-r border-slate-300 font-semibold">{{ $grupo->asignatura->nombre ?? '-' }}</td>
                    <td class="p-3 border-r border-slate-300">{{ $grupo->nombre_grupo }}</td>
                    <td class="p-3 text-center font-bold">{{ $grupo->asignatura->creditos ?? 0 }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
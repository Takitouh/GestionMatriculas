@extends('layouts.app')

@section('title', 'Inicio - Gestión de Matrículas')

@section('content')

<!-- Hero / Welcome Banner -->
<section class="relative bg-gradient-to-br from-indigo-700 via-violet-700 to-blue-700 rounded-3xl shadow-xl overflow-hidden mb-10 border border-indigo-500/30">
    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
    <div class="relative px-8 py-14 md:px-12 md:py-20 text-white flex flex-col md:flex-row items-center justify-between gap-8">
        <div class="max-w-2xl z-10">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-5 tracking-tight leading-tight">Gestión Académica <br class="hidden md:block">Simplificada</h1>
            <p class="text-lg md:text-xl text-indigo-100 mb-8 font-light">Administra estudiantes, estructura asignaturas y controla los periodos de matrícula desde un panel centralizado.</p>
            <a href="#modulos" class="inline-flex items-center gap-2 bg-white text-indigo-800 font-semibold px-7 py-3.5 rounded-xl shadow-lg hover:bg-slate-50 hover:shadow-xl transition-all duration-300 hover:-translate-y-0.5">
                Explorar Módulos
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>
            </a>
        </div>
        <!-- Ilustración decorativa abstracta -->
        <div class="hidden md:block relative z-10 opacity-90">
            <svg class="w-64 h-64 text-indigo-200" fill="currentColor" viewBox="0 0 24 24">
                <path opacity="0.5" d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-.99L12 2z"/>
                <circle cx="12" cy="12" r="4" class="text-white"/>
            </svg>
        </div>
    </div>
</section>

<!-- Stats Row (Listos para recibir variables dinámicas) -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 mb-14">
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-slate-200 border-l-4 border-l-blue-500 hover:shadow-md transition-shadow">
        <p class="text-sm text-slate-500 font-medium uppercase tracking-wider mb-1">Estudiantes</p>
        <h3 class="text-3xl font-black text-slate-800">{{ $totalEstudiantes ?? '0' }}</h3>
    </div>
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-slate-200 border-l-4 border-l-emerald-500 hover:shadow-md transition-shadow">
        <p class="text-sm text-slate-500 font-medium uppercase tracking-wider mb-1">Asignaturas</p>
        <h3 class="text-3xl font-black text-slate-800">{{ $totalAsignaturas ?? '0' }}</h3>
    </div>
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-slate-200 border-l-4 border-l-violet-500 hover:shadow-md transition-shadow">
        <p class="text-sm text-slate-500 font-medium uppercase tracking-wider mb-1">Grupos Activos</p>
        <h3 class="text-3xl font-black text-slate-800">{{ $totalGrupos ?? '0' }}</h3>
    </div>
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-slate-200 border-l-4 border-l-amber-500 hover:shadow-md transition-shadow">
        <p class="text-sm text-slate-500 font-medium uppercase tracking-wider mb-1">Matrículas</p>
        <h3 class="text-3xl font-black text-slate-800">{{ $totalMatriculas ?? '0' }}</h3>
    </div>
</div>

<!-- Modules Section -->
<section id="modulos" class="scroll-mt-24">
    <div class="flex items-center justify-between mb-8">
        <h3 class="text-2xl font-bold text-slate-900 tracking-tight">Módulos del Sistema</h3>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        <!-- Estudiantes -->
        <a href="#" class="group block bg-white rounded-3xl p-6 shadow-sm border border-slate-100 hover:shadow-xl hover:border-blue-200 transition-all duration-300 hover:-translate-y-1">
            <div class="bg-blue-50 text-blue-600 w-14 h-14 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
            </div>
            <h4 class="text-lg font-bold text-slate-800 mb-2 group-hover:text-blue-600 transition-colors">Estudiantes</h4>
            <p class="text-sm text-slate-500 leading-relaxed">Administra expedientes, datos personales e identificación única.</p>
        </a>

        <!-- Asignaturas -->
        <a href="#" class="group block bg-white rounded-3xl p-6 shadow-sm border border-slate-100 hover:shadow-xl hover:border-emerald-200 transition-all duration-300 hover:-translate-y-1">
            <div class="bg-emerald-50 text-emerald-600 w-14 h-14 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-300">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/></svg>
            </div>
            <h4 class="text-lg font-bold text-slate-800 mb-2 group-hover:text-emerald-600 transition-colors">Asignaturas</h4>
            <p class="text-sm text-slate-500 leading-relaxed">Configura el pensum, códigos, nombres y distribución de créditos.</p>
        </a>

        <!-- Grupos -->
        <a href="#" class="group block bg-white rounded-3xl p-6 shadow-sm border border-slate-100 hover:shadow-xl hover:border-violet-200 transition-all duration-300 hover:-translate-y-1">
            <div class="bg-violet-50 text-violet-600 w-14 h-14 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-violet-600 group-hover:text-white transition-colors duration-300">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/></svg>
            </div>
            <h4 class="text-lg font-bold text-slate-800 mb-2 group-hover:text-violet-600 transition-colors">Grupos</h4>
            <p class="text-sm text-slate-500 leading-relaxed">Organiza secciones académicas, asigna cupos máximos y horarios.</p>
        </a>

        <!-- Matrículas -->
        <a href="#" class="group block bg-white rounded-3xl p-6 shadow-sm border border-slate-100 hover:shadow-xl hover:border-amber-200 transition-all duration-300 hover:-translate-y-1">
            <div class="bg-amber-50 text-amber-600 w-14 h-14 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-amber-500 group-hover:text-white transition-colors duration-300">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.384-2.238-1.037-3.077l-2.948-3.89A2.25 2.25 0 0013.44 1.184H5.088A2.25 2.25 0 002.88 3.392V20.25A2.25 2.25 0 005.088 22.5h13.824a2.25 2.25 0 002.25-2.25v-2.625z"/></svg>
            </div>
            <h4 class="text-lg font-bold text-slate-800 mb-2 group-hover:text-amber-500 transition-colors">Matrículas</h4>
            <p class="text-sm text-slate-500 leading-relaxed">Gestiona registros, periodos académicos y estados de inscripción.</p>
        </a>

    </div>
</section>

@endsection
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistema de Gestión de Matrículas')</title>
    <!-- Tailwind CSS (CDN para desarrollo rápido) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Fuente Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col">

    <!-- Navbar -->
    <header class="bg-white border-b border-slate-200 shadow-sm sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-3">
                    <div class="bg-indigo-600 text-white p-2 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" /></svg>
                    </div>
                    <span class="text-xl font-bold tracking-tight text-slate-900">EduGestión</span>
                </div>
                <nav class="hidden md:flex gap-6">
                    <a href="#" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition-colors">Inicio</a>
                    <a href="#" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition-colors">Estudiantes</a>
                    <a href="#" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition-colors">Asignaturas</a>
                </nav>
                <div class="flex items-center gap-4">
                    <div class="w-8 h-8 rounded-full bg-slate-200 border border-slate-300 flex items-center justify-center text-sm font-bold text-slate-500">
                        A
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Contenido Principal -->
    <main class="flex-grow w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-10">
        @yield('content')
    </main>

</body>
</html>
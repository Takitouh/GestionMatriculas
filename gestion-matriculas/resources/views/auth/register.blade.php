<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Registro de Estudiante - EduGestión</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-lg bg-white rounded-3xl shadow-xl border border-slate-100 p-8">

        {{-- Encabezado --}}
        <div class="flex flex-col items-center mb-8">

            <div class="bg-indigo-600 text-white p-3 rounded-2xl mb-3">
                <svg class="w-8 h-8" fill="none" stroke="currentColor"
                    stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                </svg>
            </div>

            <h1 class="text-2xl font-extrabold text-slate-900">
                Registro de Estudiante
            </h1>

            <p class="text-sm text-slate-500 mt-1 text-center">
                Crea tu cuenta para gestionar tu matrícula y horarios.
            </p>

        </div>


        {{-- Mensaje de estado --}}
        @if (session('status'))
            <div class="mb-5 px-4 py-3 rounded-xl text-sm
                @if (session('status_type') === 'warning')
                    bg-amber-50 border border-amber-200 text-amber-700
                @else
                    bg-green-50 border border-green-200 text-green-700
                @endif">

                <div class="flex items-start gap-2">

                    @if (session('status_type') === 'warning')
                        <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v4m0 4h.01M10.29 3.86l-8.1 14.03A2 2 0 003.92 21h16.16a2 2 0 001.73-3.11l-8.1-14.03a2 2 0 00-3.46 0z" />
                        </svg>
                    @else
                        <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M5 13l4 4L19 7" />
                        </svg>
                    @endif

                    <p>{{ session('status') }}</p>

                </div>
            </div>
        @endif


        {{-- Errores de validación --}}
        @if ($errors->any())
            <div class="mb-5 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        {{-- Formulario de registro --}}
        <form method="POST" action="{{ route('register.post') }}" class="space-y-5">

            @csrf

            {{-- Nombres y apellidos --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label for="nombres" class="block text-sm font-semibold text-slate-700 mb-1">
                        Nombres
                    </label>

                    <input
                        type="text"
                        name="nombres"
                        id="nombres"
                        value="{{ old('nombres') }}"
                        required
                        maxlength="100"
                        autocomplete="given-name"
                        placeholder="Tus nombres"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600 text-slate-800 @error('nombres') border-red-500 @enderror">
                </div>

                <div>
                    <label for="apellidos" class="block text-sm font-semibold text-slate-700 mb-1">
                        Apellidos
                    </label>

                    <input
                        type="text"
                        name="apellidos"
                        id="apellidos"
                        value="{{ old('apellidos') }}"
                        required
                        maxlength="100"
                        autocomplete="family-name"
                        placeholder="Tus apellidos"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600 text-slate-800 @error('apellidos') border-red-500 @enderror">
                </div>

            </div>


            {{-- Documento y fecha de nacimiento --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label for="documento_identidad" class="block text-sm font-semibold text-slate-700 mb-1">
                        Documento de Identidad
                    </label>

                    <input
                        type="text"
                        name="documento_identidad"
                        id="documento_identidad"
                        value="{{ old('documento_identidad') }}"
                        required
                        maxlength="20"
                        placeholder="Número de documento"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600 text-slate-800 @error('documento_identidad') border-red-500 @enderror">
                </div>

                <div>
                    <label for="fecha_nacimiento" class="block text-sm font-semibold text-slate-700 mb-1">
                        Fecha de Nacimiento
                    </label>

                    <input
                        type="date"
                        name="fecha_nacimiento"
                        id="fecha_nacimiento"
                        value="{{ old('fecha_nacimiento') }}"
                        required
                        max="{{ date('Y-m-d') }}"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600 text-slate-800 @error('fecha_nacimiento') border-red-500 @enderror">
                </div>

            </div>


            {{-- Correo electrónico --}}
            <div>
                <label for="email" class="block text-sm font-semibold text-slate-700 mb-1">
                    Correo Electrónico
                </label>

                <input
                    type="email"
                    name="email"
                    id="email"
                    value="{{ old('email') }}"
                    required
                    maxlength="150"
                    autocomplete="email"
                    placeholder="ejemplo@correo.com"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600 text-slate-800 @error('email') border-red-500 @enderror">
            </div>


            {{-- Información sobre activación --}}
            <div class="bg-indigo-50 border border-indigo-100 rounded-xl p-4">

                <div class="flex items-start gap-3">

                    <div class="text-indigo-600 shrink-0 mt-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 8l9 6 9-6M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>

                    <div>
                        <p class="text-sm font-semibold text-indigo-900">
                            Activa tu cuenta por correo electrónico
                        </p>

                        <p class="text-xs text-indigo-700 mt-1 leading-relaxed">
                            Después de registrarte, recibirás un correo con un enlace para crear tu contraseña.
                            Necesitarás completar ese paso antes de iniciar sesión.
                        </p>
                    </div>

                </div>

            </div>


            {{-- Botón principal --}}
            <button
                type="submit"
                class="w-full bg-indigo-600 text-white font-bold py-3.5 rounded-xl shadow-lg
                       cursor-pointer
                       hover:bg-indigo-700 hover:shadow-xl
                       active:bg-indigo-800 active:scale-[0.99]
                       transition-all duration-200 ease-in-out
                       focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">

                Crear Cuenta Estudiantil

            </button>

        </form>


        {{-- Separación de la sección principal --}}
        <div class="mt-8 pt-7 border-t border-slate-200">

            {{-- Reenviar enlace de activación --}}
            <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5">

                <div class="text-center mb-4">

                    <div class="inline-flex items-center justify-center bg-indigo-100 text-indigo-600 rounded-xl p-2 mb-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 8l9 6 9-6M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>

                    <h2 class="text-sm font-bold text-slate-800">
                        ¿No recibiste el correo de activación?
                    </h2>

                    <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                        Ingresa tu correo electrónico para solicitar un nuevo enlace de activación.
                    </p>

                </div>


                <form method="POST" action="{{ route('activation.resend') }}" class="space-y-3">

                    @csrf

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
                        placeholder="Ingresa tu correo electrónico"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white focus:outline-none focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600 text-slate-800">

                    <button
                        type="submit"
                        class="w-full bg-white border border-indigo-600 text-indigo-600 font-semibold py-3 rounded-xl
                               cursor-pointer
                               hover:bg-indigo-600 hover:text-white hover:shadow-md
                               active:bg-indigo-700 active:scale-[0.99]
                               transition-all duration-200 ease-in-out
                               focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">

                        Reenviar enlace de activación

                    </button>

                </form>

            </div>

        </div>


        {{-- Enlace al login --}}
        <div class="mt-7 text-center text-sm text-slate-500">

            ¿Ya activaste tu cuenta?

            <a href="{{ route('login') }}"
                class="text-indigo-600 font-bold hover:text-indigo-800 hover:underline transition-colors duration-200">

                Inicia sesión aquí

            </a>

        </div>

    </div>

</body>

</html>
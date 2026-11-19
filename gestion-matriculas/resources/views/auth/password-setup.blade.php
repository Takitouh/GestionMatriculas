<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Activar Cuenta - EduGestión</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-lg bg-white rounded-3xl shadow-xl border border-slate-100 p-8">

        <div class="flex flex-col items-center mb-8">
            <div class="bg-indigo-600 text-white p-3 rounded-2xl mb-3">
                <svg class="w-8 h-8" fill="none" stroke="currentColor"
                    stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
                </svg>
            </div>

            <h1 class="text-2xl font-extrabold text-slate-900">
                Activa tu cuenta
            </h1>

            <p class="text-sm text-slate-500 mt-2 text-center">
                Establece una contraseña para comenzar a utilizar EduGestión.
            </p>
        </div>

        @if ($errors->any())
            <div class="mb-5 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}" class="space-y-5">

            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div>
                <label for="email" class="block text-sm font-semibold text-slate-700 mb-1">
                    Correo Electrónico
                </label>

                <input type="email"
                    name="email"
                    id="email"
                    value="{{ old('email', $email) }}"
                    readonly
                    required
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 text-slate-600">
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-slate-700 mb-1">
                    Nueva Contraseña
                </label>

                <input type="password"
                    name="password"
                    id="password"
                    required
                    minlength="8"
                    autocomplete="new-password"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600 text-slate-800">
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-1">
                    Confirmar Contraseña
                </label>

                <input type="password"
                    name="password_confirmation"
                    id="password_confirmation"
                    required
                    minlength="8"
                    autocomplete="new-password"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600 text-slate-800">
            </div>

            <button type="submit"
                class="w-full bg-indigo-600 text-white font-bold py-3.5 rounded-xl shadow-lg hover:bg-indigo-700 transition-colors">
                Activar Cuenta
            </button>

        </form>

    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - EduGestión</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-white rounded-3xl shadow-xl border border-slate-100 p-8">
        <div class="flex flex-col items-center mb-8">
            <h2 class="text-2xl font-extrabold text-slate-900">Crear Cuenta</h2>
            <p class="text-sm text-slate-500 mt-1">Registra tus credenciales de usuario</p>
        </div>

        @if ($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Nombre Completo</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-600">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Correo Electrónico</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-600">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Contraseña</label>
                <input type="password" name="password" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-600">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 mb-1">Confirmar Contraseña</label>
                <input type="password" name="password_confirmation" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-indigo-600">
            </div>

            <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3.5 rounded-xl shadow-lg hover:bg-indigo-700 transition-colors mt-2">
                Registrarse
            </button>
        </form>

        <div class="mt-6 text-center text-sm text-slate-500">
            ¿Ya tienes cuenta? <a href="{{ route('login') }}" class="text-indigo-600 font-bold hover:underline">Inicia sesión</a>
        </div>
    </div>
</body>
</html>
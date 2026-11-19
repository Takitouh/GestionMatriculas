<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\User;
use App\Services\AccountActivationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {

            $user = Auth::user();

            if (
                $user->role === 'estudiante' &&
                !$user->email_verified_at
            ) {
                Auth::logout();

                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()
                    ->withErrors([
                        'email' => 'Debes activar tu cuenta desde el enlace que enviamos a tu correo antes de iniciar sesión.',
                    ])
                    ->onlyInput('email');
            }

            $request->session()->regenerate();

            if ($user->isAdmin()) {
                return redirect()->route('home');
            }

            return redirect()->route('estudiante.dashboard');
        }

        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(
        Request $request,
        AccountActivationService $activation
    ) {
        $validated = $request->validate([
            'documento_identidad' => [
                'required',
                'string',
                'max:20',
                'unique:estudiantes,documento_identidad',
            ],

            'nombres' => [
                'required',
                'string',
                'max:100',
            ],

            'apellidos' => [
                'required',
                'string',
                'max:100',
            ],

            'fecha_nacimiento' => [
                'required',
                'date',
                'before:today',
            ],

            'email' => [
                'required',
                'email',
                'max:150',
                'unique:users,email',
                'unique:estudiantes,correo',
            ],
        ]);

        $user = DB::transaction(function () use ($validated) {

            $user = User::create([
                'name' => $validated['nombres'].' '.$validated['apellidos'],
                'email' => $validated['email'],
                'role' => 'estudiante',
                'password' => Str::random(64),
            ]);

            Estudiante::create([
                'user_id' => $user->id,
                'documento_identidad' => $validated['documento_identidad'],
                'nombres' => $validated['nombres'],
                'apellidos' => $validated['apellidos'],
                'correo' => $validated['email'],
                'fecha_nacimiento' => $validated['fecha_nacimiento'],
            ]);

            return $user;
        });

        $enviado = $activation->sendLink($user);

        return redirect()
            ->route('register')
            ->with('status', $enviado
                ? 'Tu registro fue exitoso. Revisa tu correo para activar tu cuenta y establecer tu contraseña.'
                : 'Tu registro fue creado, pero no pudimos enviar el correo de activación. Puedes solicitar que se reenvíe.'
            )
            ->with('status_type', $enviado ? 'success' : 'warning');
    }

    public function resendActivation(
        Request $request,
        AccountActivationService $activation
    ) {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->email)
            ->where('role', 'estudiante')
            ->whereNull('email_verified_at')
            ->first();

        if ($user) {
            $activation->sendLink($user);
        }

        // Respuesta genérica para no revelar qué correos están registrados.
        return back()->with(
            'status',
            'Si existe una cuenta estudiantil pendiente de activación con ese correo, se intentará enviar un nuevo enlace.'
        )->with('status_type', 'success');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
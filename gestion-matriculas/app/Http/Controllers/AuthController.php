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
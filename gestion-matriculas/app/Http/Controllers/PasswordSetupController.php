<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordSetupController extends Controller
{
    public function create(Request $request, string $token)
    {
        return view('auth.password-setup', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $status = Password::reset(
            $request->only(
                'email',
                'password',
                'password_confirmation',
                'token'
            ),
            function (User $user, string $password) {

                $user->forceFill([
                    'password' => Hash::make($password),
                    'email_verified_at' => now(),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PasswordReset) {
            return redirect()
                ->route('login')
                ->with('success', 'Tu cuenta ha sido activada. Ya puedes iniciar sesión.');
        }

        $message = $status === Password::InvalidToken
            ? 'El enlace de activación no es válido o ha expirado. Solicita uno nuevo.'
            : 'No fue posible activar la cuenta. Comprueba tus datos e inténtalo nuevamente.';

        return back()
            ->withErrors(['email' => $message])
            ->withInput(['email' => $request->email]);
    }
}
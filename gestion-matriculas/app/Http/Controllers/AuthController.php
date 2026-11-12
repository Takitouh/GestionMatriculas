<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
            $request->session()->regenerate();

            if (Auth::user()->isAdmin()) {
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

    public function register(Request $request)
    {
        $validated = $request->validate([
            'documento_identidad' => ['required', 'string', 'max:20', 'unique:estudiantes,documento_identidad'],
            'nombres'             => ['required', 'string', 'max:100'],
            'apellidos'           => ['required', 'string', 'max:100'],
            'fecha_nacimiento'    => ['required', 'date', 'before:today'],
            'email'               => ['required', 'string', 'email', 'max:255', 'unique:users,email', 'unique:estudiantes,correo'],
            'password'            => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = DB::transaction(function () use ($validated) {
            $nuevoUsuario = User::create([
                'name'     => "{$validated['nombres']} {$validated['apellidos']}",
                'email'    => $validated['email'],
                'role'     => 'estudiante',
                'password' => Hash::make($validated['password']),
            ]);

            Estudiante::create([
                'user_id'             => $nuevoUsuario->id,
                'documento_identidad' => $validated['documento_identidad'],
                'nombres'             => $validated['nombres'],
                'apellidos'           => $validated['apellidos'],
                'correo'              => $validated['email'],
                'fecha_nacimiento'    => $validated['fecha_nacimiento'],
            ]);

            return $nuevoUsuario;
        });

        Auth::login($user);

        return redirect()->route('estudiante.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
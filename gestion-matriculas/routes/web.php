<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\AsignaturaController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EstudiantePortalController;
use App\Http\Middleware\AdminMiddleware;

// Rutas Públicas (Invitados)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// Rutas Protegidas (Requieren Login)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Ruta raíz: separa automáticamente Administrador vs Estudiante
    Route::get('/', function () {
        if (Auth::user()->isAdmin()) {
            return app()->call([app(HomeController::class), 'index']);
        }
        return redirect()->route('estudiante.dashboard');
    })->name('home');

    // Respaldo por si alguna vista apunta a /dashboard
    Route::get('/dashboard', function () {
        return Auth::user()->isAdmin()
            ? redirect()->route('home')
            : redirect()->route('estudiante.dashboard');
    })->name('dashboard');

    // Portal del Estudiante
    Route::prefix('mi-matricula')->name('estudiante.')->group(function () {
        Route::get('/', [EstudiantePortalController::class, 'index'])->name('dashboard');
        Route::post('/inscribir/{grupo}', [EstudiantePortalController::class, 'matricular'])->name('matricular');
        Route::delete('/retirar/{grupo}', [EstudiantePortalController::class, 'retirar'])->name('retirar');
        Route::get('/comprobante', [EstudiantePortalController::class, 'comprobante'])->name('comprobante');
    });

    // Panel Administrativo (CRUDs protegidos solo para rol admin)
    Route::middleware(AdminMiddleware::class)->group(function () {
        Route::resource('estudiantes', EstudianteController::class);
        Route::resource('asignaturas', AsignaturaController::class);
        Route::resource('grupos', GrupoController::class);
        Route::resource('matriculas', MatriculaController::class);
    });
});
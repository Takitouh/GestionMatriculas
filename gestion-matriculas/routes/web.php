<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\AsignaturaController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\MatriculaController;


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::resource('estudiantes', EstudianteController::class);

Route::resource('asignaturas', AsignaturaController::class);

Route::resource('grupos', GrupoController::class);

Route::resource('matriculas', MatriculaController::class);
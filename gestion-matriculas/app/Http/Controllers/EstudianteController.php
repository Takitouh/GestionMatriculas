<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use App\Models\User;
use App\Http\Requests\StoreEstudianteRequest;
use App\Http\Requests\UpdateEstudianteRequest;
use App\Services\AccountActivationService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;

class EstudianteController extends Controller
{
    public function index()
    {
        $estudiantes = Estudiante::latest()->paginate(10);

        return view('estudiantes.index', compact('estudiantes'));
    }

    public function create()
    {
        return view('estudiantes.create');
    }

    public function store(
        StoreEstudianteRequest $request,
        AccountActivationService $activation
    ) {
        $datos = $request->validated();

        $user = DB::transaction(function () use ($datos) {

            $user = User::create([
                'name' => $datos['nombres'].' '.$datos['apellidos'],
                'email' => $datos['correo'],
                'role' => 'estudiante',
                'password' => Str::random(64),
            ]);

            $user->estudiante()->create([
                'documento_identidad' => $datos['documento_identidad'],
                'nombres' => $datos['nombres'],
                'apellidos' => $datos['apellidos'],
                'correo' => $datos['correo'],
                'fecha_nacimiento' => $datos['fecha_nacimiento'],
            ]);

            return $user;
        });

        $enviado = $activation->sendLink($user);

        if ($enviado) {
            return redirect()
                ->route('estudiantes.index')
                ->with('success', 'Estudiante registrado. Se envió el enlace de activación a su correo.');
        }

        return redirect()
            ->route('estudiantes.index')
            ->with('error', 'El estudiante fue registrado, pero no se pudo enviar el correo de activación. Puedes reenviarlo posteriormente.');
    }

    public function edit(Estudiante $estudiante)
    {
        return view('estudiantes.edit', compact('estudiante'));
    }

    public function update(
        UpdateEstudianteRequest $request,
        Estudiante $estudiante,
        AccountActivationService $activation
    ) {
        $datos = $request->validated();

        [$user, $necesitaActivacion] = DB::transaction(function () use ($datos, $estudiante) {

            $estudiante->update($datos);

            $user = $estudiante->user;

            // Para perfiles antiguos que no tengan una cuenta asociada.
            if (!$user) {

                $user = User::create([
                    'name' => $datos['nombres'].' '.$datos['apellidos'],
                    'email' => $datos['correo'],
                    'role' => 'estudiante',
                    'password' => Str::random(64),
                ]);

                $estudiante->user()->associate($user);
                $estudiante->save();

                return [$user, true];
            }

            $emailCambio = $user->email !== $datos['correo'];

            $user->name = $datos['nombres'].' '.$datos['apellidos'];
            $user->email = $datos['correo'];

            $necesitaActivacion = $emailCambio || !$user->email_verified_at;

            if ($necesitaActivacion) {
                $user->password = Str::random(64);
                $user->email_verified_at = null;
            }

            $user->save();

            return [$user, $necesitaActivacion];
        });

        if ($necesitaActivacion) {

            $enviado = $activation->sendLink($user);

            return redirect()
                ->route('estudiantes.index')
                ->with(
                    $enviado ? 'success' : 'error',
                    $enviado
                        ? 'Datos actualizados. El estudiante debe activar nuevamente su cuenta.'
                        : 'Datos actualizados, pero no fue posible enviar el nuevo enlace de activación.'
                );
        }

        return redirect()
            ->route('estudiantes.index')
            ->with('success', 'Datos del estudiante actualizados correctamente.');
    }

    public function resendActivation(
        Estudiante $estudiante,
        AccountActivationService $activation
    ) {
        $user = $estudiante->user;

        if (!$user || $user->email_verified_at) {
            return back()->with('error', 'El estudiante no tiene una cuenta pendiente de activación.');
        }

        $enviado = $activation->sendLink($user);

        return back()->with(
            $enviado ? 'success' : 'error',
            $enviado
                ? 'Se envió un nuevo enlace de activación.'
                : 'No fue posible enviar el correo. Comprueba la configuración SMTP o inténtalo nuevamente.'
        );
    }

    public function destroy(Estudiante $estudiante)
    {
        DB::transaction(function () use ($estudiante) {

            $user = $estudiante->user;

            // La relación user_id tiene eliminación en cascada.
            if ($user) {
                Password::deleteToken($user);
                $user->delete();
            } else {
                $estudiante->delete();
            }
        });

        return redirect()
            ->route('estudiantes.index')
            ->with('success', 'Estudiante eliminado del sistema.');
    }
}
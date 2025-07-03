<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Models\Ciudadano;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }


        public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        try {
            DB::transaction(function () use ($user, $request) {
                // Guardar datos del usuario
                $user->save();

                // Guardar o actualizar datos del ciudadano
                Ciudadano::updateOrCreate(
                    ['id' => $user->id], // clave primaria
                    [
                        'nacionalidad' => $request->nacionalidad,
                        'tipo_identificacion' => $request->tipoIdentificacion,
                        'numero_identificacion' => $request->numeroIdentificacion,
                        'fecha_expedicion' => $request->fechaExpedicion,
                        'telefono' => $request->telefono,
                        'tipo_direccion' => $request->tipoDireccion,
                        'barrio' => $request->barrio,
                        'direccion' => $request->direccion,
                    ]
                );
            });

            return redirect()->route('profile.edit')->with([
            'status' => 'success',
            'message' => '¡Información actualizada con éxito!'
        ]);

        } catch (ValidationException $e) {
            Log::error('Errores de validación:', $e->errors());
            return redirect()->back()->withErrors($e->errors())->withInput();

        } catch (\Exception $e) {
            Log::error('Error general:', ['message' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Ocurrió un error al guardar.');
        }
    }


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}

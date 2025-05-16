<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
USE App\Models\Ciudadano;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log; // Importa la clase Log

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
public function store(Request $request): RedirectResponse
{

    try {

        return DB::transaction(function () use ($request) {

            $request->validate([
                'nacionalidad' => ['required', 'string', 'max:30'],
                'tipoIdentificacion' => ['required', 'string', 'max:5', 'in:CC,CE,PA,DE,PEP,PPT'],
                'numeroIdentificacion' => ['required', 'string', 'max:20', 'unique:ciudadanos,numero_identificacion'],
                'fechaExpedicion' => ['required', 'date'],
                'telefono' => ['required', 'string', 'max:15'],
                'tipoDireccion' => ['required', 'string', 'max:15'],
                'barrio'  => ['required', 'string', 'max:50'],
                'direccion' => ['required', 'string', 'max:50'],
                'nombre' => ['required', 'string', 'max:100'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:100', 'unique:'.User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            $user = User::create([
                'nombre' => $request->nombre,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'rol' => 'ciudadano'
            ]);

            Ciudadano::create([
                'id' => $user->id, // Asocia el ciudadano al usuario recién creado
                'nacionalidad' => $request->nacionalidad,
                'tipo_identificacion' => $request->tipoIdentificacion,
                'numero_identificacion' => $request->numeroIdentificacion,
                'fecha_expedicion' => $request->fechaExpedicion,
                'telefono' => $request->telefono,
                'tipo_direccion' => $request->tipoDireccion,
                'barrio'=>$request->barrio,
                'direccion' => $request->direccion,
            ]);

            event(new Registered($user));

            Auth::login($user);

            return redirect(route('dashboard', absolute: false));
        });

        } catch (ValidationException $e) {
            Log::error('Errores de validación:', $e->errors());
            return redirect()->back()->withErrors($e->errors())->withInput();

        } catch (\Exception $e) {
            Log::error('Error general:', ['message' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Ocurrió un error al guardar.');
        }
    }
}

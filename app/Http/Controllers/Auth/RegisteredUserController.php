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
                'tipoIdentificacion' => ['required', 'string', 'max:5', 'in:CC,CE,PA,DE,RC,TI,PEP,PPT'],
                'numeroIdentificacion' => ['required', 'string', 'max:20', 'unique:ciudadanos,numero_identificacion', 'regex:/^[A-Za-z0-9]+$/'],
                'fechaExpedicion' => ['required', 'date'],
                // 'telefono' => ['required', 'string', 'max:15'],
                'tipoDireccion' => ['required', 'string', 'max:15'],
                'barrio'  => ['required', 'string', 'max:50'],
                'direccion' => ['required', 'string', 'max:50'],
                'nombre' => ['required', 'string', 'max:100'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:100', 'unique:'.User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ], $this->validationMessages());

            $user = User::create([
                'nombre' => strtoupper($request->nombre),
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

    protected function validationMessages()
    {
        return [
            'nacionalidad.required' => 'La nacionalidad es obligatoria.',
            'nacionalidad.string' => 'La nacionalidad debe ser una cadena de texto.',
            'nacionalidad.max' => 'La nacionalidad no puede tener más de 30 caracteres.',

            'tipoIdentificacion.required' => 'El tipo de identificación es obligatorio.',
            'tipoIdentificacion.string' => 'El tipo de identificación debe ser una cadena de texto.',
            'tipoIdentificacion.max' => 'El tipo de identificación no puede tener más de 5 caracteres.',
            'tipoIdentificacion.in' => 'El tipo de identificación no es válido. Valores permitidos: CC, CE, PA, DE, RC, TI, PEP, PPT.',

            'numeroIdentificacion.required' => 'El número de identificación es obligatorio.',
            'numeroIdentificacion.string' => 'El número de identificación debe ser una cadena de texto.',
            'numeroIdentificacion.max' => 'El número de identificación no puede tener más de 20 caracteres.',
            'numeroIdentificacion.unique' => 'Este número de identificación ya está registrado.',
            'numeroIdentificacion.regex' => 'El número de documento no debe contener puntos, comas ni espacios.',

            'fechaExpedicion.required' => 'La fecha de expedición es obligatoria.',
            'fechaExpedicion.date' => 'La fecha de expedición debe ser una fecha válida.',

            // 'telefono.required' => 'El teléfono es obligatorio.',
            // 'telefono.string' => 'El teléfono debe ser una cadena de texto.',
            // 'telefono.max' => 'El teléfono no puede tener más de 15 caracteres.',

            'tipoDireccion.required' => 'El tipo de dirección es obligatorio.',
            'tipoDireccion.string' => 'El tipo de dirección debe ser una cadena de texto.',
            'tipoDireccion.max' => 'El tipo de dirección no puede tener más de 15 caracteres.',

            'barrio.required' => 'El barrio es obligatorio.',
            'barrio.string' => 'El barrio debe ser una cadena de texto.',
            'barrio.max' => 'El barrio no puede tener más de 50 caracteres.',

            'direccion.required' => 'La dirección es obligatoria.',
            'direccion.string' => 'La dirección debe ser una cadena de texto.',
            'direccion.max' => 'La dirección no puede tener más de 50 caracteres.',

            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.string' => 'El nombre debe ser una cadena de texto.',
            'nombre.max' => 'El nombre no puede tener más de 100 caracteres.',

            'email.required' => 'El correo electrónico es obligatorio.',
            'email.string' => 'El correo electrónico debe ser una cadena de texto.',
            'email.lowercase' => 'El correo electrónico debe estar en minúsculas.',
            'email.email' => 'El correo electrónico debe tener un formato válido.',
            'email.max' => 'El correo electrónico no puede tener más de 100 caracteres.',
            'email.unique' => 'Este correo electrónico ya está registrado.',

            'password.required' => 'La contraseña es obligatoria.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
            // Laravel automáticamente añade mensajes para las reglas por defecto de `Rules\Password::defaults()`
        ];
    }


}

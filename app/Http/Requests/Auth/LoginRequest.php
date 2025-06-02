<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\Ciudadano;
use Illuminate\Support\Facades\Log; // Importa la clase Log

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
        public function rules(): array
        {
            return [
                'email' => [
                    'required',
                    'string',
                    function ($attribute, $value, $fail) {
                        // Si es correo electrónico, debe ser válido
                        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
                            if (! filter_var($value, FILTER_VALIDATE_EMAIL)) {
                                $fail('El correo electrónico no es válido.');
                            }
                        } else {
                            // Si no es correo, debe ser solo dígitos (o lo que acepte tu documento)
                            if (! preg_match('/^\d{4,15}$/', $value)) {
                                $fail('El número de documento no es válido.');
                            }
                        }
                    },
                ],
                'password' => ['required', 'string', 'min:8'], // u otro mínimo de seguridad
            ];
        }


    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    // public function authenticate(): void
    // {
    //     $this->ensureIsNotRateLimited();

    //     if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
    //         RateLimiter::hit($this->throttleKey());

    //         throw ValidationException::withMessages([
    //             'email' => trans('auth.failed'),
    //         ]);
    //     }

    //     RateLimiter::clear($this->throttleKey());
    // }
        public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $login = $this->input('email'); // el input puede ser correo o documento
        $password = $this->input('password');

        $credentials = [];

        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            // Es correo
            $credentials['email'] = $login;
        } else {
            // Es documento, buscar al usuario por número_identificacion
            $ciudadano = Ciudadano::where('numero_identificacion', $login)->first();
            if ($ciudadano) {
                $credentials['id'] = $ciudadano->id; // el id es la clave primaria del user
            } else {
                throw ValidationException::withMessages([
                    'email' => __('auth.failed'),
                ]);
            }
        }

        $credentials['password'] = $password;

        if (! Auth::attempt($credentials, $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }


        public function messages(): array
    {
        return [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.string' => 'El correo electrónico debe ser una cadena de texto.',
            'email.email' => 'El correo electrónico debe tener un formato válido.',
            'email.max' => 'El correo electrónico no puede tener más de 100 caracteres.',

            'password.required' => 'La contraseña es obligatoria.',
            'password.string' => 'La contraseña debe ser una cadena de texto.',
        ];
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
}

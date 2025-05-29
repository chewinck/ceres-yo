<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function rules(): array
    {
 
        return [
            'nacionalidad' => ['required', 'string', 'max:30'],
            'tipoIdentificacion' => ['required', 'string', 'max:5', 'in:CC,CE,PA,DE,RC,TI,PEP,PPT'],
            'numeroIdentificacion' => [
                'required',
                'string',
                'max:20',
                Rule::unique('ciudadanos', 'numero_identificacion')->ignore(Auth::id()),
                'regex:/^[A-Za-z0-9]+$/',
            ],
            'fechaExpedicion' => ['required', 'date'],
            'tipoDireccion' => ['required', 'string', 'max:15'],
            'barrio'  => ['required', 'string', 'max:50'],
            'direccion' => ['required', 'string', 'max:50'],
            'nombre' => ['required', 'string', 'max:100'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
        ];
    }

     public function messages(): array
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
        ];
    }
}

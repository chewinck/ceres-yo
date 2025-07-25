<?php

Namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;


class GenerarCertificadoFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $rules =  [
            'tipoCertificado' => ['required', 'string', 'max:5', 'in:EVE,PPL,PEPA,TAPEP'],
            'categoriaCertificado' => ['required', 'string', 'max:12', 'in:automatica,excepcional'],
            'documento' => 'nullable|file|mimes:pdf|max:3240'
        ];

        if ($this->input('tipoCertificado') === 'PPL') {
            $rules += [
                'nombrePPL' => ['required', 'string', 'max:100'],
                'tipoDocumentoPPL' => ['required', 'string', 'max:50'],
                'numeroDocumentoPPL' => ['required', 'string', 'max:15'],
                'numeroExpedientePPL' => ['required', 'string', 'max:30'],
                'nombreJuzgado' => ['required', 'string', 'max:100'],
            ];
        }

        return $rules;
    }
}
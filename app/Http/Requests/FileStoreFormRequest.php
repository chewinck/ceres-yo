<?php

Namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FileStoreFormRequest extends FormRequest
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
        return [
            'documento_pdf' => 'required|file|mimes:pdf|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'documento_pdf.required' => 'El archivo PDF es obligatorio.',
            'documento_pdf.mimes'    => 'El archivo debe ser un PDF válido.',
            'documento_pdf.max'      => 'El archivo no puede superar los 2MB.',
        ];
    }
}
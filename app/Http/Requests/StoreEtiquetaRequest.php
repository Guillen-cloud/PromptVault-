<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEtiquetaRequest extends FormRequest
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
            'nombre' => ['required', 'string', 'max:50', 'unique:etiquetas,nombre'],
            'color' => ['nullable', 'string', 'max:7'], // Para hex color #FFFFFF
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre de la etiqueta es obligatorio',
            'nombre.max' => 'El nombre no puede exceder los 50 caracteres',
            'nombre.unique' => 'Ya existe una etiqueta con este nombre',
        ];
    }
}

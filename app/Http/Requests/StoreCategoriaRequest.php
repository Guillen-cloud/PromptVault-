<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoriaRequest extends FormRequest
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
            'nombre' => ['required', 'string', 'max:60', 'unique:categorias,nombre'],
            'descripcion' => ['nullable', 'string', 'max:300'],
            'color' => ['nullable', 'string', 'max:7'], // Para hex color #FFFFFF
            'icono' => ['nullable', 'string', 'max:50'],
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
            'nombre.required' => 'El nombre de la categoría es obligatorio',
            'nombre.max' => 'El nombre no puede exceder los 60 caracteres',
            'nombre.unique' => 'Ya existe una categoría con este nombre',
            'descripcion.max' => 'La descripción no puede exceder los 300 caracteres',
        ];
    }
}

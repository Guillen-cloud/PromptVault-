<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePromptRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // La autorización se maneja en policies
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'titulo' => ['sometimes', 'required', 'string', 'max:180'],
            'contenido' => ['sometimes', 'required', 'string'],
            'descripcion' => ['nullable', 'string', 'max:500'],
            'categoria_id' => ['sometimes', 'required', 'integer', 'exists:categorias,id'],
            'ia_destino' => ['sometimes', 'required', 'string', 'max:60'],
            'es_favorito' => ['boolean'],
            'es_publico' => ['boolean'],
            'etiquetas' => ['array'],
            'etiquetas.*' => ['integer', 'exists:etiquetas,id'],
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
            'titulo.required' => 'El título es obligatorio',
            'titulo.max' => 'El título no puede exceder los 180 caracteres',
            'contenido.required' => 'El contenido del prompt es obligatorio',
            'categoria_id.required' => 'Debes seleccionar una categoría',
            'categoria_id.exists' => 'La categoría seleccionada no existe',
            'ia_destino.required' => 'Debes especificar la IA destino',
            'ia_destino.max' => 'La IA destino no puede exceder los 60 caracteres',
            'etiquetas.*.exists' => 'Una o más etiquetas seleccionadas no existen',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('es_favorito')) {
            $this->merge(['es_favorito' => $this->boolean('es_favorito')]);
        }
        if ($this->has('es_publico')) {
            $this->merge(['es_publico' => $this->boolean('es_publico')]);
        }
    }
}

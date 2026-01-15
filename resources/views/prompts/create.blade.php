@extends('layouts.app')

@section('title', 'Crear Nuevo Prompt - PromptVault')

@section('breadcrumbs')
<a href="{{ route('prompts.index') }}" class="breadcrumb-item">
    <i class="fas fa-file-alt"></i> Prompts
</a>
<span class="breadcrumb-separator">/</span>
<span class="breadcrumb-item active">Crear</span>
@endsection

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">📝 Crear Nuevo Prompt</h1>
        <p class="page-subtitle">Completa la información del prompt</p>
    </div>
    <div class="page-header-actions">
        <a href="{{ route('prompts.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>
</div>

<div class="card">
    <form action="{{ route('prompts.store') }}" method="POST">
        @csrf

        <!-- Título -->
        <div class="form-group">
            <label for="titulo" class="form-label">
                Título del Prompt <span style="color: var(--danger-red);">*</span>
            </label>
            <input 
                type="text" 
                name="titulo" 
                id="titulo"
                value="{{ old('titulo') }}"
                required
                maxlength="100"
                placeholder="Ej: Explicar código Python"
                class="form-input @error('titulo') error @enderror"
            >
            @error('titulo')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <!-- Contenido -->
        <div class="form-group">
            <label for="contenido" class="form-label">
                Contenido del Prompt <span style="color: var(--danger-red);">*</span>
            </label>
            <textarea 
                name="contenido" 
                id="contenido"
                required
                rows="8"
                placeholder="Escribe aquí el texto del prompt que usarás con la IA..."
                class="form-input @error('contenido') error @enderror"
            >{{ old('contenido') }}</textarea>
            @error('contenido')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <!-- Descripción -->
        <div class="form-group">
            <label for="descripcion" class="form-label">
                Descripción (¿Para qué sirve?)
            </label>
            <textarea 
                name="descripcion" 
                id="descripcion"
                rows="3"
                placeholder="Describe brevemente para qué usarás este prompt..."
                class="form-input @error('descripcion') error @enderror"
            >{{ old('descripcion') }}</textarea>
            @error('descripcion')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 1.5rem;">
            <!-- Categoría -->
            <div class="form-group" style="margin-bottom: 0;">
                <label for="categoria_id" class="form-label">
                    📁 Categoría <span style="color: var(--danger-red);">*</span>
                </label>
                <select 
                    name="categoria_id" 
                    id="categoria_id"
                    required
                    class="form-input @error('categoria_id') error @enderror"
                >
                    <option value="">Selecciona una categoría</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                            {{ $categoria->icono }} {{ $categoria->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('categoria_id')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- IA Destino -->
            <div class="form-group" style="margin-bottom: 0;">
                <label for="ia_destino" class="form-label">
                    🤖 IA Destino <span style="color: var(--danger-red);">*</span>
                </label>
                <select 
                    name="ia_destino" 
                    id="ia_destino"
                    required
                    class="form-input @error('ia_destino') error @enderror"
                >
                    <option value="General" {{ old('ia_destino', 'General') == 'General' ? 'selected' : '' }}>General</option>
                    <option value="ChatGPT" {{ old('ia_destino') == 'ChatGPT' ? 'selected' : '' }}>ChatGPT</option>
                    <option value="Claude" {{ old('ia_destino') == 'Claude' ? 'selected' : '' }}>Claude</option>
                    <option value="Gemini" {{ old('ia_destino') == 'Gemini' ? 'selected' : '' }}>Gemini</option>
                    <option value="Copilot" {{ old('ia_destino') == 'Copilot' ? 'selected' : '' }}>Copilot</option>
                </select>
                @error('ia_destino')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Etiquetas -->
        <div class="form-group">
            <label class="form-label">
                🏷️ Etiquetas
            </label>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 0.75rem;">
                @foreach($etiquetas as $etiqueta)
                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                        <input 
                            type="checkbox" 
                            name="etiquetas[]" 
                            value="{{ $etiqueta->id }}"
                            {{ in_array($etiqueta->id, old('etiquetas', [])) ? 'checked' : '' }}
                            style="cursor: pointer;"
                        >
                        <span style="font-size: 0.875rem;">
                            #{{ $etiqueta->nombre }}
                        </span>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- Público -->
        <div class="form-group">
            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                <input 
                    type="checkbox" 
                    name="es_publico" 
                    value="1"
                    {{ old('es_publico') ? 'checked' : '' }}
                    style="cursor: pointer;"
                >
                <span style="font-size: 0.875rem;">
                    🌐 Marcar como público (puede ser visto por otros)
                </span>
            </label>
        </div>

        <!-- Botones -->
        <div style="display: flex; align-items: center; justify-content: flex-end; gap: 0.75rem; padding-top: 1.5rem; border-top: 1px solid var(--border-gray);">
            <a href="{{ route('prompts.index') }}" class="btn btn-secondary">
                Cancelar
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-check"></i> Crear Prompt
            </button>
        </div>
    </form>
</div>
@endsection

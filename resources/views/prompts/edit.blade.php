@extends('layouts.app')

@section('title', 'Editar ' . $prompt->titulo . ' - PromptVault')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">✏️ Editar Prompt</h1>
        <p class="page-subtitle">Modifica la información del prompt</p>
    </div>
    <div class="page-header-actions" style="display: flex; align-items: center; gap: 1rem;">
        <span class="badge" style="background: var(--primary-blue); font-size: 0.875rem; padding: 0.5rem 1rem;">
            <i class="fas fa-code-branch"></i> Versión actual: v{{ $prompt->version_actual }}
        </span>
        @if($prompt->versiones->count() > 0)
        <a href="{{ route('versiones.index', ['prompt' => $prompt->id]) }}" class="btn btn-secondary" title="Ver historial de versiones">
            <i class="fas fa-history"></i> Ver historial ({{ $prompt->versiones->count() }})
        </a>
        @endif
        <a href="{{ route('prompts.index') }}" class="btn btn-secondary">
            <i class="fas fa-times"></i> Cancelar
        </a>
    </div>
</div>

<div class="card">
    <form action="{{ route('prompts.update', $prompt) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Título -->
        <div class="form-group">
            <label for="titulo" class="form-label">
                Título del Prompt <span style="color: var(--danger-red);">*</span>
            </label>
            <input 
                type="text" 
                name="titulo" 
                id="titulo"
                value="{{ old('titulo', $prompt->titulo) }}"
                required
                maxlength="100"
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
                class="form-input @error('contenido') error @enderror"
            >{{ old('contenido', $prompt->contenido) }}</textarea>
            @error('contenido')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <!-- Motivo del cambio -->
        <div class="form-group" style="background: #fef3c7; border: 1px solid #fbbf24; border-radius: 8px; padding: 1rem;">
            <label for="motivo_cambio" class="form-label">
                💭 Motivo del cambio (opcional)
            </label>
            <input 
                type="text" 
                name="motivo_cambio" 
                id="motivo_cambio"
                value="{{ old('motivo_cambio') }}"
                maxlength="200"
                placeholder="Ej: Mejora en la claridad de las instrucciones"
                class="form-input"
            >
            <p style="margin-top: 0.25rem; font-size: 0.75rem; color: var(--text-gray);">Si modificas el contenido, se creará una nueva versión. Explica brevemente por qué.</p>
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
                class="form-input @error('descripcion') error @enderror"
            >{{ old('descripcion', $prompt->descripcion) }}</textarea>
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
                        <option value="{{ $categoria->id }}" {{ old('categoria_id', $prompt->categoria_id) == $categoria->id ? 'selected' : '' }}>
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
                    <option value="General" {{ old('ia_destino', $prompt->ia_destino) == 'General' ? 'selected' : '' }}>General</option>
                    <option value="ChatGPT" {{ old('ia_destino', $prompt->ia_destino) == 'ChatGPT' ? 'selected' : '' }}>ChatGPT</option>
                    <option value="Claude" {{ old('ia_destino', $prompt->ia_destino) == 'Claude' ? 'selected' : '' }}>Claude</option>
                    <option value="Gemini" {{ old('ia_destino', $prompt->ia_destino) == 'Gemini' ? 'selected' : '' }}>Gemini</option>
                    <option value="Copilot" {{ old('ia_destino', $prompt->ia_destino) == 'Copilot' ? 'selected' : '' }}>Copilot</option>
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
                            {{ in_array($etiqueta->id, old('etiquetas', $prompt->etiquetas->pluck('id')->toArray())) ? 'checked' : '' }}
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
                    {{ old('es_publico', $prompt->es_publico) ? 'checked' : '' }}
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
                <i class="fas fa-save"></i> Guardar Cambios
            </button>
        </div>
    </form>
</div>
@endsection

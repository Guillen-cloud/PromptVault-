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
        <h1 class="page-title">Crear Nuevo Prompt</h1>
        <p class="page-subtitle">Completa la información y ve el preview en tiempo real</p>
    </div>
    <div class="page-header-actions">
        <a href="{{ route('prompts.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>
</div>

<div class="create-prompt-layout">
    <!-- Formulario -->
    <div class="form-section">
        <div class="card">
            <form action="{{ route('prompts.store') }}" method="POST" id="promptForm">
                @csrf

                <!-- Título -->
                <div class="form-group">
                    <label for="titulo" class="form-label">
                        Título del Prompt <span class="required">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="titulo" 
                        id="titulo"
                        value="{{ old('titulo') }}"
                        required
                        maxlength="100"
                        placeholder="Ej: Explicar código Python paso a paso"
                        class="form-input @error('titulo') error @enderror"
                    >
                    <div class="form-helper">
                        <span id="tituloCounter" class="char-counter">0/100 caracteres</span>
                    </div>
                    @error('titulo')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Descripción -->
                <div class="form-group">
                    <label for="descripcion" class="form-label">
                        Descripción
                        <span class="label-hint">(¿Para qué sirve este prompt?)</span>
                    </label>
                    <textarea 
                        name="descripcion" 
                        id="descripcion"
                        rows="3"
                        maxlength="250"
                        placeholder="Describe brevemente el propósito y uso de este prompt..."
                        class="form-input @error('descripcion') error @enderror"
                    >{{ old('descripcion') }}</textarea>
                    <div class="form-helper">
                        <span id="descripcionCounter" class="char-counter">0/250 caracteres</span>
                    </div>
                    @error('descripcion')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Contenido -->
                <div class="form-group">
                    <label for="contenido" class="form-label">
                        Contenido del Prompt <span class="required">*</span>
                    </label>
                    <div class="textarea-toolbar">
                        <button type="button" class="toolbar-btn" onclick="insertVariable('{contexto}')" title="Insertar variable contexto">
                            <i class="fas fa-file-alt"></i> {contexto}
                        </button>
                        <button type="button" class="toolbar-btn" onclick="insertVariable('{tarea}')" title="Insertar variable tarea">
                            <i class="fas fa-tasks"></i> {tarea}
                        </button>
                        <button type="button" class="toolbar-btn" onclick="insertVariable('{formato}')" title="Insertar variable formato">
                            <i class="fas fa-align-left"></i> {formato}
                        </button>
                        <button type="button" class="toolbar-btn" onclick="insertVariable('{idioma}')" title="Insertar variable idioma">
                            <i class="fas fa-language"></i> {idioma}
                        </button>
                    </div>
                    <textarea 
                        name="contenido" 
                        id="contenido"
                        required
                        rows="12"
                        placeholder="Escribe el prompt que usarás con la IA. Puedes usar variables como {contexto}, {tarea}, {formato}..."
                        class="form-input content-textarea @error('contenido') error @enderror"
                    >{{ old('contenido') }}</textarea>
                    <div class="form-helper">
                        <span id="contenidoCounter" class="char-counter">0 caracteres</span>
                        <span class="helper-text">💡 Usa variables para hacer tu prompt reutilizable</span>
                    </div>
                    @error('contenido')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Categoría con Cards Visuales -->
                <div class="form-group">
                    <label class="form-label">
                        📁 Categoría <span class="required">*</span>
                    </label>
                    <div class="category-grid">
                        @foreach($categorias as $categoria)
                            <label class="category-card">
                                <input 
                                    type="radio" 
                                    name="categoria_id" 
                                    value="{{ $categoria->id }}"
                                    {{ old('categoria_id') == $categoria->id ? 'checked' : '' }}
                                    required
                                >
                                <div class="category-card-content">
                                    <span class="category-icon">{{ $categoria->icono }}</span>
                                    <span class="category-name">{{ $categoria->nombre }}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    @error('categoria_id')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- IA Destino -->
                <div class="form-group">
                    <label class="form-label">
                        🤖 IA Destino <span class="required">*</span>
                    </label>
                    <div class="ia-selector">
                        <label class="ia-option">
                            <input type="radio" name="ia_destino" value="General" {{ old('ia_destino', 'General') == 'General' ? 'checked' : '' }} required>
                            <span class="ia-badge">
                                <i class="fas fa-robot"></i> General
                            </span>
                        </label>
                        <label class="ia-option">
                            <input type="radio" name="ia_destino" value="ChatGPT" {{ old('ia_destino') == 'ChatGPT' ? 'checked' : '' }}>
                            <span class="ia-badge">
                                <i class="fas fa-comment-dots"></i> ChatGPT
                            </span>
                        </label>
                        <label class="ia-option">
                            <input type="radio" name="ia_destino" value="Claude" {{ old('ia_destino') == 'Claude' ? 'checked' : '' }}>
                            <span class="ia-badge">
                                <i class="fas fa-brain"></i> Claude
                            </span>
                        </label>
                        <label class="ia-option">
                            <input type="radio" name="ia_destino" value="Gemini" {{ old('ia_destino') == 'Gemini' ? 'checked' : '' }}>
                            <span class="ia-badge">
                                <i class="fas fa-gem"></i> Gemini
                            </span>
                        </label>
                        <label class="ia-option">
                            <input type="radio" name="ia_destino" value="Copilot" {{ old('ia_destino') == 'Copilot' ? 'checked' : '' }}>
                            <span class="ia-badge">
                                <i class="fas fa-code"></i> Copilot
                            </span>
                        </label>
                    </div>
                    @error('ia_destino')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Etiquetas -->
                <div class="form-group">
                    <label class="form-label">
                        🏷️ Etiquetas
                        <span class="label-hint">(Selecciona las que apliquen)</span>
                    </label>
                    <div class="tags-grid">
                        @foreach($etiquetas as $etiqueta)
                            <label class="tag-checkbox">
                                <input 
                                    type="checkbox" 
                                    name="etiquetas[]" 
                                    value="{{ $etiqueta->id }}"
                                    {{ in_array($etiqueta->id, old('etiquetas', [])) ? 'checked' : '' }}
                                >
                                <span class="tag-label">
                                    <i class="fas fa-tag"></i> {{ $etiqueta->nombre }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Opciones adicionales -->
                <div class="form-group">
                    <div class="checkbox-group">
                        <label class="checkbox-option">
                            <input 
                                type="checkbox" 
                                name="es_publico" 
                                value="1"
                                {{ old('es_publico') ? 'checked' : '' }}
                            >
                            <span class="checkbox-label">
                                <i class="fas fa-globe"></i> Marcar como público
                                <span class="checkbox-hint">Otros usuarios podrán ver este prompt</span>
                            </span>
                        </label>
                        <label class="checkbox-option">
                            <input 
                                type="checkbox" 
                                name="favorito" 
                                value="1"
                                {{ old('favorito') ? 'checked' : '' }}
                            >
                            <span class="checkbox-label">
                                <i class="fas fa-star" style="color: #fbbf24;"></i> Marcar como favorito
                                <span class="checkbox-hint">Acceso rápido desde tus favoritos</span>
                            </span>
                        </label>
                    </div>
                </div>

                <!-- Botones -->
                <div class="form-actions">
                    <a href="{{ route('prompts.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check"></i> Crear Prompt
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Preview Panel -->
    <div class="preview-section">
        <div class="preview-card sticky-preview">
            <div class="preview-header">
                <h3><i class="fas fa-eye"></i> Preview</h3>
                <span class="preview-badge">Vista previa</span>
            </div>
            
            <div class="preview-content">
                <div class="preview-prompt-card">
                    <div class="preview-card-header">
                        <div class="preview-title">
                            <h4 id="previewTitulo">Título de tu prompt</h4>
                        </div>
                        <div class="preview-badges">
                            <span class="preview-badge-cat" id="previewCategoria">Categoría</span>
                            <span class="preview-badge-ia" id="previewIA">General</span>
                        </div>
                    </div>

                    <div class="preview-card-body">
                        <p class="preview-description" id="previewDescripcion">La descripción aparecerá aquí...</p>
                        <div class="preview-content-box">
                            <code id="previewContenido">El contenido del prompt aparecerá aquí...</code>
                        </div>
                    </div>

                    <div class="preview-card-footer">
                        <div class="preview-meta">
                            <span><i class="fas fa-eye"></i> 0 usos</span>
                            <span><i class="fas fa-code-branch"></i> v1.0</span>
                            <span id="previewEtiquetas"><i class="fas fa-tags"></i> 0</span>
                        </div>
                    </div>
                </div>

                <div class="preview-tips">
                    <h4><i class="fas fa-lightbulb"></i> Tips para mejores prompts:</h4>
                    <ul>
                        <li>Sé específico y claro en las instrucciones</li>
                        <li>Usa variables para reutilizar el prompt</li>
                        <li>Define el formato de respuesta esperado</li>
                        <li>Incluye contexto relevante</li>
                        <li>Prueba y refina iterativamente</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.create-prompt-layout {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 2rem;
    margin-top: 2rem;
}

.form-section {
    min-width: 0;
}

.form-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
}

.required {
    color: #ef4444;
}

.label-hint {
    font-weight: 400;
    color: var(--text-gray);
    font-size: 0.813rem;
}

.form-helper {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 0.5rem;
    font-size: 0.75rem;
}

.char-counter {
    color: var(--text-gray);
}

.helper-text {
    color: var(--primary-blue);
}

/* Textarea Toolbar */
.textarea-toolbar {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 0.5rem;
    flex-wrap: wrap;
}

.toolbar-btn {
    padding: 0.5rem 0.75rem;
    background: var(--bg-gray);
    border: 1px solid var(--border-gray);
    border-radius: 6px;
    font-size: 0.75rem;
    color: var(--text-dark);
    cursor: pointer;
    transition: all 0.2s;
    font-family: monospace;
}

.toolbar-btn:hover {
    background: var(--primary-blue);
    color: white;
    border-color: var(--primary-blue);
}

.toolbar-btn i {
    margin-right: 0.25rem;
}

.content-textarea {
    font-family: 'Courier New', monospace;
    font-size: 0.875rem;
    line-height: 1.6;
}

/* Category Cards */
.category-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
    gap: 1rem;
}

.category-card {
    position: relative;
    cursor: pointer;
}

.category-card input[type="radio"] {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}

.category-card-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    padding: 1.25rem 1rem;
    background: var(--bg-white);
    border: 2px solid var(--border-gray);
    border-radius: 12px;
    transition: all 0.2s;
}

.category-card:hover .category-card-content {
    border-color: var(--primary-blue);
    background: #f0f4ff;
}

.category-card input:checked + .category-card-content {
    border-color: var(--primary-blue);
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.category-card input:checked + .category-card-content .category-icon,
.category-card input:checked + .category-card-content .category-name {
    color: white;
}

.category-icon {
    font-size: 2rem;
}

.category-name {
    font-size: 0.875rem;
    font-weight: 600;
    text-align: center;
}

/* IA Selector */
.ia-selector {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.ia-option {
    cursor: pointer;
}

.ia-option input[type="radio"] {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}

.ia-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.625rem 1rem;
    background: var(--bg-gray);
    border: 2px solid var(--border-gray);
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 600;
    transition: all 0.2s;
}

.ia-option:hover .ia-badge {
    border-color: var(--primary-blue);
    background: #f0f4ff;
}

.ia-option input:checked + .ia-badge {
    background: var(--primary-blue);
    border-color: var(--primary-blue);
    color: white;
}

/* Tags */
.tags-grid {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.tag-checkbox {
    cursor: pointer;
}

.tag-checkbox input[type="checkbox"] {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}

.tag-label {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.5rem 0.875rem;
    background: var(--bg-gray);
    border: 1px solid var(--border-gray);
    border-radius: 20px;
    font-size: 0.813rem;
    transition: all 0.2s;
}

.tag-checkbox:hover .tag-label {
    border-color: var(--primary-blue);
    background: #f0f4ff;
}

.tag-checkbox input:checked + .tag-label {
    background: var(--primary-blue);
    border-color: var(--primary-blue);
    color: white;
}

/* Checkbox Options */
.checkbox-group {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.checkbox-option {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    padding: 1rem;
    background: var(--bg-gray);
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s;
}

.checkbox-option:hover {
    background: #f0f4ff;
}

.checkbox-option input[type="checkbox"] {
    margin-top: 0.125rem;
    cursor: pointer;
}

.checkbox-label {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.checkbox-label i {
    margin-right: 0.375rem;
}

.checkbox-hint {
    font-size: 0.75rem;
    color: var(--text-gray);
}

/* Form Actions */
.form-actions {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 1rem;
    padding-top: 1.5rem;
    border-top: 1px solid var(--border-gray);
}

/* Preview Section */
.preview-section {
    position: relative;
}

.sticky-preview {
    position: sticky;
    top: calc(var(--header-height) + 2rem);
}

.preview-card {
    background: var(--bg-white);
    border: 1px solid var(--border-gray);
    border-radius: 12px;
    overflow: hidden;
}

.preview-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.25rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.preview-header h3 {
    font-size: 1rem;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.preview-badge {
    font-size: 0.75rem;
    padding: 0.25rem 0.625rem;
    background: rgba(255,255,255,0.2);
    border-radius: 12px;
}

.preview-content {
    padding: 1.25rem;
}

.preview-prompt-card {
    background: #f8fafc;
    border: 1px solid var(--border-gray);
    border-radius: 12px;
    padding: 1.25rem;
    margin-bottom: 1.5rem;
}

.preview-card-header {
    margin-bottom: 1rem;
}

.preview-title h4 {
    font-size: 1.125rem;
    color: var(--text-dark);
    margin: 0 0 0.75rem 0;
}

.preview-badges {
    display: flex;
    gap: 0.5rem;
}

.preview-badge-cat {
    padding: 0.375rem 0.75rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 600;
}

.preview-badge-ia {
    padding: 0.375rem 0.75rem;
    background: var(--bg-gray);
    color: var(--text-dark);
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 600;
}

.preview-card-body {
    margin-bottom: 1rem;
}

.preview-description {
    font-size: 0.875rem;
    color: var(--text-gray);
    margin-bottom: 0.75rem;
    font-style: italic;
}

.preview-content-box {
    background: white;
    border-left: 3px solid var(--primary-blue);
    padding: 0.875rem;
    border-radius: 6px;
}

.preview-content-box code {
    font-size: 0.813rem;
    color: #1e293b;
    line-height: 1.6;
    white-space: pre-wrap;
    word-break: break-word;
}

.preview-card-footer {
    padding-top: 1rem;
    border-top: 1px solid var(--border-gray);
}

.preview-meta {
    display: flex;
    gap: 1rem;
    font-size: 0.813rem;
    color: var(--text-gray);
}

.preview-meta span {
    display: flex;
    align-items: center;
    gap: 0.375rem;
}

.preview-tips {
    background: #fffbeb;
    border: 1px solid #fef3c7;
    border-radius: 8px;
    padding: 1rem;
}

.preview-tips h4 {
    font-size: 0.875rem;
    color: #92400e;
    margin: 0 0 0.75rem 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.preview-tips ul {
    margin: 0;
    padding-left: 1.25rem;
}

.preview-tips li {
    font-size: 0.813rem;
    color: #92400e;
    margin-bottom: 0.375rem;
}

/* Responsive */
@media (max-width: 1200px) {
    .create-prompt-layout {
        grid-template-columns: 1fr;
    }

    .preview-section {
        display: none;
    }
}
</style>
@endpush

@push('scripts')
<script>
// Character counters
document.getElementById('titulo').addEventListener('input', function() {
    const count = this.value.length;
    document.getElementById('tituloCounter').textContent = `${count}/100 caracteres`;
    updatePreview();
});

document.getElementById('descripcion').addEventListener('input', function() {
    const count = this.value.length;
    document.getElementById('descripcionCounter').textContent = `${count}/250 caracteres`;
    updatePreview();
});

document.getElementById('contenido').addEventListener('input', function() {
    const count = this.value.length;
    document.getElementById('contenidoCounter').textContent = `${count} caracteres`;
    updatePreview();
});

// Insert variables
function insertVariable(variable) {
    const textarea = document.getElementById('contenido');
    const start = textarea.selectionStart;
    const end = textarea.selectionEnd;
    const text = textarea.value;
    
    textarea.value = text.substring(0, start) + variable + text.substring(end);
    textarea.focus();
    textarea.setSelectionRange(start + variable.length, start + variable.length);
    
    updatePreview();
}

// Update preview
function updatePreview() {
    const titulo = document.getElementById('titulo').value || 'Título de tu prompt';
    const descripcion = document.getElementById('descripcion').value || 'La descripción aparecerá aquí...';
    const contenido = document.getElementById('contenido').value || 'El contenido del prompt aparecerá aquí...';
    
    document.getElementById('previewTitulo').textContent = titulo;
    document.getElementById('previewDescripcion').textContent = descripcion;
    document.getElementById('previewContenido').textContent = contenido;
}

// Update category preview
document.querySelectorAll('input[name="categoria_id"]').forEach(input => {
    input.addEventListener('change', function() {
        const label = this.closest('.category-card').querySelector('.category-name').textContent;
        document.getElementById('previewCategoria').textContent = label;
    });
});

// Update IA preview
document.querySelectorAll('input[name="ia_destino"]').forEach(input => {
    input.addEventListener('change', function() {
        document.getElementById('previewIA').textContent = this.value;
    });
});

// Update tags count
document.querySelectorAll('input[name="etiquetas[]"]').forEach(input => {
    input.addEventListener('change', function() {
        const count = document.querySelectorAll('input[name="etiquetas[]"]:checked').length;
        document.getElementById('previewEtiquetas').innerHTML = `<i class="fas fa-tags"></i> ${count}`;
    });
});

// Initialize preview
updatePreview();
</script>
@endpush

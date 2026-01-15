@extends('layouts.app')

@section('title', 'Mis Prompts')

@section('breadcrumbs')
<a href="{{ route('prompts.index') }}" class="breadcrumb-item active">
    <i class="fas fa-file-alt"></i> Prompts
</a>
@endsection

@section('content')
<div class="page-header-actions">
    <div>
        <h1 class="page-title">{{ __('Mis Prompts') }}</h1>
        <p class="page-subtitle">Gestiona todos tus prompts</p>
    </div>
    <div style="display: flex; gap: 1rem;">
        <a href="{{ route('prompts.export', request()->all()) }}" class="btn btn-secondary">
            <i class="fas fa-download"></i> Exportar CSV
        </a>
        <a href="{{ route('prompts.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nuevo Prompt
        </a>
    </div>
</div>

<!-- Layout con Sidebar y Grid -->
<div class="prompts-layout">
    <!-- Sidebar de Filtros -->
    <aside class="filters-sidebar">
        <div class="filters-section">
            <h3 class="filters-title">
                <i class="fas fa-search"></i> Búsqueda
            </h3>
            <input type="text" class="form-control" placeholder="Buscar prompts..." id="searchInput">
        </div>

        <div class="filters-section">
            <h3 class="filters-title">
                <i class="fas fa-folder"></i> Categorías
            </h3>
            <div class="filter-options">
                <label class="filter-option">
                    <input type="radio" name="categoria" value="" checked>
                    <span>Todas</span>
                    <span class="filter-count">{{ $prompts->total() }}</span>
                </label>
                @foreach($categorias as $categoria)
                <label class="filter-option">
                    <input type="radio" name="categoria" value="{{ $categoria->id }}">
                    <span>{{ $categoria->icono }} {{ $categoria->nombre }}</span>
                    <span class="filter-count">{{ $categoria->prompts_count ?? 0 }}</span>
                </label>
                @endforeach
            </div>
        </div>

        <div class="filters-section">
            <h3 class="filters-title">
                <i class="fas fa-robot"></i> IA Destino
            </h3>
            <div class="filter-options">
                <label class="filter-option">
                    <input type="radio" name="ia_destino" value="" checked>
                    <span>Todas</span>
                </label>
                <label class="filter-option">
                    <input type="radio" name="ia_destino" value="ChatGPT">
                    <span>ChatGPT</span>
                </label>
                <label class="filter-option">
                    <input type="radio" name="ia_destino" value="Claude">
                    <span>Claude</span>
                </label>
                <label class="filter-option">
                    <input type="radio" name="ia_destino" value="Gemini">
                    <span>Gemini</span>
                </label>
                <label class="filter-option">
                    <input type="radio" name="ia_destino" value="General">
                    <span>General</span>
                </label>
            </div>
        </div>

        <div class="filters-section">
            <h3 class="filters-title">
                <i class="fas fa-filter"></i> Estado
            </h3>
            <div class="filter-options">
                <label class="filter-option">
                    <input type="checkbox" name="favorito">
                    <span><i class="fas fa-star" style="color: #fbbf24;"></i> Favoritos</span>
                </label>
                <label class="filter-option">
                    <input type="checkbox" name="publico">
                    <span><i class="fas fa-globe" style="color: #10b981;"></i> Públicos</span>
                </label>
                <label class="filter-option">
                    <input type="checkbox" name="compartido">
                    <span><i class="fas fa-share-alt" style="color: #667eea;"></i> Compartidos</span>
                </label>
            </div>
        </div>

        <button class="btn btn-secondary btn-block" onclick="clearFilters()">
            <i class="fas fa-times"></i> Limpiar Filtros
        </button>
    </aside>

    <!-- Grid de Prompts -->
    <div class="prompts-content">
        <div class="prompts-header">
            <div class="prompts-count">
                <span class="count-number">{{ $prompts->total() }}</span> prompts encontrados
            </div>
            <div class="view-options">
                <select class="form-control form-control-sm" id="sortBy">
                    <option value="created_at">Más recientes</option>
                    <option value="titulo">Alfabético</option>
                    <option value="veces_usado">Más usados</option>
                    <option value="updated_at">Última modificación</option>
                </select>
            </div>
        </div>

        @forelse($prompts as $prompt)
        <div class="prompt-card">
            <div class="prompt-card-header">
                <div class="prompt-card-title">
                    <h3>{{ $prompt->titulo }}</h3>
                    @if($prompt->favorito)
                        <i class="fas fa-star" style="color: #fbbf24;"></i>
                    @endif
                </div>
                <div class="prompt-card-badges">
                    @if($prompt->categoria)
                        <span class="badge badge-category">{{ $prompt->categoria->icono }} {{ $prompt->categoria->nombre }}</span>
                    @endif
                    <span class="badge badge-ia">{{ $prompt->ia_destino }}</span>
                </div>
            </div>

            <div class="prompt-card-body">
                @if($prompt->descripcion)
                    <p class="prompt-description">{{ Str::limit($prompt->descripcion, 120) }}</p>
                @endif
                <div class="prompt-content-preview">
                    <code>{{ Str::limit($prompt->contenido, 150) }}</code>
                </div>
            </div>

            <div class="prompt-card-footer">
                <div class="prompt-card-meta">
                    <span class="meta-item">
                        <i class="fas fa-eye"></i> {{ $prompt->veces_usado }} usos
                    </span>
                    <span class="meta-item">
                        <i class="fas fa-code-branch"></i> v{{ $prompt->version_actual }}
                    </span>
                    @if($prompt->etiquetas && $prompt->etiquetas->count() > 0)
                        <span class="meta-item">
                            <i class="fas fa-tags"></i> {{ $prompt->etiquetas->count() }}
                        </span>
                    @endif
                </div>

                <div class="prompt-card-actions">
                    <button class="action-btn" onclick="copyToClipboard(`{{ addslashes($prompt->contenido) }}`)" title="Copiar">
                        <i class="fas fa-copy"></i>
                    </button>
                    <button class="action-btn {{ $prompt->favorito ? 'active-fav' : '' }}" onclick="toggleFavorite({{ $prompt->id }})" title="Favorito">
                        <i class="fas fa-star"></i>
                    </button>
                    <a href="{{ route('prompts.show', $prompt) }}" class="action-btn" title="Ver">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('prompts.edit', $prompt) }}" class="action-btn" title="Editar">
                        <i class="fas fa-edit"></i>
                    </a>
                    <button onclick="deletePromptFromList({{ $prompt->id }}, '{{ $prompt->titulo }}')" class="action-btn action-btn-danger" title="Eliminar">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="empty-state-card">
            <div class="empty-state-icon">
                <i class="fas fa-inbox"></i>
            </div>
            <h3>No hay prompts</h3>
            <p>Comienza creando tu primer prompt y organiza tu biblioteca de IA</p>
            <a href="{{ route('prompts.create') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-plus"></i> Crear Primer Prompt
            </a>
        </div>
        @endforelse

        @if($prompts->hasPages())
        <div class="pagination-wrapper">
            {{ $prompts->links() }}
        </div>
        @endif
    </div>
</div>

@endsection

@push('styles')
<style>
.prompts-layout {
    display: grid;
    grid-template-columns: 280px 1fr;
    gap: 2rem;
    margin-top: 2rem;
}

/* Filters Sidebar */
.filters-sidebar {
    background: var(--bg-white);
    border-radius: 12px;
    padding: 1.5rem;
    height: fit-content;
    position: sticky;
    top: calc(var(--header-height) + 2rem);
    border: 1px solid var(--border-gray);
}

.filters-section {
    margin-bottom: 2rem;
}

.filters-section:last-of-type {
    margin-bottom: 1rem;
}

.filters-title {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.filters-title i {
    color: var(--primary-blue);
    font-size: 1rem;
}

.filter-options {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.filter-option {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.625rem;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s;
    font-size: 0.875rem;
}

.filter-option:hover {
    background: var(--bg-gray);
}

.filter-option input[type="radio"],
.filter-option input[type="checkbox"] {
    margin: 0;
    cursor: pointer;
}

.filter-option span:first-of-type {
    flex: 1;
}

.filter-count {
    background: var(--bg-gray);
    color: var(--text-gray);
    padding: 0.125rem 0.5rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
}

.btn-block {
    width: 100%;
    justify-content: center;
}

/* Prompts Content */
.prompts-content {
    flex: 1;
}

.prompts-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    padding: 1rem;
    background: var(--bg-white);
    border-radius: 12px;
    border: 1px solid var(--border-gray);
}

.prompts-count {
    font-size: 0.875rem;
    color: var(--text-gray);
}

.count-number {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--primary-blue);
    margin-right: 0.25rem;
}

.view-options select {
    width: auto;
    min-width: 200px;
}

/* Prompt Cards */
.prompt-card {
    background: var(--bg-white);
    border: 1px solid var(--border-gray);
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    transition: all 0.3s ease;
}

.prompt-card:hover {
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    transform: translateY(-2px);
    border-color: var(--primary-blue);
}

.prompt-card-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
}

.prompt-card-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    flex: 1;
}

.prompt-card-title h3 {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--text-dark);
    margin: 0;
}

.prompt-card-badges {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.badge-category {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.badge-ia {
    background: var(--bg-gray);
    color: var(--text-dark);
    font-weight: 600;
}

.prompt-card-body {
    margin-bottom: 1rem;
}

.prompt-description {
    color: var(--text-gray);
    font-size: 0.875rem;
    line-height: 1.6;
    margin-bottom: 0.75rem;
}

.prompt-content-preview {
    background: #f8fafc;
    border-left: 3px solid var(--primary-blue);
    padding: 0.75rem 1rem;
    border-radius: 6px;
    margin-top: 0.75rem;
}

.prompt-content-preview code {
    font-size: 0.813rem;
    color: #1e293b;
    line-height: 1.6;
    font-family: 'Courier New', monospace;
    white-space: pre-wrap;
    word-break: break-word;
}

.prompt-card-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 1rem;
    border-top: 1px solid var(--border-gray);
}

.prompt-card-meta {
    display: flex;
    gap: 1.5rem;
    flex-wrap: wrap;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.375rem;
    font-size: 0.813rem;
    color: var(--text-gray);
}

.meta-item i {
    font-size: 0.875rem;
}

.prompt-card-actions {
    display: flex;
    gap: 0.5rem;
}

.action-btn {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    border: 1px solid var(--border-gray);
    background: transparent;
    color: var(--text-gray);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
}

.action-btn:hover {
    background: var(--primary-blue);
    border-color: var(--primary-blue);
    color: white;
    transform: translateY(-2px);
}

.action-btn-danger:hover {
    background: #ef4444;
    border-color: #ef4444;
}

.action-btn.active-fav i {
    color: #fbbf24;
}

/* Empty State */
.empty-state-card {
    background: var(--bg-white);
    border: 2px dashed var(--border-gray);
    border-radius: 12px;
    padding: 4rem 2rem;
    text-align: center;
}

.empty-state-icon {
    font-size: 4rem;
    color: var(--text-gray);
    margin-bottom: 1.5rem;
    opacity: 0.5;
}

.empty-state-card h3 {
    font-size: 1.5rem;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
}

.empty-state-card p {
    color: var(--text-gray);
    margin-bottom: 2rem;
}

.pagination-wrapper {
    margin-top: 2rem;
}

/* Responsive */
@media (max-width: 1024px) {
    .prompts-layout {
        grid-template-columns: 1fr;
    }

    .filters-sidebar {
        position: static;
    }
}
</style>
@endpush

@push('scripts')
<script>
function deletePromptFromList(id, titulo) {
    Swal.fire({
        title: '¿Eliminar prompt?',
        text: `¿Estás seguro de eliminar "${titulo}"?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '<i class="fas fa-trash"></i> Sí, eliminar',
        cancelButtonText: '<i class="fas fa-times"></i> Cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/prompts/' + id;
            
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = document.querySelector('meta[name="csrf-token"]').content;
            
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            
            form.appendChild(csrfInput);
            form.appendChild(methodInput);
            document.body.appendChild(form);
            form.submit();
        }
    });
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        Swal.fire({
            icon: 'success',
            title: 'Copiado',
            text: 'Prompt copiado al portapapeles',
            timer: 2000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end'
        });
    });
}

function toggleFavorite(id) {
    // Implementar llamada AJAX para marcar/desmarcar favorito
    console.log('Toggle favorite:', id);
}

function clearFilters() {
    document.querySelectorAll('input[type="radio"]').forEach(input => {
        if (input.value === '') input.checked = true;
        else input.checked = false;
    });
    document.querySelectorAll('input[type="checkbox"]').forEach(input => {
        input.checked = false;
    });
    document.getElementById('searchInput').value = '';
}

@if(session('success'))
    Swal.fire({
        icon: 'success',
        title: '¡Éxito!',
        text: '{{ session("success") }}',
        timer: 3000,
        showConfirmButton: false
    });
@endif

@if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: '{{ session("error") }}',
        confirmButtonColor: '#ef4444'
    });
@endif
</script>
@endpush

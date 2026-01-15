@extends('layouts.app')

@section('title', 'Mis Prompts')

@section('content')
<div class="page-header-actions">
    <div>
        <h1 class="page-title">Mis Prompts</h1>
        <p class="page-subtitle">Gestiona todos tus prompts</p>
    </div>
    <a href="{{ route('prompts.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Nuevo Prompt
    </a>
</div>

<!-- Filtros -->
<div class="filters">
    <div class="filter-item">
        <input type="text" class="form-control" placeholder="Buscar prompts...">
    </div>
    <div class="filter-item">
        <select class="form-control">
            <option>Todas las categorías</option>
            @foreach($categorias as $categoria)
                <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
            @endforeach
        </select>
    </div>
    <div class="filter-item">
        <select class="form-control">
            <option>Todas las IAs</option>
            <option>ChatGPT</option>
            <option>Claude</option>
            <option>Gemini</option>
            <option>General</option>
        </select>
    </div>
</div>

<!-- Tabla de Prompts -->
<div class="table-container">
    <table class="table">
        <thead>
            <tr>
                <th>TÍTULO</th>
                <th>CATEGORÍA</th>
                <th>IA DESTINO</th>
                <th>USOS</th>
                <th>VERSIÓN</th>
                <th>ACCIONES</th>
            </tr>
        </thead>
        <tbody>
            @forelse($prompts as $prompt)
            <tr>
                <td>
                    <strong>{{ $prompt->titulo }}</strong>
                </td>
                <td>
                    @if($prompt->categoria)
                    <span>{{ $prompt->categoria->icono }} {{ $prompt->categoria->nombre }}</span>
                    @endif
                </td>
                <td>
                    <span class="badge">{{ $prompt->ia_destino }}</span>
                </td>
                <td>{{ $prompt->veces_usado }}</td>
                <td>v{{ $prompt->version_actual }}</td>
                <td>
                    <a href="{{ route('prompts.show', $prompt) }}" class="action-btn" title="Ver">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('prompts.edit', $prompt) }}" class="action-btn" title="Editar">
                        <i class="fas fa-edit"></i>
                    </a>
                    <button onclick="deletePromptFromList({{ $prompt->id }}, '{{ $prompt->titulo }}')" class="action-btn" title="Eliminar">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6">
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <h3>No hay prompts</h3>
                        <p>Comienza creando tu primer prompt</p>
                        <a href="{{ route('prompts.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Crear Prompt
                        </a>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($prompts->hasPages())
{{ $prompts->links() }}
@endif

<script>
function deletePromptFromList(id, titulo) {
    Swal.fire({
        title: '¿Eliminar prompt?',
        text: `¿Estás seguro de eliminar "${titulo}"?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
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
@endsection

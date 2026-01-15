@extends('layouts.app')

@section('title', 'Categorías')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Categorías</h1>
        <p class="page-subtitle">Organiza tus prompts por categorías</p>
    </div>
    <div class="page-header-actions">
        <button onclick="openCreateModal()" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nueva Categoría
        </button>
    </div>
</div>

<div class="category-grid">
    @foreach($categorias as $categoria)
    <div class="category-card" onclick="viewCategory({{ $categoria->id }}, '{{ $categoria->nombre }}', {{ $categoria->prompts_count }})" style="cursor: pointer;">
        <div class="category-icon 
            @if($categoria->nombre === 'Desarrollo') blue
            @elseif($categoria->nombre === 'Diseño') green
            @elseif($categoria->nombre === 'Marketing') orange
            @else purple
            @endif">
            <i class="fas 
                @if($categoria->nombre === 'Desarrollo') fa-code
                @elseif($categoria->nombre === 'Diseño') fa-palette
                @elseif($categoria->nombre === 'Marketing') fa-bullhorn
                @else fa-chart-bar
                @endif"></i>
        </div>
        <h3 class="category-name">{{ $categoria->nombre }}</h3>
        <p class="category-count">{{ $categoria->prompts_count }} prompts</p>
        <div style="display: flex; gap: 0.5rem; margin-top: 1rem;" onclick="event.stopPropagation();">
            <button onclick="openEditModal({{ $categoria->id }}, '{{ $categoria->nombre }}', '{{ $categoria->descripcion }}', '{{ $categoria->color }}', '{{ $categoria->icono }}')" class="btn btn-sm" style="flex: 1; background: #3b82f6; color: white;">
                <i class="fas fa-edit"></i> Editar
            </button>
            <button onclick="deleteCategory({{ $categoria->id }}, '{{ $categoria->nombre }}')" class="btn btn-sm" style="flex: 1; background: #ef4444; color: white;">
                <i class="fas fa-trash"></i> Eliminar
            </button>
        </div>
    </div>
    @endforeach
</div>

<!-- Modal Crear/Editar Categoría -->
<div id="categoryModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div class="card" style="width: 90%; max-width: 500px; margin: 2rem;">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h2 class="card-title" id="modalTitle">Nueva Categoría</h2>
            <button onclick="closeModal()" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: var(--text-gray);">×</button>
        </div>
        <form id="categoryForm" method="POST">
            @csrf
            <input type="hidden" id="methodField" name="_method" value="POST">
            
            <div class="form-group">
                <label for="nombre" class="form-label">Nombre <span style="color: var(--danger-red);">*</span></label>
                <input type="text" name="nombre" id="nombre" required maxlength="50" class="form-input">
            </div>

            <div class="form-group">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea name="descripcion" id="descripcion" rows="3" class="form-input"></textarea>
            </div>

            <div class="form-group">
                <label for="icono" class="form-label">Icono (emoji) <span style="color: var(--danger-red);">*</span></label>
                <input type="text" name="icono" id="icono" required maxlength="10" placeholder="📁" class="form-input">
            </div>

            <div class="form-group">
                <label for="color" class="form-label">Color <span style="color: var(--danger-red);">*</span></label>
                <input type="color" name="color" id="color" required value="#2563eb" class="form-input" style="height: 50px;">
            </div>

            <div style="display: flex; gap: 0.75rem; justify-content: flex-end; padding-top: 1rem; border-top: 1px solid var(--border-gray);">
                <button type="button" onclick="closeModal()" class="btn btn-secondary">Cancelar</button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Guardar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openCreateModal() {
    document.getElementById('modalTitle').textContent = 'Nueva Categoría';
    document.getElementById('categoryForm').action = '{{ route("categorias.store") }}';
    document.getElementById('methodField').value = 'POST';
    document.getElementById('nombre').value = '';
    document.getElementById('descripcion').value = '';
    document.getElementById('icono').value = '';
    document.getElementById('color').value = '#2563eb';
    document.getElementById('categoryModal').style.display = 'flex';
}

function openEditModal(id, nombre, descripcion, color, icono) {
    document.getElementById('modalTitle').textContent = 'Editar Categoría';
    document.getElementById('categoryForm').action = '/categorias/' + id;
    document.getElementById('methodField').value = 'PUT';
    document.getElementById('nombre').value = nombre;
    document.getElementById('descripcion').value = descripcion || '';
    document.getElementById('icono').value = icono;
    document.getElementById('color').value = color;
    document.getElementById('categoryModal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('categoryModal').style.display = 'none';
}

// Cerrar modal al hacer clic fuera
document.getElementById('categoryModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});

// Ver categoría
function viewCategory(id, nombre, count) {
    window.location.href = '/prompts?categoria=' + id;
}

// Eliminar categoría con SweetAlert
function deleteCategory(id, nombre) {
    Swal.fire({
        title: '¿Eliminar categoría?',
        text: `¿Estás seguro de eliminar "${nombre}"?`,
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
            form.action = '/categorias/' + id;
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = csrfToken;
            
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

// Mostrar mensajes de éxito/error
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

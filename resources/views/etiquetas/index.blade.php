@extends('layouts.app')

@section('title', 'Etiquetas')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Etiquetas</h1>
        <p class="page-subtitle">Gestiona las etiquetas de tus prompts</p>
    </div>
    <div class="page-header-actions">
        <button onclick="openCreateTagModal()" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nueva Etiqueta
        </button>
    </div>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1rem;">
    @foreach($etiquetas as $etiqueta)
    <div class="card" style="padding: 1.25rem; transition: all 0.2s; cursor: pointer; border-left: 4px solid 
        @if($etiqueta->nombre === 'SQL') #2563eb
        @elseif($etiqueta->nombre === 'Python') #10b981
        @elseif($etiqueta->nombre === 'React') #8b5cf6
        @elseif($etiqueta->nombre === 'Testing') #f97316
        @elseif($etiqueta->nombre === 'UX/UI') #ec4899
        @elseif($etiqueta->nombre === 'Backend') #2563eb
        @elseif($etiqueta->nombre === 'Frontend') #10b981
        @else #6366f1
        @endif;"
        onclick="viewTag({{ $etiqueta->id }}, '{{ $etiqueta->nombre }}')"
        onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.1)';"
        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0,0,0,0.1)';">
        
        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.75rem;">
            <div style="flex: 1;">
                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                    <i class="fas fa-tag" style="color: 
                        @if($etiqueta->nombre === 'SQL') #2563eb
                        @elseif($etiqueta->nombre === 'Python') #10b981
                        @elseif($etiqueta->nombre === 'React') #8b5cf6
                        @elseif($etiqueta->nombre === 'Testing') #f97316
                        @elseif($etiqueta->nombre === 'UX/UI') #ec4899
                        @elseif($etiqueta->nombre === 'Backend') #2563eb
                        @elseif($etiqueta->nombre === 'Frontend') #10b981
                        @else #6366f1
                        @endif; font-size: 1.25rem;"></i>
                    <h3 style="font-size: 1.125rem; font-weight: 600; margin: 0;">{{ $etiqueta->nombre }}</h3>
                </div>
                @if($etiqueta->descripcion)
                    <p style="font-size: 0.875rem; color: var(--text-gray); margin: 0;">{{ $etiqueta->descripcion }}</p>
                @endif
            </div>
            <div style="display: flex; gap: 0.25rem;" onclick="event.stopPropagation();">
                <button onclick="openEditTagModal({{ $etiqueta->id }}, '{{ $etiqueta->nombre }}', '{{ $etiqueta->descripcion ?? '' }}')" 
                    class="action-btn" title="Editar" 
                    style="background: #3b82f6; color: white; border: none; padding: 0.375rem; border-radius: 6px; cursor: pointer; display: flex; align-items: center; justify-content: center; width: 32px; height: 32px;">
                    <i class="fas fa-edit"></i>
                </button>
                <button onclick="deleteTag({{ $etiqueta->id }}, '{{ $etiqueta->nombre }}')" 
                    class="action-btn" title="Eliminar"
                    style="background: #ef4444; color: white; border: none; padding: 0.375rem; border-radius: 6px; cursor: pointer; display: flex; align-items: center; justify-content: center; width: 32px; height: 32px;">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
        
        <div style="display: flex; align-items: center; justify-content: space-between; padding-top: 0.75rem; border-top: 1px solid var(--border-gray);">
            <span style="font-size: 0.875rem; color: var(--text-gray);">
                <i class="fas fa-file-alt"></i> {{ $etiqueta->prompts_count }} {{ $etiqueta->prompts_count == 1 ? 'prompt' : 'prompts' }}
            </span>
            <span style="font-size: 0.75rem; color: var(--primary-blue); font-weight: 500;">
                Ver prompts <i class="fas fa-arrow-right"></i>
            </span>
        </div>
    </div>
    @endforeach
</div>

<!-- Modal Crear/Editar Etiqueta -->
<div id="tagModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div class="card" style="width: 90%; max-width: 500px; margin: 2rem;">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h2 class="card-title" id="tagModalTitle">Nueva Etiqueta</h2>
            <button onclick="closeTagModal()" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: var(--text-gray);">×</button>
        </div>
        <form id="tagForm" method="POST">
            @csrf
            <input type="hidden" id="tagMethodField" name="_method" value="POST">
            
            <div class="form-group">
                <label for="tagNombre" class="form-label">Nombre <span style="color: var(--danger-red);">*</span></label>
                <input type="text" name="nombre" id="tagNombre" required maxlength="30" class="form-input">
            </div>

            <div class="form-group">
                <label for="tagDescripcion" class="form-label">Descripción</label>
                <textarea name="descripcion" id="tagDescripcion" rows="3" class="form-input"></textarea>
            </div>

            <div style="display: flex; gap: 0.75rem; justify-content: flex-end; padding-top: 1rem; border-top: 1px solid var(--border-gray);">
                <button type="button" onclick="closeTagModal()" class="btn btn-secondary">Cancelar</button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Guardar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openCreateTagModal() {
    document.getElementById('tagModalTitle').textContent = 'Nueva Etiqueta';
    document.getElementById('tagForm').action = '{{ route("etiquetas.store") }}';
    document.getElementById('tagMethodField').value = 'POST';
    document.getElementById('tagNombre').value = '';
    document.getElementById('tagDescripcion').value = '';
    document.getElementById('tagModal').style.display = 'flex';
}

function openEditTagModal(id, nombre, descripcion) {
    document.getElementById('tagModalTitle').textContent = 'Editar Etiqueta';
    document.getElementById('tagForm').action = '/etiquetas/' + id;
    document.getElementById('tagMethodField').value = 'PUT';
    document.getElementById('tagNombre').value = nombre;
    document.getElementById('tagDescripcion').value = descripcion || '';
    document.getElementById('tagModal').style.display = 'flex';
}

function closeTagModal() {
    document.getElementById('tagModal').style.display = 'none';
}

function viewTag(id, nombre) {
    window.location.href = '/prompts?etiqueta=' + id;
}

function deleteTag(id, nombre) {
    Swal.fire({
        title: '¿Eliminar etiqueta?',
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
            form.action = '/etiquetas/' + id;
            
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

document.getElementById('tagModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeTagModal();
});

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

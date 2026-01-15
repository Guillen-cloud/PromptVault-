@extends('layouts.app')

@section('title', 'Historial de Versiones')

@section('content')
<div class="page-header">
    <h1 class="page-title">Historial de Versiones</h1>
    <p class="page-subtitle">Consulta y compara versiones anteriores de tus prompts</p>
</div>

<!-- Filtro -->
<div class="filters">
    <form action="{{ route('versiones.index') }}" method="GET" style="display: contents;">
        <div class="filter-item">
            <select name="prompt" class="form-control" onchange="this.form.submit()">
                <option value="">Todos los prompts</option>
                @foreach($prompts as $prompt)
                    <option value="{{ $prompt->id }}" {{ request('prompt') == $prompt->id ? 'selected' : '' }}>
                        {{ $prompt->titulo }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>
</div>

<!-- Timeline de Versiones -->
<div class="card">
    @forelse($versiones as $version)
    <div style="display: flex; padding: 1.5rem; border-bottom: 1px solid var(--border-gray);">
        <div style="flex-shrink: 0; margin-right: 1.5rem;">
            <div style="width: 50px; height: 50px; border-radius: 12px; background: var(--primary-blue); color: white; display: flex; align-items: center; justify-content: center; font-weight: 600;">
                v{{ $version->numero_version }}
            </div>
        </div>
        <div style="flex: 1;">
            <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.25rem;">
                {{ $version->prompt->titulo ?? 'Prompt eliminado' }}
            </h3>
            <p style="color: var(--text-gray); margin-bottom: 0.5rem;">
                {{ $version->motivo_cambio ?? 'Sin notas de cambio' }}
            </p>
            <p style="font-size: 0.875rem; color: var(--text-light);">
                <i class="far fa-clock"></i> {{ $version->created_at->format('d-m-Y H:i') }}
            </p>
        </div>
        <div>
            <a href="{{ route('versiones.show', $version) }}" class="action-btn" title="Ver versión completa">
                <i class="fas fa-eye"></i>
            </a>
            <a href="{{ route('versiones.compare', $version) }}" class="action-btn" title="Comparar versiones">
                <i class="fas fa-code-compare"></i>
            </a>
            <button onclick="restaurarVersion({{ $version->id }})" class="action-btn" title="Restaurar versión">
                <i class="fas fa-undo"></i>
            </button>
        </div>
    </div>
    @empty
    <div class="empty-state">
        <i class="fas fa-code-branch"></i>
        <h3>No hay versiones disponibles</h3>
        <p>Las versiones se crearán automáticamente al editar los prompts</p>
    </div>
    @endforelse
</div>

@if($versiones->hasPages())
<div style="margin-top: 1.5rem; display: flex; justify-content: center;">
    {{ $versiones->links() }}
</div>
@endif

<script>
function restaurarVersion(versionId) {
    Swal.fire({
        title: '¿Restaurar esta versión?',
        text: 'Se creará un respaldo de la versión actual antes de restaurar',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3b82f6',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Sí, restaurar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/versiones/${versionId}/restore`;
            
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}';
            
            form.appendChild(csrfInput);
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>
@endsection

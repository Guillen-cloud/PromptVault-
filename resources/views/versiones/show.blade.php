@extends('layouts.app')

@section('title', 'Ver Versión')

@section('content')
<div class="page-header">
    <div style="display: flex; align-items: center; gap: 1rem;">
        <a href="{{ route('versiones.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="page-title">Versión {{ $version->numero_version }}</h1>
            <p class="page-subtitle">{{ $version->prompt->titulo }}</p>
        </div>
    </div>
    <div style="display: flex; gap: 0.75rem;">
        <a href="{{ route('versiones.compare', $version) }}" class="btn btn-secondary">
            <i class="fas fa-code-compare"></i> Comparar
        </a>
        <button onclick="restaurarVersion({{ $version->id }})" class="btn btn-primary">
            <i class="fas fa-undo"></i> Restaurar esta versión
        </button>
    </div>
</div>

<div class="content-grid">
    <!-- Información de la versión -->
    <div class="card" style="grid-column: span 12;">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-info-circle"></i> Información de la Versión
            </h3>
        </div>
        <div class="card-body">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
                <div>
                    <label class="form-label">Número de Versión</label>
                    <p style="font-weight: 600; font-size: 1.125rem;">v{{ $version->numero_version }}</p>
                </div>
                <div>
                    <label class="form-label">Fecha de Creación</label>
                    <p style="font-weight: 600;">{{ $version->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <label class="form-label">Motivo del Cambio</label>
                    <p style="font-weight: 600;">{{ $version->motivo_cambio ?? 'Sin motivo especificado' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido anterior -->
    <div class="card" style="grid-column: span 12;">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-file-code"></i> Contenido de esta Versión
            </h3>
            <button onclick="copiarContenido()" class="action-btn" title="Copiar contenido">
                <i class="fas fa-copy"></i>
            </button>
        </div>
        <div class="card-body">
            <div style="background: #f8fafc; border-radius: 8px; padding: 1.5rem; border: 1px solid var(--border-gray);">
                <pre id="version-content" style="margin: 0; white-space: pre-wrap; word-wrap: break-word; font-family: 'Courier New', monospace; line-height: 1.6;">{{ $version->contenido_anterior }}</pre>
            </div>
        </div>
    </div>

    <!-- Información del prompt actual -->
    <div class="card" style="grid-column: span 12;">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-link"></i> Prompt Relacionado
            </h3>
        </div>
        <div class="card-body">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h4 style="font-weight: 600; margin-bottom: 0.25rem;">{{ $version->prompt->titulo }}</h4>
                    <p style="color: var(--text-gray); margin-bottom: 0.5rem;">{{ $version->prompt->descripcion }}</p>
                    <span class="badge" style="background: var(--primary-blue);">
                        Versión actual: v{{ $version->prompt->version_actual }}
                    </span>
                </div>
                <a href="{{ route('prompts.show', $version->prompt) }}" class="btn btn-secondary">
                    Ver Prompt
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function copiarContenido() {
    const content = document.getElementById('version-content').textContent;
    navigator.clipboard.writeText(content).then(() => {
        Swal.fire({
            icon: 'success',
            title: '¡Copiado!',
            text: 'Contenido copiado al portapapeles',
            timer: 2000,
            showConfirmButton: false
        });
    });
}

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

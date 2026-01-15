@extends('layouts.app')

@section('title', 'Comparar Versiones')

@section('content')
<div class="page-header">
    <div style="display: flex; align-items: center; gap: 1rem;">
        <a href="{{ route('versiones.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="page-title">Comparación de Versiones</h1>
            <p class="page-subtitle">{{ $prompt->titulo }}</p>
        </div>
    </div>
    <button onclick="restaurarVersion({{ $version->id }})" class="btn btn-primary">
        <i class="fas fa-undo"></i> Restaurar v{{ $version->numero_version }}
    </button>
</div>

<div class="content-grid">
    <!-- Información -->
    <div class="card" style="grid-column: span 12;">
        <div class="card-body">
            <div style="display: flex; justify-content: space-around; text-align: center;">
                <div>
                    <div style="width: 60px; height: 60px; border-radius: 12px; background: #6b7280; color: white; display: flex; align-items: center; justify-content: center; font-weight: 600; margin: 0 auto 0.5rem;">
                        v{{ $version->numero_version }}
                    </div>
                    <h3 style="font-weight: 600; margin-bottom: 0.25rem;">Versión Anterior</h3>
                    <p style="color: var(--text-gray); font-size: 0.875rem;">{{ $version->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div style="display: flex; align-items: center;">
                    <i class="fas fa-arrows-left-right" style="font-size: 2rem; color: var(--primary-blue);"></i>
                </div>
                <div>
                    <div style="width: 60px; height: 60px; border-radius: 12px; background: var(--primary-blue); color: white; display: flex; align-items: center; justify-content: center; font-weight: 600; margin: 0 auto 0.5rem;">
                        v{{ $prompt->version_actual }}
                    </div>
                    <h3 style="font-weight: 600; margin-bottom: 0.25rem;">Versión Actual</h3>
                    <p style="color: var(--text-gray); font-size: 0.875rem;">{{ $prompt->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Comparación lado a lado -->
    <div class="card" style="grid-column: span 6;">
        <div class="card-header" style="background: #f3f4f6;">
            <h3 class="card-title">
                <i class="fas fa-history"></i> Versión {{ $version->numero_version }}
            </h3>
            <span class="badge" style="background: #6b7280;">Anterior</span>
        </div>
        <div class="card-body" style="padding: 0;">
            <div style="background: #fef9f3; padding: 1.5rem; min-height: 400px; border-left: 4px solid #f59e0b;">
                <pre style="margin: 0; white-space: pre-wrap; word-wrap: break-word; font-family: 'Courier New', monospace; line-height: 1.8;">{{ $version->contenido_anterior }}</pre>
            </div>
        </div>
    </div>

    <div class="card" style="grid-column: span 6;">
        <div class="card-header" style="background: #eff6ff;">
            <h3 class="card-title">
                <i class="fas fa-check-circle"></i> Versión {{ $prompt->version_actual }}
            </h3>
            <span class="badge" style="background: var(--primary-blue);">Actual</span>
        </div>
        <div class="card-body" style="padding: 0;">
            <div style="background: #f0fdf4; padding: 1.5rem; min-height: 400px; border-left: 4px solid #10b981;">
                <pre style="margin: 0; white-space: pre-wrap; word-wrap: break-word; font-family: 'Courier New', monospace; line-height: 1.8;">{{ $prompt->contenido }}</pre>
            </div>
        </div>
    </div>

    <!-- Estadísticas de cambios -->
    <div class="card" style="grid-column: span 12;">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-chart-bar"></i> Estadísticas
            </h3>
        </div>
        <div class="card-body">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
                <div style="text-align: center; padding: 1rem; background: #f8fafc; border-radius: 8px;">
                    <i class="fas fa-text-width" style="font-size: 2rem; color: var(--primary-blue); margin-bottom: 0.5rem;"></i>
                    <p style="font-size: 0.875rem; color: var(--text-gray); margin-bottom: 0.25rem;">Caracteres Anterior</p>
                    <p style="font-size: 1.5rem; font-weight: 600;">{{ strlen($version->contenido_anterior) }}</p>
                </div>
                <div style="text-align: center; padding: 1rem; background: #f8fafc; border-radius: 8px;">
                    <i class="fas fa-text-width" style="font-size: 2rem; color: #10b981; margin-bottom: 0.5rem;"></i>
                    <p style="font-size: 0.875rem; color: var(--text-gray); margin-bottom: 0.25rem;">Caracteres Actual</p>
                    <p style="font-size: 1.5rem; font-weight: 600;">{{ strlen($prompt->contenido) }}</p>
                </div>
                <div style="text-align: center; padding: 1rem; background: #f8fafc; border-radius: 8px;">
                    <i class="fas fa-plus-minus" style="font-size: 2rem; color: {{ strlen($prompt->contenido) > strlen($version->contenido_anterior) ? '#10b981' : '#ef4444' }}; margin-bottom: 0.5rem;"></i>
                    <p style="font-size: 0.875rem; color: var(--text-gray); margin-bottom: 0.25rem;">Diferencia</p>
                    <p style="font-size: 1.5rem; font-weight: 600; color: {{ strlen($prompt->contenido) > strlen($version->contenido_anterior) ? '#10b981' : '#ef4444' }};">
                        {{ strlen($prompt->contenido) > strlen($version->contenido_anterior) ? '+' : '' }}{{ strlen($prompt->contenido) - strlen($version->contenido_anterior) }}
                    </p>
                </div>
                <div style="text-align: center; padding: 1rem; background: #f8fafc; border-radius: 8px;">
                    <i class="fas fa-code-branch" style="font-size: 2rem; color: #f59e0b; margin-bottom: 0.5rem;"></i>
                    <p style="font-size: 0.875rem; color: var(--text-gray); margin-bottom: 0.25rem;">Motivo del Cambio</p>
                    <p style="font-size: 0.875rem; font-weight: 600;">{{ $version->motivo_cambio ?? 'No especificado' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function restaurarVersion(versionId) {
    Swal.fire({
        title: '¿Restaurar versión {{ $version->numero_version }}?',
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

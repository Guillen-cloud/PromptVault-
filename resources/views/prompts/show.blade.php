@extends('layouts.app')

@section('title', $prompt->titulo . ' - PromptVault')

@section('content')
<div class="page-header">
    <div>
        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem;">
            @if($prompt->categoria)
                <span class="badge badge-blue">
                    {{ $prompt->categoria->icono }} {{ $prompt->categoria->nombre }}
                </span>
            @endif
            <span class="badge badge-purple">v{{ $prompt->version_actual }}</span>
        </div>
        <h1 class="page-title">{{ $prompt->titulo }}</h1>
        @if($prompt->descripcion)
            <p class="page-subtitle">{{ $prompt->descripcion }}</p>
        @endif
    </div>
    <div class="page-header-actions">
        <button onclick="copiarContenido()" class="btn btn-primary">
            <i class="fas fa-copy"></i> Copiar Prompt
        </button>
        <button onclick="compartirPrompt()" class="btn" style="background: #10b981; color: white;">
            <i class="fas fa-share-alt"></i> Compartir
        </button>
        <a href="{{ route('prompts.edit', $prompt) }}" class="btn" style="background: #3b82f6; color: white;">
            <i class="fas fa-edit"></i> Editar
        </a>
        @if($prompt->versiones->count() > 0)
        <a href="{{ route('versiones.index', ['prompt' => $prompt->id]) }}" class="btn btn-secondary" title="Ver historial de versiones">
            <i class="fas fa-history"></i> {{ $prompt->versiones->count() }}
        </a>
        @endif
        <form action="{{ route('prompts.favorito', $prompt) }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn" style="background: {{ $prompt->es_favorito ? '#eab308' : 'var(--bg-gray)' }}; color: {{ $prompt->es_favorito ? 'white' : 'var(--text-dark)' }};">
                <i class="{{ $prompt->es_favorito ? 'fas' : 'far' }} fa-star"></i>
            </button>
        </form>
        <button onclick="deletePrompt({{ $prompt->id }}, '{{ $prompt->titulo }}')" class="btn" style="background: #ef4444; color: white;">
            <i class="fas fa-trash"></i>
        </button>
        <a href="{{ route('prompts.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>
</div>

<!-- Contenido Principal -->
<div class="content-grid" style="display: grid; grid-template-columns: 1fr; gap: 1.5rem;">
    <!-- Columna Principal -->
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        <!-- Contenido del Prompt -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title"><i class="fas fa-file-alt"></i> Contenido del Prompt</h2>
            </div>
            <div style="background: var(--bg-gray); border: 1px solid var(--border-gray); border-radius: 8px; padding: 1rem;">
                <pre style="white-space: pre-wrap; font-size: 0.875rem; color: var(--text-dark); font-family: 'Courier New', monospace; margin: 0;">{{ $prompt->contenido }}</pre>
            </div>
        </div>

        <!-- Versiones -->
        @if($prompt->versiones->count() > 0)
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title"><i class="fas fa-code-branch"></i> Historial de Versiones</h2>
                </div>
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    @foreach($prompt->versiones->sortByDesc('numero_version') as $version)
                        <div style="border-left: 4px solid var(--primary-blue); padding-left: 1rem; padding-top: 0.5rem; padding-bottom: 0.5rem;">
                            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.5rem;">
                                <span style="font-size: 0.875rem; font-weight: 600;">Versión {{ $version->numero_version }}</span>
                                <span style="font-size: 0.75rem; color: var(--text-gray);">{{ $version->created_at->diffForHumans() }}</span>
                            </div>
                            @if($version->motivo_cambio)
                                <p style="font-size: 0.875rem; color: var(--text-gray); margin-bottom: 0.5rem;">💭 {{ $version->motivo_cambio }}</p>
                            @endif
                            <details style="font-size: 0.875rem;">
                                <summary style="cursor: pointer; color: var(--primary-blue);">Ver contenido anterior</summary>
                                <div style="margin-top: 0.5rem; background: var(--bg-gray); border-radius: 8px; padding: 0.75rem;">
                                    <pre style="white-space: pre-wrap; font-size: 0.75rem; color: var(--text-dark); margin: 0;">{{ $version->contenido_anterior }}</pre>
                                </div>
                            </details>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Historial de Compartidos -->
        @if($prompt->compartidos->count() > 0)
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title"><i class="fas fa-share-alt"></i> Compartido con</h2>
                </div>
                <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                    @foreach($prompt->compartidos as $compartido)
                        <div style="display: flex; align-items: center; justify-content: space-between; padding: 0.5rem 0; border-bottom: 1px solid var(--border-gray);">
                            <div>
                                <p style="font-size: 0.875rem; font-weight: 600;">{{ $compartido->nombre_destinatario }}</p>
                                <p style="font-size: 0.75rem; color: var(--text-gray);">{{ $compartido->email_destinatario }}</p>
                                @if($compartido->notas)
                                    <p style="font-size: 0.75rem; color: var(--text-gray); margin-top: 0.25rem;">{{ $compartido->notas }}</p>
                                @endif
                            </div>
                            <span style="font-size: 0.75rem; color: var(--text-gray);">{{ $compartido->created_at->format('d/m/Y') }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <!-- Columna Lateral -->
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        <!-- Información -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title"><i class="fas fa-info-circle"></i> Información</h2>
            </div>
            <dl style="display: flex; flex-direction: column; gap: 0.75rem;">
                <div>
                    <dt style="font-size: 0.875rem; font-weight: 500; color: var(--text-gray);">IA Destino</dt>
                    <dd style="margin-top: 0.25rem; font-size: 0.875rem;">🤖 {{ $prompt->ia_destino }}</dd>
                </div>
                <div>
                    <dt style="font-size: 0.875rem; font-weight: 500; color: var(--text-gray);">Veces Usado</dt>
                    <dd style="margin-top: 0.25rem; font-size: 0.875rem;">📊 {{ $prompt->veces_usado }}x</dd>
                </div>
                <div>
                    <dt style="font-size: 0.875rem; font-weight: 500; color: var(--text-gray);">Estado</dt>
                    <dd style="margin-top: 0.25rem;">
                        @if($prompt->es_publico)
                            <span class="badge badge-green">
                                🌐 Público
                            </span>
                        @else
                            <span class="badge" style="background: #f3f4f6; color: #1f2937;">
                                🔒 Privado
                            </span>
                        @endif
                    </dd>
                </div>
                <div>
                    <dt style="font-size: 0.875rem; font-weight: 500; color: var(--text-gray);">Creado</dt>
                    <dd style="margin-top: 0.25rem; font-size: 0.875rem;">{{ $prompt->created_at->format('d/m/Y H:i') }}</dd>
                </div>
                <div>
                    <dt style="font-size: 0.875rem; font-weight: 500; color: var(--text-gray);">Última Modificación</dt>
                    <dd style="margin-top: 0.25rem; font-size: 0.875rem;">{{ $prompt->updated_at->diffForHumans() }}</dd>
                </div>
            </dl>
        </div>

        <!-- Etiquetas -->
        @if($prompt->etiquetas->count() > 0)
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title"><i class="fas fa-tags"></i> Etiquetas</h2>
                </div>
                <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                    @foreach($prompt->etiquetas as $etiqueta)
                        <span class="badge" style="background: var(--bg-gray); color: var(--text-dark);">
                            #{{ $etiqueta->nombre }}
                        </span>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Actividades Recientes -->
        @if($prompt->actividades->count() > 0)
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title"><i class="fas fa-history"></i> Actividad Reciente</h2>
                </div>
                <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                    @foreach($prompt->actividades->take(5) as $actividad)
                        <div style="font-size: 0.875rem;">
                            <p style="color: var(--text-dark);">{{ $actividad->descripcion }}</p>
                            <p style="font-size: 0.75rem; color: var(--text-gray); margin-top: 0.25rem;">
                                Usuario {{ $actividad->user_id }} • {{ $actividad->created_at->diffForHumans() }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
    </div>
</div>

@push('scripts')
<script>
function copiarContenido() {
    const contenido = @json($prompt->contenido);
    navigator.clipboard.writeText(contenido).then(() => {
        // Registrar uso
        fetch("{{ route('prompts.use', $prompt) }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        });
        
        Swal.fire({
            icon: 'success',
            title: '¡Copiado!',
            text: 'Prompt copiado al portapapeles',
            timer: 2000,
            showConfirmButton: false
        }).then(() => location.reload());
    }).catch(err => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudo copiar: ' + err,
            confirmButtonColor: '#ef4444'
        });
    });
}

function deletePrompt(id, titulo) {
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
            csrfInput.value = '{{ csrf_token() }}';
            
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

function compartirPrompt() {
    Swal.fire({
        title: 'Compartir Prompt',
        html: `
            <div style="text-align: left;">
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Nombre del destinatario *</label>
                    <input type="text" id="swal-nombre" class="swal2-input" placeholder="Ej: Juan Pérez" style="width: 100%; margin: 0;">
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Email del destinatario *</label>
                    <input type="email" id="swal-email" class="swal2-input" placeholder="ejemplo@correo.com" style="width: 100%; margin: 0;">
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Notas (opcional)</label>
                    <textarea id="swal-notas" class="swal2-textarea" placeholder="Mensaje personalizado..." style="width: 100%; margin: 0; height: 80px;"></textarea>
                </div>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: '<i class="fas fa-paper-plane"></i> Compartir',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#10b981',
        cancelButtonColor: '#6b7280',
        preConfirm: () => {
            const nombre = document.getElementById('swal-nombre').value;
            const email = document.getElementById('swal-email').value;
            const notas = document.getElementById('swal-notas').value;
            
            if (!nombre || !email) {
                Swal.showValidationMessage('Por favor completa todos los campos requeridos');
                return false;
            }
            
            if (!email.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
                Swal.showValidationMessage('Por favor ingresa un email válido');
                return false;
            }
            
            return { nombre, email, notas };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("compartidos.store") }}';
            
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}';
            
            const promptInput = document.createElement('input');
            promptInput.type = 'hidden';
            promptInput.name = 'prompt_id';
            promptInput.value = '{{ $prompt->id }}';
            
            const nombreInput = document.createElement('input');
            nombreInput.type = 'hidden';
            nombreInput.name = 'nombre_destinatario';
            nombreInput.value = result.value.nombre;
            
            const emailInput = document.createElement('input');
            emailInput.type = 'hidden';
            emailInput.name = 'email_destinatario';
            emailInput.value = result.value.email;
            
            const notasInput = document.createElement('input');
            notasInput.type = 'hidden';
            notasInput.name = 'notas';
            notasInput.value = result.value.notas;
            
            form.appendChild(csrfInput);
            form.appendChild(promptInput);
            form.appendChild(nombreInput);
            form.appendChild(emailInput);
            form.appendChild(notasInput);
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
@endpush
@endsection

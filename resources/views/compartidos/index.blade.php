@extends('layouts.app')

@section('title', 'Prompts Compartidos')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Prompts Compartidos</h1>
        <p class="page-subtitle">Gestiona los prompts que has compartido</p>
    </div>
    <button onclick="mostrarModalCompartir()" class="btn btn-primary">
        <i class="fas fa-share-alt"></i> Compartir Prompt
    </button>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>PROMPT</th>
                <th>COMPARTIDO CON</th>
                <th>FECHA</th>
                <th>NOTAS</th>
                <th style="width: 100px; text-align: center;">ACCIONES</th>
            </tr>
        </thead>
        <tbody>
            @forelse($compartidos as $compartido)
            <tr>
                <td>
                    <div style="display: flex; align-items: center; gap: 0.5rem;">
                        <i class="fas fa-file-alt" style="color: var(--primary-blue);"></i>
                        <strong>{{ $compartido->prompt->titulo ?? 'Prompt eliminado' }}</strong>
                    </div>
                </td>
                <td>
                    <div>
                        <strong>{{ $compartido->nombre_destinatario }}</strong>
                        <div style="color: var(--text-gray); font-size: 0.875rem;">
                            <i class="fas fa-envelope"></i> {{ $compartido->email_destinatario }}
                        </div>
                    </div>
                </td>
                <td>
                    <i class="far fa-calendar"></i> {{ $compartido->fecha_compartido->format('d/m/Y H:i') }}
                </td>
                <td>{{ $compartido->notas ?? '-' }}</td>
                <td style="text-align: center;">
                    <button onclick="eliminarCompartido({{ $compartido->id }}, '{{ $compartido->nombre_destinatario }}')" class="action-btn" title="Eliminar registro">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5">
                    <div class="empty-state">
                        <i class="fas fa-share-alt"></i>
                        <h3>No has compartido ningún prompt</h3>
                        <p>Comienza a compartir tus prompts con otros usuarios</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($compartidos->hasPages())
<div style="margin-top: 1.5rem; display: flex; justify-content: center;">
    {{ $compartidos->links() }}
</div>
@endif

<!-- Modal para compartir prompt -->
<div id="modalCompartir" class="modal">
    <div class="modal-content" style="max-width: 600px;">
        <div class="modal-header">
            <h3 class="modal-title">
                <i class="fas fa-share-alt"></i> Compartir Prompt
            </h3>
            <button class="modal-close" onclick="cerrarModalCompartir()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="formCompartir" action="{{ route('compartidos.store') }}" method="POST">
            @csrf
            <div class="modal-body">
                <!-- Seleccionar Prompt -->
                <div class="form-group">
                    <label for="prompt_id" class="form-label">
                        Prompt a compartir <span style="color: var(--danger-red);">*</span>
                    </label>
                    <select name="prompt_id" id="prompt_id" class="form-input" required>
                        <option value="">Selecciona un prompt</option>
                        @foreach($prompts as $prompt)
                            <option value="{{ $prompt->id }}">{{ $prompt->titulo }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Nombre del destinatario -->
                <div class="form-group">
                    <label for="nombre_destinatario" class="form-label">
                        Nombre del destinatario <span style="color: var(--danger-red);">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="nombre_destinatario" 
                        id="nombre_destinatario" 
                        class="form-input" 
                        placeholder="Ej: Juan Pérez"
                        required
                    >
                </div>

                <!-- Email del destinatario -->
                <div class="form-group">
                    <label for="email_destinatario" class="form-label">
                        Email del destinatario <span style="color: var(--danger-red);">*</span>
                    </label>
                    <input 
                        type="email" 
                        name="email_destinatario" 
                        id="email_destinatario" 
                        class="form-input" 
                        placeholder="ejemplo@correo.com"
                        required
                    >
                </div>

                <!-- Notas -->
                <div class="form-group">
                    <label for="notas" class="form-label">
                        Notas (opcional)
                    </label>
                    <textarea 
                        name="notas" 
                        id="notas" 
                        rows="3" 
                        class="form-input"
                        placeholder="Mensaje personalizado para el destinatario..."
                    ></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="cerrarModalCompartir()" class="btn btn-secondary">
                    Cancelar
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-paper-plane"></i> Compartir
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function mostrarModalCompartir() {
    document.getElementById('modalCompartir').style.display = 'flex';
    document.getElementById('formCompartir').reset();
}

function cerrarModalCompartir() {
    document.getElementById('modalCompartir').style.display = 'none';
}

function eliminarCompartido(id, nombre) {
    Swal.fire({
        title: '¿Eliminar registro?',
        text: `Se eliminará el registro de compartido con ${nombre}`,
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
            form.action = `/compartidos/${id}`;
            
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

// Cerrar modal al hacer clic fuera
window.onclick = function(event) {
    const modal = document.getElementById('modalCompartir');
    if (event.target === modal) {
        cerrarModalCompartir();
    }
}
</script>
@endsection

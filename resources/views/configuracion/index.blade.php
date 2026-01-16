@extends('layouts.app')

@section('title', 'Configuración')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">⚙️ Configuración</h1>
        <p class="page-subtitle">Personaliza tu experiencia en PromptVault</p>
    </div>
</div>

<!-- Tabs de Navegación -->
<div class="card" style="margin-bottom: 1.5rem;">
    <div class="settings-tabs">
        <button class="tab-btn active" data-tab="perfil">
            <i class="fas fa-user"></i> Perfil
        </button>
        <button class="tab-btn" data-tab="preferencias">
            <i class="fas fa-sliders-h"></i> Preferencias
        </button>
        <button class="tab-btn" data-tab="seguridad">
            <i class="fas fa-shield-alt"></i> Seguridad
        </button>
        <button class="tab-btn" data-tab="estadisticas">
            <i class="fas fa-chart-bar"></i> Estadísticas
        </button>
        <button class="tab-btn" data-tab="datos">
            <i class="fas fa-database"></i> Datos
        </button>
    </div>
</div>

<div class="content-grid">
    <!-- Tab: Perfil de Usuario -->
    <div class="tab-content" data-content="perfil" style="grid-column: span 12;">
        <div class="content-grid">
            <div class="card" style="grid-column: span 12;">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user"></i> Información del Perfil
                    </h3>
                </div>
                <div class="card-body">
            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem; padding: 1rem; background: #f8fafc; border-radius: 8px;">
                <div style="width: 70px; height: 70px; border-radius: 50%; background: linear-gradient(135deg, var(--primary-blue), #8b5cf6); color: white; display: flex; align-items: center; justify-content: center; font-size: 1.75rem; font-weight: 700; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);">
                    {{ strtoupper(substr($user->name ?? 'UD', 0, 2)) }}
                </div>
                <div>
                    <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 0.25rem;">{{ $user->name ?? 'Usuario Demo' }}</h3>
                    <p style="color: var(--text-gray); margin-bottom: 0.25rem;">
                        <i class="fas fa-envelope"></i> {{ $user->email ?? 'usuario@example.com' }}
                    </p>
                    <span class="badge" style="background: #10b981;">Cuenta Activa</span>
                </div>
            </div>
            
            <form action="{{ route('configuracion.updateProfile') }}" method="POST">
                @csrf
                @method('PATCH')
                
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-user"></i> Nombre Completo
                    </label>
                    <input type="text" name="name" class="form-input" value="{{ $user->name ?? 'Usuario Demo' }}" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-envelope"></i> Correo Electrónico
                    </label>
                    <input type="email" name="email" class="form-input" value="{{ $user->email ?? 'usuario@example.com' }}" required>
                </div>
                
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Guardar Cambios
                </button>
            </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Tab: Preferencias -->
    <div class="tab-content" data-content="preferencias" style="grid-column: span 12; display: none;">
        <div class="content-grid">
            <div class="card" style="grid-column: span 6;">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-sliders-h"></i> Preferencias Generales
                    </h3>
                </div>
                <div class="card-body">
            <form action="{{ route('configuracion.updatePreferences') }}" method="POST">
                @csrf
                @method('PATCH')
                
                <!-- Idioma -->
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-language"></i> Idioma
                    </label>
                    <select name="idioma" class="form-input">
                        <option value="es">🇪🇸 Español</option>
                        <option value="en">🇬🇧 English</option>
                        <option value="fr">🇫🇷 Français</option>
                    </select>
                </div>

                <!-- Formato de fecha -->
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-calendar-alt"></i> Formato de Fecha
                    </label>
                    <select name="formato_fecha" class="form-input">
                        <option value="d/m/Y">DD/MM/YYYY (14/01/2026)</option>
                        <option value="m/d/Y">MM/DD/YYYY (01/14/2026)</option>
                        <option value="Y-m-d">YYYY-MM-DD (2026-01-14)</option>
                    </select>
                </div>

                <!-- Tema -->
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-palette"></i> Tema de la Interfaz
                    </label>
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 0.75rem;">
                        <label style="display: flex; align-items: center; padding: 1rem; border: 2px solid var(--border-gray); border-radius: 8px; cursor: pointer; transition: all 0.2s;" class="theme-option">
                            <input type="radio" name="tema" value="light" {{ $user->tema_preferido === 'light' ? 'checked' : '' }} style="margin-right: 0.75rem;">
                            <div>
                                <div style="font-weight: 600;">☀️ Claro</div>
                                <div style="font-size: 0.875rem; color: var(--text-gray);">Tema predeterminado</div>
                            </div>
                        </label>
                        <label style="display: flex; align-items: center; padding: 1rem; border: 2px solid var(--border-gray); border-radius: 8px; cursor: pointer; transition: all 0.2s;" class="theme-option">
                            <input type="radio" name="tema" value="dark" {{ $user->tema_preferido === 'dark' ? 'checked' : '' }} style="margin-right: 0.75rem;">
                            <div>
                                <div style="font-weight: 600;">🌙 Oscuro</div>
                                <div style="font-size: 0.875rem; color: var(--text-gray);">Para bajo luz</div>
                            </div>
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Guardar Preferencias
                </button>
            </form>
                </div>
            </div>

            <!-- Notificaciones -->
            <div class="card" style="grid-column: span 6;">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-bell"></i> Configuración de Notificaciones
                    </h3>
                </div>
                <div class="card-body">
            <form action="{{ route('configuracion.updateNotifications') }}" method="POST">
                @csrf
                @method('PATCH')
                
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <label class="notification-option">
                        <div>
                            <p style="font-weight: 600; margin-bottom: 0.25rem; color: var(--text-dark);">
                                <i class="fas fa-share-alt"></i> Prompts compartidos
                            </p>
                            <p style="font-size: 0.875rem; color: var(--text-gray);">Notificar cuando compartan prompts contigo</p>
                        </div>
                        <input type="checkbox" name="notif_compartidos" checked class="toggle-checkbox">
                    </label>
                    
                    <label class="notification-option">
                        <div>
                            <p style="font-weight: 600; margin-bottom: 0.25rem; color: var(--text-dark);">
                                <i class="fas fa-code-branch"></i> Nuevas versiones
                            </p>
                            <p style="font-size: 0.875rem; color: var(--text-gray);">Alertas sobre versiones de tus prompts</p>
                        </div>
                        <input type="checkbox" name="notif_versiones" checked class="toggle-checkbox">
                    </label>
                    
                    <label class="notification-option">
                        <div>
                            <p style="font-weight: 600; margin-bottom: 0.25rem; color: var(--text-dark);">
                                <i class="fas fa-clock"></i> Recordatorios
                            </p>
                            <p style="font-size: 0.875rem; color: var(--text-gray);">Recordatorios de uso de prompts</p>
                        </div>
                        <input type="checkbox" name="notif_recordatorios" class="toggle-checkbox">
                    </label>

                    <label class="notification-option">
                        <div>
                            <p style="font-weight: 600; margin-bottom: 0.25rem; color: var(--text-dark);">
                                <i class="fas fa-envelope"></i> Resumen semanal
                            </p>
                            <p style="font-size: 0.875rem; color: var(--text-gray);">Recibir resumen de actividad por email</p>
                        </div>
                        <input type="checkbox" name="notif_resumen" class="toggle-checkbox">
                    </label>
                </div>

                <button type="submit" class="btn btn-primary" style="margin-top: 1rem;">
                    <i class="fas fa-save"></i> Guardar Notificaciones
                </button>
            </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab: Seguridad -->
    <div class="tab-content" data-content="seguridad" style="grid-column: span 12; display: none;">
        <div class="content-grid">
            <div class="card" style="grid-column: span 12;">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-shield-alt"></i> Configuración de Seguridad
                    </h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('configuracion.updatePassword') }}" method="POST">
                        @csrf
                        @method('PATCH')
                        
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-lock"></i> Contraseña Actual
                            </label>
                            <input type="password" name="current_password" class="form-input" placeholder="••••••••">
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-key"></i> Nueva Contraseña
                            </label>
                            <input type="password" name="new_password" class="form-input" placeholder="••••••••">
                            <small style="color: var(--text-gray);">Mínimo 8 caracteres</small>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-check-circle"></i> Confirmar Contraseña
                            </label>
                            <input type="password" name="new_password_confirmation" class="form-input" placeholder="••••••••">
                        </div>

                        <button type="submit" class="btn" style="background: #ef4444; color: white;">
                            <i class="fas fa-lock"></i> Cambiar Contraseña
                        </button>
                    </form>

                    <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--border-gray);">
                        <h4 style="font-weight: 600; margin-bottom: 1rem;">
                            <i class="fas fa-user-shield"></i> Autenticación de Dos Factores
                        </h4>
                        <p style="color: var(--text-gray); margin-bottom: 1rem;">Agrega una capa extra de seguridad a tu cuenta</p>
                        <button class="btn btn-secondary">
                            <i class="fas fa-mobile-alt"></i> Configurar 2FA
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Tab: Estadísticas -->
    <div class="tab-content" data-content="estadisticas" style="grid-column: span 12; display: none;">
        <div class="content-grid">
            <div class="card" style="grid-column: span 12;">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-bar"></i> Estadísticas de tu Actividad
                    </h3>
                </div>
                <div class="card-body">
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
                        <div style="text-align: center; padding: 1.5rem; background: #f0f9ff; border-radius: 8px;">
                            <i class="fas fa-file-alt" style="font-size: 2.5rem; color: var(--primary-blue); margin-bottom: 0.75rem;"></i>
                            <p style="font-size: 0.875rem; color: var(--text-gray); margin-bottom: 0.5rem;">Prompts Creados</p>
                            <p style="font-size: 2rem; font-weight: 700; color: var(--primary-blue);">{{ $stats['total_prompts'] }}</p>
                            <small style="color: var(--text-gray);">Total de prompts en tu biblioteca</small>
                        </div>
                        <div style="text-align: center; padding: 1.5rem; background: #fffbeb; border-radius: 8px;">
                            <i class="fas fa-folder" style="font-size: 2.5rem; color: #f59e0b; margin-bottom: 0.75rem;"></i>
                            <p style="font-size: 0.875rem; color: var(--text-gray); margin-bottom: 0.5rem;">Categorías Usadas</p>
                            <p style="font-size: 2rem; font-weight: 700; color: #f59e0b;">{{ $stats['categorias_usadas'] }}</p>
                            <small style="color: var(--text-gray);">Diferentes categorías aplicadas</small>
                        </div>
                        <div style="text-align: center; padding: 1.5rem; background: #f0fdf4; border-radius: 8px;">
                            <i class="fas fa-share-alt" style="font-size: 2.5rem; color: #10b981; margin-bottom: 0.75rem;"></i>
                            <p style="font-size: 0.875rem; color: var(--text-gray); margin-bottom: 0.5rem;">Compartidos</p>
                            <p style="font-size: 2rem; font-weight: 700; color: #10b981;">{{ $stats['compartidos'] }}</p>
                            <small style="color: var(--text-gray);">Prompts compartidos con otros</small>
                        </div>
                        <div style="text-align: center; padding: 1.5rem; background: #faf5ff; border-radius: 8px;">
                            <i class="fas fa-calendar" style="font-size: 2.5rem; color: #8b5cf6; margin-bottom: 0.75rem;"></i>
                            <p style="font-size: 0.875rem; color: var(--text-gray); margin-bottom: 0.5rem;">Miembro desde</p>
                            <p style="font-size: 1.5rem; font-weight: 700; color: #8b5cf6;">{{ $user->created_at->format('M Y') }}</p>
                            <small style="color: var(--text-gray);">Fecha de registro</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Tab: Datos -->
    <div class="tab-content" data-content="datos" style="grid-column: span 12; display: none;">
        <div class="content-grid">
            <div class="card" style="grid-column: span 12;">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-database"></i> Gestión y Exportación de Datos
                    </h3>
                </div>
                <div class="card-body">
            <h4 style="font-weight: 600; margin-bottom: 1rem;">
                <i class="fas fa-download"></i> Exportar Datos
            </h4>
            <p style="color: var(--text-gray); margin-bottom: 1.5rem;">Descarga una copia de todos tus prompts y datos</p>
            
            <div style="display: flex; flex-direction: column; gap: 0.75rem; margin-bottom: 2rem;">
                <form action="{{ route('configuracion.export') }}" method="POST" style="display: inline;">
                    @csrf
                    <input type="hidden" name="format" value="json">
                    <button type="submit" class="btn btn-secondary" style="width: 100%; justify-content: space-between;">
                        <span><i class="fas fa-file-code"></i> Exportar como JSON</span>
                        <i class="fas fa-download"></i>
                    </button>
                </form>
                
                <form action="{{ route('configuracion.export') }}" method="POST" style="display: inline;">
                    @csrf
                    <input type="hidden" name="format" value="csv">
                    <button type="submit" class="btn btn-secondary" style="width: 100%; justify-content: space-between;">
                        <span><i class="fas fa-file-csv"></i> Exportar como CSV</span>
                        <i class="fas fa-download"></i>
                    </button>
                </form>
            </div>

            <div style="padding: 1.5rem; background: #fef2f2; border: 2px solid #fecaca; border-radius: 8px;">
                <h4 style="font-weight: 600; color: #dc2626; margin-bottom: 0.75rem;">
                    <i class="fas fa-exclamation-triangle"></i> Zona de Peligro
                </h4>
                <p style="color: #7f1d1d; margin-bottom: 1rem; font-size: 0.875rem;">
                    Esta acción eliminará permanentemente todos tus datos. Esta acción no se puede deshacer.
                </p>
                <button onclick="confirmarEliminarCuenta()" class="btn" style="background: #dc2626; color: white;">
                    <i class="fas fa-trash-alt"></i> Eliminar Cuenta y Datos
                </button>
            </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.settings-tabs {
    display: flex;
    gap: 0.5rem;
    padding: 1rem;
    background: #f8fafc;
    border-radius: 8px;
}

.tab-btn {
    flex: 1;
    padding: 0.75rem 1rem;
    background: white;
    border: 2px solid var(--border-gray);
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.2s;
    font-weight: 500;
    color: var(--text-gray);
}

.tab-btn:hover {
    border-color: var(--primary-blue);
    color: var(--primary-blue);
    transform: translateY(-2px);
}

.tab-btn.active {
    background: var(--primary-blue);
    border-color: var(--primary-blue);
    color: white;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.tab-btn i {
    margin-right: 0.5rem;
}
</style>

<script>
// Tabs functionality
document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const targetTab = this.getAttribute('data-tab');
        
        // Remove active class from all tabs
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        
        // Add active class to clicked tab
        this.classList.add('active');
        
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(content => {
            content.style.display = 'none';
        });
        
        // Show target tab content
        const targetContent = document.querySelector(`[data-content="${targetTab}"]`);
        if (targetContent) {
            targetContent.style.display = 'block';
        }
    });
});

function confirmarEliminarCuenta() {
    Swal.fire({
        title: '⚠️ ¿Eliminar cuenta?',
        html: `
            <p style="margin-bottom: 1rem;">Esta acción es <strong>IRREVERSIBLE</strong> y eliminará:</p>
            <ul style="text-align: left; color: #7f1d1d;">
                <li>Todos tus prompts</li>
                <li>Tus categorías y etiquetas</li>
                <li>Historial de versiones</li>
                <li>Actividades registradas</li>
                <li>Tu cuenta de usuario</li>
            </ul>
            <p style="margin-top: 1rem; font-weight: 600;">Para confirmar, escribe: <span style="color: #dc2626;">ELIMINAR</span></p>
        `,
        input: 'text',
        inputPlaceholder: 'Escribe ELIMINAR',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Sí, eliminar todo',
        cancelButtonText: 'Cancelar',
        preConfirm: (value) => {
            if (value !== 'ELIMINAR') {
                Swal.showValidationMessage('Debes escribir ELIMINAR para confirmar');
                return false;
            }
            return true;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                icon: 'info',
                title: 'Función no implementada',
                text: 'Esta funcionalidad requiere autenticación completa',
                confirmButtonColor: '#3b82f6'
            });
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

// Theme Toggle Functionality
document.querySelectorAll('input[name="tema"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const theme = this.value;
        document.body.setAttribute('data-theme', theme);
        
        // Visual feedback on theme options
        document.querySelectorAll('.theme-option').forEach(option => {
            option.style.borderColor = 'var(--border-gray)';
        });
        this.closest('.theme-option').style.borderColor = 'var(--primary-blue)';
    });
});

// Set initial border for selected theme
document.addEventListener('DOMContentLoaded', function() {
    const checkedRadio = document.querySelector('input[name="tema"]:checked');
    if (checkedRadio) {
        checkedRadio.closest('.theme-option').style.borderColor = 'var(--primary-blue)';
    }
});
</script>
@endsection

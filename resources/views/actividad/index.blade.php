@extends('layouts.app')

@section('title', 'Historial de Actividades')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Historial de Actividades</h1>
        <p class="page-subtitle">Registro cronológico de todas tus acciones</p>
    </div>
    <div style="display: flex; gap: 0.75rem;">
        <button onclick="limpiarFiltros()" class="btn btn-secondary">
            <i class="fas fa-filter-circle-xmark"></i> Limpiar filtros
        </button>
    </div>
</div>

<!-- Estadísticas -->
<div class="content-grid" style="margin-bottom: 1.5rem;">
    <div class="card" style="grid-column: span 3;">
        <div style="text-align: center;">
            <i class="fas fa-list-check" style="font-size: 2rem; color: var(--primary-blue); margin-bottom: 0.5rem;"></i>
            <p style="font-size: 0.875rem; color: var(--text-gray); margin-bottom: 0.25rem;">Total Actividades</p>
            <p style="font-size: 1.75rem; font-weight: 700;">{{ $totalActividades }}</p>
        </div>
    </div>
    <div class="card" style="grid-column: span 3;">
        <div style="text-align: center;">
            <i class="fas fa-calendar-day" style="font-size: 2rem; color: #10b981; margin-bottom: 0.5rem;"></i>
            <p style="font-size: 0.875rem; color: var(--text-gray); margin-bottom: 0.25rem;">Hoy</p>
            <p style="font-size: 1.75rem; font-weight: 700;">{{ $actividadesHoy }}</p>
        </div>
    </div>
    <div class="card" style="grid-column: span 3;">
        <div style="text-align: center;">
            <i class="fas fa-calendar-week" style="font-size: 2rem; color: #f59e0b; margin-bottom: 0.5rem;"></i>
            <p style="font-size: 0.875rem; color: var(--text-gray); margin-bottom: 0.25rem;">Esta Semana</p>
            <p style="font-size: 1.75rem; font-weight: 700;">{{ $actividadesSemana }}</p>
        </div>
    </div>
    <div class="card" style="grid-column: span 3;">
        <div style="text-align: center;">
            <i class="fas fa-fire" style="font-size: 2rem; color: #ef4444; margin-bottom: 0.5rem;"></i>
            <p style="font-size: 0.875rem; color: var(--text-gray); margin-bottom: 0.25rem;">Acción más común</p>
            <p style="font-size: 1.25rem; font-weight: 700; text-transform: capitalize;">{{ $accionMasComun ?? 'N/A' }}</p>
        </div>
    </div>
</div>

<!-- Filtros -->
<div class="card" style="margin-bottom: 1.5rem;">
    <form action="{{ route('actividad.index') }}" method="GET" id="filtrosForm">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
            <!-- Filtro por acción -->
            <div class="form-group" style="margin-bottom: 0;">
                <label for="accion" class="form-label">Tipo de Acción</label>
                <select name="accion" id="accion" class="form-input" onchange="this.form.submit()">
                    <option value="">Todas las acciones</option>
                    <option value="creado" {{ request('accion') == 'creado' ? 'selected' : '' }}>✨ Creado</option>
                    <option value="editado" {{ request('accion') == 'editado' ? 'selected' : '' }}>✏️ Editado</option>
                    <option value="usado" {{ request('accion') == 'usado' ? 'selected' : '' }}>👁️ Usado</option>
                    <option value="compartido" {{ request('accion') == 'compartido' ? 'selected' : '' }}>📤 Compartido</option>
                    <option value="favorito" {{ request('accion') == 'favorito' ? 'selected' : '' }}>⭐ Favorito</option>
                    <option value="restaurado" {{ request('accion') == 'restaurado' ? 'selected' : '' }}>↩️ Restaurado</option>
                    <option value="eliminado" {{ request('accion') == 'eliminado' ? 'selected' : '' }}>🗑️ Eliminado</option>
                </select>
            </div>

            <!-- Filtro por fecha desde -->
            <div class="form-group" style="margin-bottom: 0;">
                <label for="fecha_desde" class="form-label">Desde</label>
                <input type="date" name="fecha_desde" id="fecha_desde" class="form-input" 
                       value="{{ request('fecha_desde') }}" onchange="this.form.submit()">
            </div>

            <!-- Filtro por fecha hasta -->
            <div class="form-group" style="margin-bottom: 0;">
                <label for="fecha_hasta" class="form-label">Hasta</label>
                <input type="date" name="fecha_hasta" id="fecha_hasta" class="form-input" 
                       value="{{ request('fecha_hasta') }}" onchange="this.form.submit()">
            </div>

            <!-- Búsqueda por prompt -->
            <div class="form-group" style="margin-bottom: 0;">
                <label for="search" class="form-label">Buscar Prompt</label>
                <input type="text" name="search" id="search" class="form-input" 
                       placeholder="Título del prompt..." value="{{ request('search') }}">
            </div>
        </div>
    </form>
</div>

<!-- Timeline de Actividades -->
<div class="card">
    <div style="position: relative;">
        @php
            $currentDate = null;
        @endphp
        
        @forelse($actividades as $index => $actividad)
            @php
                $actividadDate = $actividad->created_at->format('Y-m-d');
                $showDateHeader = $currentDate !== $actividadDate;
                $currentDate = $actividadDate;
                
                // Definir estilos según acción
                $estilos = [
                    'creado' => ['bg' => '#d1fae5', 'color' => '#065f46', 'icon' => 'fa-plus'],
                    'editado' => ['bg' => '#dbeafe', 'color' => '#1e40af', 'icon' => 'fa-edit'],
                    'usado' => ['bg' => '#ede9fe', 'color' => '#5b21b6', 'icon' => 'fa-mouse-pointer'],
                    'compartido' => ['bg' => '#fef3c7', 'color' => '#92400e', 'icon' => 'fa-share-alt'],
                    'favorito' => ['bg' => '#fef9c3', 'color' => '#854d0e', 'icon' => 'fa-star'],
                    'restaurado' => ['bg' => '#e0e7ff', 'color' => '#3730a3', 'icon' => 'fa-undo'],
                    'eliminado' => ['bg' => '#fee2e2', 'color' => '#991b1b', 'icon' => 'fa-trash']
                ];
                
                $estilo = $estilos[$actividad->accion] ?? ['bg' => '#f3f4f6', 'color' => '#374151', 'icon' => 'fa-circle'];
            @endphp
            
            <!-- Separador de fecha -->
            @if($showDateHeader)
                <div style="padding: 1rem; background: #f8fafc; border-bottom: 2px solid var(--primary-blue); font-weight: 600; color: var(--primary-blue); display: flex; align-items: center; gap: 0.5rem;">
                    <i class="far fa-calendar"></i>
                    @if($actividadDate === now()->format('Y-m-d'))
                        Hoy - {{ $actividad->created_at->format('d/m/Y') }}
                    @elseif($actividadDate === now()->subDay()->format('Y-m-d'))
                        Ayer - {{ $actividad->created_at->format('d/m/Y') }}
                    @else
                        {{ $actividad->created_at->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
                    @endif
                </div>
            @endif
            
            <div style="display: flex; align-items: start; padding: 1.25rem 1rem; border-bottom: 1px solid var(--border-gray); position: relative;">
                <!-- Línea vertical timeline -->
                @if($index < count($actividades) - 1)
                    <div style="position: absolute; left: 30px; top: 65px; bottom: -1px; width: 2px; background: #e5e7eb;"></div>
                @endif
                
                <!-- Icono de acción -->
                <div style="flex-shrink: 0; margin-right: 1.25rem; position: relative; z-index: 1;">
                    <div style="width: 48px; height: 48px; border-radius: 50%; display: flex; align-items: center; justify-content: center; background: {{ $estilo['bg'] }}; color: {{ $estilo['color'] }}; border: 3px solid white; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                        <i class="fas {{ $estilo['icon'] }}" style="font-size: 1.125rem;"></i>
                    </div>
                </div>
                
                <!-- Contenido de actividad -->
                <div style="flex: 1;">
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.5rem;">
                        <h4 style="font-weight: 600; margin: 0; font-size: 1rem;">
                            <span style="text-transform: capitalize; color: {{ $estilo['color'] }};">{{ $actividad->accion }}</span>
                        </h4>
                        <span style="font-size: 0.875rem; color: var(--text-gray); display: flex; align-items: center; gap: 0.25rem;">
                            <i class="far fa-clock"></i>
                            {{ $actividad->created_at->format('H:i') }}
                        </span>
                    </div>
                    
                    @if($actividad->prompt)
                        <a href="{{ route('prompts.show', $actividad->prompt) }}" style="font-weight: 500; color: var(--primary-blue); text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                            <i class="fas fa-file-alt"></i>
                            {{ $actividad->prompt->titulo }}
                        </a>
                    @else
                        <p style="font-weight: 500; color: var(--text-gray); margin-bottom: 0.5rem;">
                            <i class="fas fa-file-alt"></i>
                            Prompt eliminado
                        </p>
                    @endif
                    
                    <p style="font-size: 0.9375rem; color: var(--text-gray); margin: 0;">
                        {{ $actividad->descripcion }}
                    </p>
                </div>
            </div>
        @empty
        <div class="empty-state">
            <i class="fas fa-history"></i>
            <h3>No hay actividades registradas</h3>
            <p>Las actividades aparecerán aquí a medida que uses el sistema</p>
        </div>
        @endforelse
    </div>
</div>

@if($actividades->hasPages())
<div style="margin-top: 1.5rem; display: flex; justify-content: center;">
    {{ $actividades->links() }}
</div>
@endif

<script>
function limpiarFiltros() {
    window.location.href = '{{ route("actividad.index") }}';
}

// Auto-submit al escribir en búsqueda (con debounce)
let searchTimeout;
document.getElementById('search').addEventListener('input', function() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        document.getElementById('filtrosForm').submit();
    }, 500);
});
</script>
@endsection

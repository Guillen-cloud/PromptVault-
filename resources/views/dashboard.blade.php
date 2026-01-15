@extends('layouts.app')

@section('title', 'Dashboard - PromptVault')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">{{ __('Dashboard') }}</h1>
        <p class="page-subtitle">{{ __('Resumen general del sistema') }}</p>
    </div>
</div>

<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-content">
            <h3>{{ __('Total de Prompts') }}</h3>
            <div class="stat-value">{{ $totalPrompts }}</div>
        </div>
        <div class="stat-icon blue">
            <i class="fas fa-file-alt"></i>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-content">
            <h3>{{ __('Prompts Favoritos') }}</h3>
            <div class="stat-value">{{ $promptsFavoritos }}</div>
        </div>
        <div class="stat-icon yellow">
            <i class="fas fa-star"></i>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-content">
            <h3>{{ __('Prompts Compartidos') }}</h3>
            <div class="stat-value">{{ $promptsCompartidos }}</div>
        </div>
        <div class="stat-icon green">
            <i class="fas fa-share-alt"></i>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-content">
            <h3>{{ __('Más Usados Este Mes') }}</h3>
            <div class="stat-value">{{ $promptsMasUsados }}</div>
        </div>
        <div class="stat-icon purple">
            <i class="fas fa-chart-line"></i>
        </div>
    </div>
</div>

<!-- Grid Layout -->
<div class="grid grid-2">
    <!-- Prompts por Categoría -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">{{ __('Prompts por Categoría') }}</h2>
        </div>
        <canvas id="categoryChart" height="200"></canvas>
        <div class="chart-legend">
            @foreach($promptsPorCategoria as $categoria)
            <div class="legend-item" style="margin-bottom: 0.75rem;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-weight: 500;">{{ __($categoria->nombre) }}</span>
                    <span style="color: var(--text-gray); font-size: 0.875rem;">{{ $categoria->prompts_count }} {{ __('prompts') }}</span>
                </div>
                <div style="width: 100%; height: 8px; background: var(--bg-gray); border-radius: 4px; margin-top: 0.25rem; overflow: hidden;">
                    <div style="width: {{ $totalPrompts > 0 ? ($categoria->prompts_count / $totalPrompts * 100) : 0 }}%; height: 100%; background: 
                        @if($categoria->nombre === 'Desarrollo') var(--primary-blue)
                        @elseif($categoria->nombre === 'Diseño') var(--secondary-green)
                        @elseif($categoria->nombre === 'Marketing') var(--secondary-orange)
                        @else var(--secondary-purple)
                        @endif
                    ;"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    
    <!-- Prompts Recientes -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">{{ __('Prompts Recientes') }}</h2>
            <a href="{{ route('prompts.index') }}" class="btn btn-sm btn-secondary">{{ __('Ver todos') }}</a>
        </div>
        
        @forelse($promptsRecientes as $prompt)
        <div style="padding: 1rem; border-bottom: 1px solid var(--border-gray); display: flex; justify-content: space-between; align-items: start;">
            <div style="flex: 1;">
                <h4 style="font-size: 0.875rem; font-weight: 600; margin-bottom: 0.25rem;">{{ $prompt->titulo }}</h4>
                <div style="display: flex; gap: 0.5rem; align-items: center; margin-bottom: 0.5rem;">
                    <span class="badge badge-blue">{{ $prompt->categoria->nombre ?? 'Sin categoría' }}</span>
                    <span class="badge badge-purple">{{ $prompt->ia_destino }}</span>
                    <span style="font-size: 0.75rem; color: var(--text-gray);">v{{ $prompt->numero_version }}</span>
                </div>
                <p style="font-size: 0.75rem; color: var(--text-gray);">
                    <i class="far fa-clock"></i> {{ $prompt->created_at->format('d-m-Y H:i') }}
                </p>
            </div>
            <div style="display: flex; gap: 0.25rem;">
                <a href="{{ route('prompts.show', $prompt) }}" class="action-btn">
                    <i class="fas fa-eye"></i>
                </a>
                <a href="{{ route('prompts.edit', $prompt) }}" class="action-btn">
                    <i class="fas fa-edit"></i>
                </a>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <i class="fas fa-inbox"></i>
            <h3>No hay prompts recientes</h3>
            <p>Crea tu primer prompt para comenzar</p>
            <a href="{{ route('prompts.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Crear Prompt
            </a>
        </div>
        @endforelse
    </div>
</div>
@endsection

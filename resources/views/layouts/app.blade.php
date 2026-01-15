<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'PromptVault - Sistema de Gestión de Prompts')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body data-theme="{{ Auth::check() ? Auth::user()->tema_preferido : 'light' }}">
    <div class="app-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h1 class="logo">PromptVault</h1>
                <p class="logo-subtitle">Sistema de Gestión de Prompts</p>
            </div>
            
            <nav class="sidebar-nav">
                <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i>
                    <span>Dashboard</span>
                </a>
                
                <a href="{{ route('prompts.index') }}" class="nav-item {{ request()->routeIs('prompts.*') ? 'active' : '' }}">
                    <i class="fas fa-file-alt"></i>
                    <span>Prompts</span>
                </a>
                
                <a href="{{ route('categorias.index') }}" class="nav-item {{ request()->routeIs('categorias.*') ? 'active' : '' }}">
                    <i class="fas fa-folder"></i>
                    <span>Categorías</span>
                </a>
                
                <a href="{{ route('etiquetas.index') }}" class="nav-item {{ request()->routeIs('etiquetas.*') ? 'active' : '' }}">
                    <i class="fas fa-tags"></i>
                    <span>Etiquetas</span>
                </a>
                
                <a href="{{ route('versiones.index') }}" class="nav-item {{ request()->routeIs('versiones.*') ? 'active' : '' }}">
                    <i class="fas fa-code-branch"></i>
                    <span>Versiones</span>
                </a>
                
                <a href="{{ route('compartidos.index') }}" class="nav-item {{ request()->routeIs('compartidos.*') ? 'active' : '' }}">
                    <i class="fas fa-share-alt"></i>
                    <span>Compartidos</span>
                </a>
                
                <a href="{{ route('actividad.index') }}" class="nav-item {{ request()->routeIs('actividad.*') ? 'active' : '' }}">
                    <i class="fas fa-history"></i>
                    <span>Actividad</span>
                </a>
                
                <a href="{{ route('configuracion.index') }}" class="nav-item {{ request()->routeIs('configuracion.*') ? 'active' : '' }}">
                    <i class="fas fa-cog"></i>
                    <span>Configuración</span>
                </a>
            </nav>
            
            <div class="sidebar-footer">
                <div class="user-info">
                    <div class="user-avatar">
                        <span>{{ strtoupper(substr(auth()->user()->name ?? 'UD', 0, 2)) }}</span>
                    </div>
                    <div class="user-details">
                        <p class="user-name">{{ auth()->user()->name ?? 'Usuario Demo' }}</p>
                        <p class="user-role">Estudiante</p>
                    </div>
                </div>
            </div>
        </aside>
        
        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <header class="app-header">
                <div class="header-left">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Buscar prompts, categorías, etiquetas...">
                    </div>
                </div>
            </header>
            
            <!-- Page Content -->
            <div class="content-wrapper">
                @if (session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        {{ session('success') }}
                    </div>
                @endif
                
                @if (session('error'))
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ session('error') }}
                    </div>
                @endif
                
                @yield('content')
            </div>
        </main>
    </div>
    
    <!-- Toast Notification -->
    <div id="toast" class="toast"></div>
    
    @stack('scripts')
</body>
</html>

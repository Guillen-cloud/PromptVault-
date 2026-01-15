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
<body data-theme="{{ auth()->check() && auth()->user()->tema_preferido ? auth()->user()->tema_preferido : 'light' }}">
    <div class="app-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h1 class="logo">PromptVault</h1>
                <p class="logo-subtitle">{{ __('Sistema de Gestión de Prompts') }}</p>
            </div>
            
            <nav class="sidebar-nav">
                <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i>
                    <span>{{ __('Dashboard') }}</span>
                </a>
                
                <a href="{{ route('prompts.index') }}" class="nav-item {{ request()->routeIs('prompts.*') ? 'active' : '' }}">
                    <i class="fas fa-file-alt"></i>
                    <span>{{ __('Prompts') }}</span>
                </a>
                
                <a href="{{ route('categorias.index') }}" class="nav-item {{ request()->routeIs('categorias.*') ? 'active' : '' }}">
                    <i class="fas fa-folder"></i>
                    <span>{{ __('Categorías') }}</span>
                </a>
                
                <a href="{{ route('etiquetas.index') }}" class="nav-item {{ request()->routeIs('etiquetas.*') ? 'active' : '' }}">
                    <i class="fas fa-tags"></i>
                    <span>{{ __('Etiquetas') }}</span>
                </a>
                
                <a href="{{ route('versiones.index') }}" class="nav-item {{ request()->routeIs('versiones.*') ? 'active' : '' }}">
                    <i class="fas fa-code-branch"></i>
                    <span>{{ __('Versiones') }}</span>
                </a>
                
                <a href="{{ route('compartidos.index') }}" class="nav-item {{ request()->routeIs('compartidos.*') ? 'active' : '' }}">
                    <i class="fas fa-share-alt"></i>
                    <span>{{ __('Compartidos') }}</span>
                </a>
                
                <a href="{{ route('actividad.index') }}" class="nav-item {{ request()->routeIs('actividad.*') ? 'active' : '' }}">
                    <i class="fas fa-history"></i>
                    <span>{{ __('Actividad') }}</span>
                </a>
                
                <a href="{{ route('configuracion.index') }}" class="nav-item {{ request()->routeIs('configuracion.*') ? 'active' : '' }}">
                    <i class="fas fa-cog"></i>
                    <span>{{ __('Configuración') }}</span>
                </a>
            </nav>
            
            <div class="sidebar-footer">
                <div class="user-info">
                    <div class="user-avatar">
                        <span>{{ auth()->check() ? strtoupper(substr(auth()->user()->name, 0, 2)) : 'UD' }}</span>
                    </div>
                    <div class="user-details">
                        <p class="user-name">{{ auth()->check() ? auth()->user()->name : 'Usuario Demo' }}</p>
                        <p class="user-role">Estudiante</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" style="margin-top: 10px;">
                    @csrf
                    <button type="submit" class="btn-logout">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Cerrar Sesión</span>
                    </button>
                </form>
            </div>
        </aside>
        
        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <header class="app-header">
                <div class="header-left">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="{{ __('Buscar prompts, categorías, etiquetas...') }}">
                    </div>
                </div>
                
                <div class="header-right">
                    <!-- Theme Toggle -->
                    <button class="header-btn" id="themeToggle" onclick="toggleTheme()">
                        <i class="fas fa-moon theme-icon"></i>
                    </button>
                    
                    <!-- Language Selector -->
                    <div class="dropdown">
                        <button class="header-btn" onclick="toggleDropdown('languageMenu', event)">
                            <i class="fas fa-globe"></i>
                            <span class="language-text">{{ strtoupper(app()->getLocale()) }}</span>
                            <i class="fas fa-chevron-down" style="font-size: 0.7rem; margin-left: 0.25rem;"></i>
                        </button>
                        <div class="dropdown-menu" id="languageMenu">
                            <a href="#" onclick="event.preventDefault(); changeLanguage('es')" class="dropdown-item {{ app()->getLocale() === 'es' ? 'active' : '' }}">
                                <span style="font-size: 1.2rem; margin-right: 0.5rem;">🇪🇸</span> Español
                            </a>
                            <a href="#" onclick="event.preventDefault(); changeLanguage('en')" class="dropdown-item {{ app()->getLocale() === 'en' ? 'active' : '' }}">
                                <span style="font-size: 1.2rem; margin-right: 0.5rem;">🇬🇧</span> English
                            </a>
                        </div>
                    </div>
                    
                    <!-- Notifications -->
                    <div class="dropdown">
                        <button class="header-btn" onclick="toggleDropdown('notificationsMenu', event)">
                            <i class="fas fa-bell"></i>
                            <span class="notification-badge">3</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-wide" id="notificationsMenu">
                            <div class="dropdown-header">
                                <span>{{ __('Notificaciones') }}</span>
                                <a href="#" class="mark-all-read">{{ __('Marcar todas como leídas') }}</a>
                            </div>
                            <div class="notification-item unread">
                                <i class="fas fa-info-circle text-primary"></i>
                                <div>
                                    <p class="notification-text">{{ __('Bienvenido a PromptVault') }}</p>
                                    <span class="notification-time">{{ __('Hace 5 min') }}</span>
                                </div>
                            </div>
                            <div class="notification-item">
                                <i class="fas fa-check-circle text-success"></i>
                                <div>
                                    <p class="notification-text">{{ __('Prompt creado exitosamente') }}</p>
                                    <span class="notification-time">{{ __('Hace 1 hora') }}</span>
                                </div>
                            </div>
                            <div class="notification-item">
                                <i class="fas fa-share-alt text-info"></i>
                                <div>
                                    <p class="notification-text">{{ __('Prompt compartido con el equipo') }}</p>
                                    <span class="notification-time">{{ __('Hace 2 horas') }}</span>
                                </div>
                            </div>
                            <a href="#" class="dropdown-footer">{{ __('Ver todas las notificaciones') }}</a>
                        </div>
                    </div>
                    
                    <!-- User Menu -->
                    <div class="dropdown">
                        <button class="header-btn user-btn" onclick="toggleDropdown('userMenu', event)">
                            <div class="user-avatar-small">
                                <span>{{ auth()->check() ? strtoupper(substr(auth()->user()->name, 0, 2)) : 'U' }}</span>
                            </div>
                            <i class="fas fa-chevron-down" style="font-size: 0.7rem;"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" id="userMenu">
                            <div class="dropdown-user-info">
                                <div class="user-avatar-large">
                                    <span>{{ auth()->check() ? strtoupper(substr(auth()->user()->name, 0, 2)) : 'U' }}</span>
                                </div>
                                <div>
                                    <p class="dropdown-user-name">{{ auth()->check() ? auth()->user()->name : 'Usuario' }}</p>
                                    <p class="dropdown-user-email">{{ auth()->check() ? auth()->user()->email : '' }}</p>
                                </div>
                            </div>
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('configuracion.index') }}" class="dropdown-item">
                                <i class="fas fa-user-circle"></i> {{ __('Mi Perfil') }}
                            </a>
                            <a href="{{ route('configuracion.index') }}" class="dropdown-item">
                                <i class="fas fa-cog"></i> {{ __('Configuración') }}
                            </a>
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt"></i> {{ __('Cerrar Sesión') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Breadcrumbs -->
            @if (!request()->routeIs('dashboard'))
            <nav class="breadcrumbs">
                <a href="{{ route('dashboard') }}" class="breadcrumb-item">
                    <i class="fas fa-home"></i>
                </a>
                <span class="breadcrumb-separator">/</span>
                @yield('breadcrumbs')
            </nav>
            @endif
            
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

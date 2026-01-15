<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PromptVault - Tu Biblioteca Personal de Prompts</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css'])
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            overflow-x: hidden;
        }

        .landing-container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Navbar */
        .navbar {
            padding: 1.5rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .logo-icon {
            width: 50px;
            height: 50px;
            background: white;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: #667eea;
        }

        .logo-text h1 {
            color: white;
            font-size: 1.75rem;
            font-weight: 700;
        }

        .logo-text p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.875rem;
        }

        .nav-buttons {
            display: flex;
            gap: 1rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-outline {
            background: transparent;
            color: white;
            border: 2px solid white;
        }

        .btn-outline:hover {
            background: white;
            color: #667eea;
            transform: translateY(-2px);
        }

        .btn-solid {
            background: white;
            color: #667eea;
            border: 2px solid white;
        }

        .btn-solid:hover {
            background: #667eea;
            color: white;
            border-color: white;
            transform: translateY(-2px);
        }

        /* Hero Section */
        .hero {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 4rem 5%;
            text-align: center;
        }

        .hero-content {
            max-width: 900px;
        }

        .hero-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 2rem;
            backdrop-filter: blur(10px);
        }

        .hero h1 {
            color: white;
            font-size: 4rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1.5rem;
        }

        .hero h1 .highlight {
            background: linear-gradient(90deg, #fff, #e0e7ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.25rem;
            line-height: 1.8;
            margin-bottom: 3rem;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        .hero-buttons {
            display: flex;
            gap: 1.5rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-large {
            padding: 1rem 2.5rem;
            font-size: 1.125rem;
        }

        /* Features */
        .features {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 4rem 5%;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            padding: 2rem;
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: transform 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background: white;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            color: #667eea;
            margin-bottom: 1.5rem;
        }

        .feature-card h3 {
            color: white;
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
        }

        .feature-card p {
            color: rgba(255, 255, 255, 0.85);
            line-height: 1.6;
        }

        /* Stats */
        .stats {
            padding: 3rem 5%;
            display: flex;
            justify-content: center;
            gap: 4rem;
            flex-wrap: wrap;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            color: white;
            font-size: 3rem;
            font-weight: 800;
            display: block;
        }

        .stat-label {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1rem;
            margin-top: 0.5rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }

            .hero p {
                font-size: 1rem;
            }

            .navbar {
                padding: 1rem 5%;
            }

            .logo-text h1 {
                font-size: 1.25rem;
            }

            .stats {
                gap: 2rem;
            }

            .stat-number {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="landing-container">
        <!-- Navbar -->
        <nav class="navbar">
            <div class="logo-section">
                <div class="logo-icon">
                    <i class="fas fa-bolt"></i>
                </div>
                <div class="logo-text">
                    <h1>PromptVault</h1>
                    <p>Tu biblioteca personal</p>
                </div>
            </div>
            <div class="nav-buttons">
                <a href="{{ route('login') }}" class="btn btn-outline">
                    <i class="fas fa-sign-in-alt"></i>
                    Iniciar Sesión
                </a>
                <a href="{{ route('register') }}" class="btn btn-solid">
                    <i class="fas fa-user-plus"></i>
                    Registrarse
                </a>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="hero">
            <div class="hero-content">
                <span class="hero-badge">
                    <i class="fas fa-star"></i> Sistema de Gestión Profesional
                </span>
                <h1>
                    Tu Biblioteca Personal de <span class="highlight">Prompts</span>
                </h1>
                <p>
                    Organiza, gestiona y optimiza todos tus prompts de IA en un solo lugar. 
                    Con control de versiones, categorización inteligente y colaboración en tiempo real.
                </p>
                <div class="hero-buttons">
                    <a href="{{ route('register') }}" class="btn btn-solid btn-large">
                        <i class="fas fa-rocket"></i>
                        Comenzar Gratis
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-outline btn-large">
                        <i class="fas fa-sign-in-alt"></i>
                        Iniciar Sesión
                    </a>
                </div>
            </div>
        </section>

        <!-- Stats -->
        <div class="stats">
            <div class="stat-item">
                <span class="stat-number">
                    <i class="fas fa-infinity"></i>
                </span>
                <span class="stat-label">Prompts Ilimitados</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">
                    <i class="fas fa-folder"></i>
                </span>
                <span class="stat-label">Organización Total</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">
                    <i class="fas fa-shield-alt"></i>
                </span>
                <span class="stat-label">100% Seguro</span>
            </div>
        </div>

        <!-- Features -->
        <section class="features">
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <h3>Gestión de Prompts</h3>
                    <p>Crea, edita y organiza todos tus prompts con búsqueda avanzada y filtros inteligentes.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-folder-open"></i>
                    </div>
                    <h3>Categorías y Etiquetas</h3>
                    <p>Organiza tus prompts con categorías personalizadas y etiquetas para encontrarlos al instante.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-code-branch"></i>
                    </div>
                    <h3>Control de Versiones</h3>
                    <p>Mantén un historial completo de cambios y restaura versiones anteriores cuando lo necesites.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-share-alt"></i>
                    </div>
                    <h3>Colaboración</h3>
                    <p>Comparte prompts con tu equipo y colabora en tiempo real de forma segura.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>Dashboard Analítico</h3>
                    <p>Visualiza métricas clave y estadísticas de uso de tus prompts más utilizados.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-palette"></i>
                    </div>
                    <h3>Tema Personalizable</h3>
                    <p>Modo claro/oscuro y soporte multi-idioma para adaptarse a tus preferencias.</p>
                </div>
            </div>
        </section>
    </div>
</body>
</html>

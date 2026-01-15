<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Página no encontrada | PromptVault</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css'])
    <style>
        .error-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 2rem;
        }

        .error-container {
            text-align: center;
            max-width: 600px;
        }

        .error-code {
            font-size: 10rem;
            font-weight: 800;
            color: white;
            line-height: 1;
            margin-bottom: 1rem;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        .error-icon {
            font-size: 6rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 2rem;
        }

        .error-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: white;
            margin-bottom: 1rem;
        }

        .error-message {
            font-size: 1.25rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 3rem;
            line-height: 1.6;
        }

        .error-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-error {
            padding: 1rem 2rem;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1.125rem;
        }

        .btn-primary-error {
            background: white;
            color: #667eea;
        }

        .btn-primary-error:hover {
            background: #f0f0f0;
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .btn-secondary-error {
            background: transparent;
            color: white;
            border: 2px solid white;
        }

        .btn-secondary-error:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        .suggestions {
            margin-top: 3rem;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .suggestions h3 {
            color: white;
            font-size: 1.25rem;
            margin-bottom: 1rem;
        }

        .suggestions ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .suggestions li {
            margin-bottom: 0.75rem;
        }

        .suggestions a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: transform 0.2s ease;
        }

        .suggestions a:hover {
            transform: translateX(5px);
        }

        @media (max-width: 768px) {
            .error-code {
                font-size: 6rem;
            }

            .error-title {
                font-size: 1.75rem;
            }

            .error-message {
                font-size: 1rem;
            }

            .error-icon {
                font-size: 4rem;
            }
        }
    </style>
</head>
<body>
    <div class="error-page">
        <div class="error-container">
            <div class="error-icon">
                <i class="fas fa-compass"></i>
            </div>
            <h1 class="error-code">404</h1>
            <h2 class="error-title">¡Oops! Página no encontrada</h2>
            <p class="error-message">
                La página que estás buscando no existe o ha sido movida. 
                No te preocupes, te ayudamos a volver al camino correcto.
            </p>

            <div class="error-actions">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn-error btn-primary-error">
                        <i class="fas fa-home"></i>
                        Ir al Dashboard
                    </a>
                    <a href="{{ route('prompts.index') }}" class="btn-error btn-secondary-error">
                        <i class="fas fa-file-alt"></i>
                        Ver mis Prompts
                    </a>
                @else
                    <a href="{{ url('/') }}" class="btn-error btn-primary-error">
                        <i class="fas fa-home"></i>
                        Ir al Inicio
                    </a>
                    <a href="{{ route('login') }}" class="btn-error btn-secondary-error">
                        <i class="fas fa-sign-in-alt"></i>
                        Iniciar Sesión
                    </a>
                @endauth
            </div>

            @auth
            <div class="suggestions">
                <h3><i class="fas fa-lightbulb"></i> Páginas populares</h3>
                <ul>
                    <li>
                        <a href="{{ route('dashboard') }}">
                            <i class="fas fa-chart-line"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('prompts.index') }}">
                            <i class="fas fa-file-alt"></i> Mis Prompts
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('prompts.create') }}">
                            <i class="fas fa-plus"></i> Crear Nuevo Prompt
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('categorias.index') }}">
                            <i class="fas fa-folder"></i> Categorías
                        </a>
                    </li>
                </ul>
            </div>
            @endauth
        </div>
    </div>
</body>
</html>

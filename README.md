# 🚀 PromptVault

**Sistema de Gestión de Prompts para IA**

Un sistema completo para crear, organizar, versionar y compartir prompts para modelos de inteligencia artificial.

![Laravel](https://img.shields.io/badge/Laravel-11-red?logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2-blue?logo=php)
![MySQL](https://img.shields.io/badge/MySQL-8.0-orange?logo=mysql)
![License](https://img.shields.io/badge/License-MIT-green)

---

## 📋 Tabla de Contenidos

-   [Características](#-características)
-   [Requisitos](#-requisitos)
-   [Instalación](#-instalación)
-   [Configuración](#-configuración)
-   [Uso](#-uso)
-   [Estructura del Proyecto](#-estructura-del-proyecto)
-   [Tecnologías](#-tecnologías)
-   [Colaboradores](#-colaboradores)
-   [Licencia](#-licencia)

---

## ✨ Características

### � Autenticación y Seguridad

-   ✅ Sistema de login y registro
-   ✅ Validación robusta con Form Requests
-   ✅ Políticas de autorización (solo dueño edita)
-   ✅ Protección de rutas con middleware
-   ✅ Mensajes de error en español

### 📝 Gestión de Prompts

-   ✅ Crear, editar y eliminar prompts
-   ✅ Organización por categorías y etiquetas
-   ✅ Búsqueda avanzada (título, contenido, descripción)
-   ✅ Filtros por categoría, etiqueta, IA destino
-   ✅ Marcado de favoritos
-   ✅ Contador de usos
-   ✅ Prompts privados y públicos

### 🔄 Sistema de Versiones

-   ✅ Control de versiones de cada prompt
-   ✅ Comparación entre versiones
-   ✅ Restauración de versiones anteriores
-   ✅ Historial completo de cambios

### 🤝 Colaboración

-   ✅ Compartir prompts con otros usuarios
-   ✅ Prompts públicos y privados
-   ✅ Historial de actividades
-   ✅ Exportación de datos

### 🎨 Interfaz

-   ✅ Dashboard con métricas clave
-   ✅ Diseño moderno y responsive
-   ✅ Tema claro/oscuro
-   ✅ Multi-idioma (Español/Inglés)

### 🧪 Calidad de Código

-   ✅ 12 tests automatizados
-   ✅ Validaciones centralizadas  
-   ✅ Código documentado
-   ✅ Políticas de autorización

---

## 🔧 Requisitos

### Software Necesario

-   **PHP:** >= 8.2
-   **Composer:** >= 2.0
-   **Node.js:** >= 18.0
-   **NPM:** >= 9.0
-   **MySQL:** >= 8.0 o **MariaDB** >= 10.3

### Extensiones de PHP Requeridas

```bash
php-mbstring
php-xml
php-curl
php-zip
php-mysql
php-pdo
```

---

## 📦 Instalación

### 1️⃣ Clonar el Repositorio

```bash
git clone https://github.com/Guillen-cloud/PromptVault-.git
cd PromptVault-
```

### 2️⃣ Instalar Dependencias

```bash
# Dependencias de PHP
composer install

# Dependencias de JavaScript
npm install
```

### 3️⃣ Configurar Variables de Entorno

```bash
# Copiar archivo de ejemplo
cp .env.example .env

# Generar clave de aplicación
php artisan key:generate
```

### 4️⃣ Configurar Base de Datos

Edita el archivo `.env` con tus credenciales:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=promptvault
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

### 5️⃣ Crear Base de Datos

```bash
# Opción 1: MySQL Command Line
mysql -u root -p
CREATE DATABASE promptvault CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
exit;

# Opción 2: Usar script incluido (Windows)
setup_database.bat
```

### 6️⃣ Ejecutar Migraciones y Seeders

```bash
# Ejecutar migraciones
php artisan migrate

# Poblar con datos de prueba
php artisan db:seed
```

### 7️⃣ Compilar Assets

```bash
# Desarrollo
npm run dev

# Producción
npm run build
```

### 8️⃣ Iniciar Servidor

```bash
php artisan serve
```

Ahora puedes acceder a: **http://localhost:8000**

---

## ⚙️ Configuración

### Usuarios de Prueba

Después de ejecutar `php artisan db:seed`, puedes usar:

**Usuario Demo:**

-   Email: `demo@promptvault.com`
-   Password: `password`

**Usuario Admin:**

-   Email: `admin@promptvault.com`
-   Password: `password`

### Configuración de Idioma

El sistema soporta múltiples idiomas:

-   Español (por defecto)
-   Inglés
-   Portugués (Brasil)
-   Francés

Cambiar en: Dashboard → Selector de idioma

---

## 🎯 Uso

### Crear un Prompt

1. Ve a **Prompts** en el menú lateral
2. Click en **Nuevo Prompt**
3. Llena el formulario:
    - Título
    - Contenido
    - Descripción
    - Categoría
    - IA Destino (ChatGPT, Claude, etc.)
    - Etiquetas
4. Click en **Guardar**

### Buscar Prompts

Usa la barra de búsqueda en la parte superior para buscar por:

-   Título
-   Contenido
-   Descripción

O usa los filtros avanzados:

-   Por categoría
-   Por etiqueta
-   Por IA destino
-   Solo favoritos

### Sistema de Versiones

1. Abre un prompt
2. Click en **Versiones**
3. Ver historial completo
4. Comparar versiones
5. Restaurar versión anterior

---

## 📁 Estructura del Proyecto

```
ProyectoFinal_v1/
├── app/
│   ├── Http/
│   │   └── Controllers/      # Controladores
│   └── Models/               # Modelos Eloquent
├── database/
│   ├── migrations/           # Migraciones de BD
│   └── seeders/              # Datos de prueba
├── resources/
│   ├── css/                  # Estilos
│   ├── js/                   # JavaScript
│   └── views/                # Vistas Blade
│       ├── auth/             # Login/Register
│       ├── layouts/          # Layout principal
│       ├── prompts/          # CRUD de prompts
│       ├── categorias/       # Gestión de categorías
│       └── ...
├── routes/
│   └── web.php               # Rutas de la aplicación
├── public/                   # Assets públicos
├── .env.example              # Variables de entorno ejemplo
├── composer.json             # Dependencias PHP
├── package.json              # Dependencias JS
└── README.md                 # Este archivo
```

---

## 🛠️ Tecnologías

### Backend

-   **Laravel 11** - Framework PHP
-   **MySQL 8** - Base de datos
-   **PHP 8.2** - Lenguaje

### Frontend

-   **Blade** - Motor de plantillas
-   **Vite** - Build tool
-   **CSS3** - Estilos personalizados
-   **JavaScript (Vanilla)** - Interactividad

### Herramientas

-   **Composer** - Gestor de dependencias PHP
-   **NPM** - Gestor de dependencias JS
-   **Git** - Control de versiones

---

## 👥 Colaboradores

Este proyecto fue desarrollado por:

-   [Guillen-cloud](https://github.com/Guillen-cloud) - Desarrollador Principal

### ¿Quieres colaborar?

1. Fork el proyecto
2. Crea una rama (`git checkout -b feature/nueva-funcionalidad`)
3. Commit tus cambios (`git commit -m 'Añadir nueva funcionalidad'`)
4. Push a la rama (`git push origin feature/nueva-funcionalidad`)
5. Abre un Pull Request

Ver [GUIA_COLABORACION.md](GUIA_COLABORACION.md) para más detalles.

---

## 📝 Comandos Útiles

```bash
# Limpiar caché
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Resetear base de datos
php artisan migrate:fresh --seed

# Ejecutar tests
php artisan test

# Ver rutas
php artisan route:list

# Compilar assets en modo watch
npm run dev
```

---

## 🐛 Solución de Problemas

### Error: "Class not found"

```bash
composer dump-autoload
```

### Error en migraciones

```bash
php artisan migrate:fresh --seed
```

### Assets no se cargan

```bash
npm run build
php artisan storage:link
```

### Error 500 en producción

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 📄 Licencia

Este proyecto está bajo la Licencia MIT. Ver archivo [LICENSE](LICENSE) para más detalles.

---

## 📞 Contacto

-   **Repositorio:** [https://github.com/Guillen-cloud/PromptVault-](https://github.com/Guillen-cloud/PromptVault-)
-   **Issues:** [https://github.com/Guillen-cloud/PromptVault-/issues](https://github.com/Guillen-cloud/PromptVault-/issues)

---

## 🙏 Agradecimientos

-   Laravel Framework
-   Comunidad de código abierto
-   Profesores y compañeros de universidad

---

**Desarrollado con ❤️ para la gestión eficiente de prompts de IA**

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

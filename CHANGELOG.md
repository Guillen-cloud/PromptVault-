# 📝 Changelog - PromptVault

Todos los cambios notables en este proyecto serán documentados en este archivo.

El formato está basado en [Keep a Changelog](https://keepachangelog.com/es-ES/1.0.0/),
y este proyecto adhiere a [Semantic Versioning](https://semver.org/lang/es/).

---

## [1.4.0] - 2026-01-15

### ✨ Añadido

#### Header Rediseñado - Interfaz de Usuario Completa

-   **Toggle de Tema (Modo Claro/Oscuro)**

    -   Botón con icono de luna/sol en el header
    -   Función `toggleTheme()` en app.js
    -   Persistencia en localStorage
    -   Cambio visual instantáneo sin recarga
    -   Atributo `data-theme` en document para CSS personalizado

-   **Selector de Idioma Mejorado**

    -   Dropdown con banderas emoji (🇪🇸 🇬🇧)
    -   Muestra solo código de idioma (ES/EN) con chevron en botón
    -   Función `changeLanguage(locale)` con fetch API
    -   Integración con ruta `/change-language`
    -   Recarga automática tras cambio de idioma
    -   Indicador visual del idioma activo en dropdown

-   **Sistema de Notificaciones**

    -   Dropdown de notificaciones con badge numérico
    -   Badge rojo con contador de notificaciones no leídas
    -   Tres tipos de notificaciones con iconos diferenciados:
        -   Nuevo prompt compartido (azul)
        -   Nueva versión disponible (verde)
        -   Comentario recibido (info)
    -   Cada notificación muestra:
        -   Icono según tipo
        -   Mensaje descriptivo
        -   Timestamp relativo
    -   Enlace "Ver todas" para página completa de notificaciones
    -   Clases `.unread` para resaltar notificaciones pendientes
    -   Preparado para integración con backend real

-   **Menú de Usuario Rediseñado**
    -   Avatar circular con iniciales del usuario (solo en botón)
    -   Chevron para indicar dropdown
    -   Información completa visible en dropdown:
        -   Avatar grande con gradiente
        -   Nombre completo del usuario
        -   Email del usuario
    -   Opciones del menú:
        -   Ver perfil
        -   Configuración
        -   Cerrar sesión (estilo rojo)

### 🎨 Mejorado

#### Estilos CSS del Header

-   **Layout Limpio y Profesional**

    -   Header compacto con botones minimalistas
    -   Solo información esencial visible (iconos, códigos)
    -   Detalles completos dentro de dropdowns
    -   Espaciado optimizado entre elementos
    -   Avatares con gradiente y sombras suaves

-   **Dropdowns Mejorados**

    -   `.dropdown-menu-wide` para notificaciones (320px)
    -   `.dropdown-menu-right` alineado a la derecha
    -   Animación `slideDown` suave (0.2s ease)
    -   Sombra elevada para profundidad visual
    -   Border-radius 12px para modernidad
    -   `.dropdown-header` con justify-between
    -   `.dropdown-divider` para separar secciones
    -   `.dropdown-footer` para enlaces de acción

-   **Notificaciones Estilizadas**

    -   `.notification-item` con layout flex
    -   Background diferenciado para `.unread`
    -   Iconos grandes (1.25rem) con colores según tipo
    -   `.notification-text` y `.notification-time` con sizing apropiado
    -   Hover state sutil para interactividad

-   **Usuario Info Display**

    -   `.dropdown-user-info` con avatar large y textos
    -   `.dropdown-user-name` en bold
    -   `.dropdown-user-email` en tamaño pequeño y color gris
    -   Separación visual con padding generoso

-   **Responsive y Accesibilidad**
    -   Z-index 9999 para dropdowns sobre todo contenido
    -   Transiciones suaves (0.2s ease) en todos los elementos
    -   Colores de texto consistentes con variables CSS
    -   Cursor pointer en elementos clickeables
    -   Focus states implícitos para navegación por teclado

### 🐛 Corregido

-   **Selector de Idioma Duplicado**

    -   Eliminado selector redundante en dashboard.blade.php
    -   Consolidado selector único en header global
    -   Mantenido solo dropdown limpio con banderas emoji

-   **CSS Duplicado**

    -   Eliminada sección duplicada de `.dropdown-menu` (líneas 858-1050)
    -   Consolidadas reglas de dropdowns en una sola sección
    -   Limpiados estilos de `.notification-item` duplicados
    -   Removidos estilos redundantes de `.user-avatar-*`
    -   CSS ahora es más mantenible y sin conflictos

-   **Diseño del Header**
    -   Simplificado botón de usuario (solo avatar + chevron)
    -   Información de usuario movida exclusivamente al dropdown
    -   Chevrons reducidos a 0.7rem para mejor proporción
    -   Agregado `event.preventDefault()` en cambio de idioma
    -   Botones más compactos y profesionales

### 🔧 Técnico

#### JavaScript Functions

-   `toggleTheme()`: Alterna entre modo claro y oscuro, guarda en localStorage
-   `changeLanguage(locale)`: POST request a backend con CSRF token, recarga página
-   Ambas funciones expuestas en window global para uso en onclick
-   Manejo de errores con console.error

#### Estructura HTML (app.blade.php)

-   Sección `.header-right` completamente implementada
-   Uso de Font Awesome 6.5.1 para todos los iconos
-   Blade directives para autenticación y datos de usuario
-   Forms con CSRF para logout
-   Dropdown menus con clase `.show` controlada por JS
-   Preparado para datos dinámicos desde backend

#### Optimizaciones

-   CSS consolidado en una sola sección para dropdowns
-   Eliminados selectores duplicados en vistas
-   Assets recompilados con Vite para aplicar cambios
-   Gradientes en avatares para mejor estética visual

---

    -   Muestra nombre completo y email
    -   Dos tamaños de avatar (32px header, 48px dropdown)
    -   Opciones del menú:
        -   Ver perfil (icono usuario)
        -   Configuración (icono engranaje)
        -   Cerrar sesión (icono rojo, logout form)
    -   Divider visual entre secciones
    -   Hover states en todos los elementos
    -   Avatar con fondo de color primario

### 🎨 Mejorado

#### Estilos CSS del Header

-   **Layout y Posicionamiento**

    -   `.header-right` con flex y gap consistente
    -   `.header-btn` con padding, border-radius y transiciones
    -   Hover states uniformes en todos los botones
    -   Badge posicionado absolute para notificaciones
    -   Avatares con border-radius circular perfecto

-   **Dropdowns Mejorados**

    -   `.dropdown-menu-wide` para notificaciones (320px)
    -   `.dropdown-menu-right` alineado a la derecha
    -   Animación `slideDown` suave (0.2s ease)
    -   Sombra elevada para profundidad visual
    -   Border-radius 12px para modernidad
    -   `.dropdown-header` con justify-between
    -   `.dropdown-divider` para separar secciones
    -   `.dropdown-footer` para enlaces de acción

-   **Notificaciones Estilizadas**

    -   `.notification-item` con layout flex
    -   Background diferenciado para `.unread`
    -   Iconos grandes (1.25rem) con colores según tipo
    -   `.notification-text` y `.notification-time` con sizing apropiado
    -   Hover state sutil para interactividad

-   **Usuario Info Display**

    -   `.dropdown-user-info` con avatar large y textos
    -   `.dropdown-user-name` en bold
    -   `.dropdown-user-email` en tamaño pequeño y color gris
    -   Separación visual con padding generoso

-   **Responsive y Accesibilidad**
    -   Z-index 9999 para dropdowns sobre todo contenido
    -   Transiciones suaves (0.2s ease) en todos los elementos
    -   Colores de texto consistentes con variables CSS
    -   Cursor pointer en elementos clickeables
    -   Focus states implícitos para navegación por teclado

### 🔧 Técnico

#### JavaScript Functions

-   `toggleTheme()`: Alterna entre modo claro y oscuro, guarda en localStorage
-   `changeLanguage(locale)`: POST request a backend con CSRF token, recarga página
-   Ambas funciones expuestas en window global para uso en onclick
-   Manejo de errores con console.error

#### Estructura HTML (app.blade.php)

-   Sección `.header-right` completamente implementada
-   Uso de Font Awesome 6.5.1 para todos los iconos
-   Blade directives para autenticación y datos de usuario
-   Forms con CSRF para logout
-   Dropdown menus con clase `.show` controlada por JS
-   Preparado para datos dinámicos desde backend

---

## [1.3.0] - 2026-01-15

### ✨ Añadido

#### Funcionalidades Avanzadas

-   **Página 404 Personalizada (errors/404.blade.php)**

    -   Diseño moderno con gradiente consistente con el resto de la aplicación
    -   Código de error grande (404) con iconos Font Awesome
    -   Mensajes amigables y orientadores para el usuario
    -   Botones de navegación contextuales según estado de autenticación
    -   Sección de sugerencias con páginas populares para usuarios autenticados
    -   Totalmente responsive para móviles y tablets
    -   Manejo automático por Laravel cuando una ruta no existe

-   **Exportar Prompts a CSV**
    -   Función `export()` en PromptController
    -   Botón "Exportar CSV" en la vista de índice de prompts
    -   Respeta filtros activos (búsqueda, categoría, etiquetas)
    -   Formato CSV con UTF-8 BOM para compatibilidad con Excel
    -   Nombre de archivo con timestamp: `prompts_YYYY-MM-DD_HHMMSS.csv`
    -   Columnas exportadas:
        -   ID del prompt
        -   Título y descripción
        -   Contenido completo
        -   Categoría asociada
        -   Etiquetas (separadas por coma)
        -   IA destino
        -   Estado público/privado
        -   Marcado como favorito
        -   Número de veces usado
        -   Fecha de creación
    -   Descarga directa sin necesidad de almacenamiento temporal

### ✅ Confirmado

-   **Paginación en Prompts**
    -   Ya implementada con `paginate(10)`
    -   10 prompts por página
    -   Links de navegación estilizados
    -   Funciona correctamente con filtros

---

## [1.2.0] - 2026-01-15

### ✨ Añadido

#### Landing Page Profesional

-   **Página de Bienvenida (welcome.blade.php)**
    -   Diseño moderno con gradiente púrpura-violeta
    -   Navbar con logo y botones de acceso
    -   Hero section con título destacado y call-to-action
    -   Grid de 6 características principales
    -   Sección de estadísticas (Prompts Ilimitados, Organización, Seguridad)
    -   Totalmente responsive
    -   Ruta `/` ahora muestra landing page para usuarios no autenticados
    -   Ruta `/welcome` siempre accesible

#### Mejoras UI/UX

-   **Loading Spinners**

    -   Spinners automáticos en todos los formularios al enviar
    -   Animación de rotación con Font Awesome
    -   Deshabilitación automática de botones durante carga
    -   Texto "Cargando..." con icono giratorio
    -   Restauración automática del estado original

-   **Confirmaciones Elegantes con SweetAlert2**

    -   Reemplazadas confirmaciones nativas (`alert()`) por diálogos elegantes
    -   Iconos y colores personalizados por tipo de acción
    -   Botones con iconos Font Awesome
    -   Animaciones suaves y diseño moderno
    -   Configuración de colores: rojo para eliminar, gris para cancelar

-   **Sistema de Breadcrumbs**

    -   Navegación breadcrumb en todas las páginas (excepto dashboard)
    -   Iconos Font Awesome para cada sección
    -   Link al home siempre visible
    -   Estilos hover suaves
    -   Integrado en layout principal

-   **Botón Cerrar Sesión Mejorado**
    -   Posición sticky en sidebar footer (siempre visible)
    -   Diseño destacado con color rojo y sombra
    -   Icono de salida
    -   Efecto hover más pronunciado
    -   Fondo blanco para contraste

### 🗑️ Eliminado

#### Limpieza de Archivos Innecesarios

-   **Archivos SQL duplicados**

    -   `database/laravel_tables.sql`
    -   `database/promptvault_schema.sql`
    -   `database/schema.sql`
    -   `database/seed_data.sql`

-   **Scripts no utilizados**

    -   `clean_prompts.py` - Script Python innecesario
    -   `crear_db.sql` - Duplicado de migraciones
    -   `setup_database.bat` - Script Windows no requerido

-   **Tests de ejemplo**
    -   `tests/Feature/ExampleTest.php` - Test que fallaba
    -   `tests/Unit/ExampleTest.php` - Test no utilizado

### 🔄 Modificado

#### Rutas (web.php)

-   Ruta raíz `/` ahora muestra landing page
-   Ruta `/welcome` agregada para acceso directo a landing
-   Ruta de logout implementada correctamente

#### Layout Principal (app.blade.php)

-   Agregada sección de breadcrumbs
-   Botón de cerrar sesión movido a sidebar footer
-   Estilos mejorados para botón de sesión

#### Estilos (app.css)

-   Agregados estilos para breadcrumbs
-   Agregada animación de spinner
-   Estilos para estados disabled de botones
-   Mejoras en sidebar footer (sticky positioning)

---

## [1.1.0] - 2026-01-15

### ✨ Añadido

#### Sistema de Validación con Form Requests

-   **StorePromptRequest** - Validación al crear prompts

    -   Validación de título (máx. 180 caracteres)
    -   Validación de contenido (obligatorio)
    -   Validación de categoría (debe existir)
    -   Validación de IA destino (máx. 60 caracteres)
    -   Validación de etiquetas (deben existir)
    -   Mensajes de error personalizados en español

-   **UpdatePromptRequest** - Validación al actualizar prompts

    -   Validaciones opcionales con `sometimes`
    -   Conversión automática de booleanos
    -   Mensajes de error en español

-   **StoreCategoriaRequest** - Validación de categorías

    -   Nombre único (máx. 60 caracteres)
    -   Descripción opcional (máx. 300 caracteres)
    -   Validación de color hexadecimal

-   **StoreEtiquetaRequest** - Validación de etiquetas
    -   Nombre único (máx. 50 caracteres)
    -   Validación de color hexadecimal

#### Sistema de Políticas de Autorización

-   **PromptPolicy** - Control de acceso a prompts
    -   `view()` - Solo ver prompts públicos o propios
    -   `update()` - Solo el dueño puede actualizar
    -   `delete()` - Solo el dueño puede eliminar
    -   `create()` - Todos los usuarios autenticados pueden crear
    -   Protección automática contra accesos no autorizados

#### Suite de Tests

-   **PromptTest** (6 tests)

    -   ✅ Usuario puede crear prompt
    -   ✅ Usuario puede ver sus prompts
    -   ✅ Usuario NO puede editar prompts ajenos
    -   ✅ Búsqueda funciona correctamente
    -   ✅ Sistema de favoritos funciona
    -   ✅ Rutas requieren autenticación

-   **AuthTest** (6 tests)
    -   ✅ Login con credenciales válidas
    -   ✅ Login falla con credenciales inválidas
    -   ✅ Registro de usuario funciona
    -   ✅ Registro falla con email duplicado
    -   ✅ Logout funciona correctamente
    -   ✅ Usuario autenticado redirige desde login

### 🔄 Modificado

#### PromptController

-   Implementado `authorizeResource` en constructor
-   Reemplazadas validaciones manuales por Form Requests
-   Filtrado de prompts por usuario autenticado
-   Uso de `auth()->id()` en lugar de user_id hardcodeado

#### Seguridad

-   Los prompts ahora filtran por `user_id` o `es_publico`
-   Protección automática con políticas
-   Validaciones más robustas

### 📚 Documentación

-   Creado CHANGELOG.md
-   Creado TESTING.md con guía de tests
-   Actualizado README.md con nuevas características

---

## [1.0.0] - 2026-01-15

### ✨ Añadido

#### Sistema de Autenticación

-   **AuthController** con login, register y logout
-   Vistas de autenticación con diseño moderno
-   Validaciones en español
-   Sistema de "recordar sesión"
-   Protección de rutas con middleware `auth`

#### Documentación Inicial

-   README.md completo con:
    -   Instrucciones de instalación
    -   Requisitos del sistema
    -   Guía de uso
    -   Estructura del proyecto
    -   Comandos útiles
-   GUIA_COLABORACION.md para trabajo en equipo

#### Estructura Base

-   Sistema CRUD de Prompts
-   Gestión de Categorías
-   Gestión de Etiquetas
-   Sistema de Versiones
-   Dashboard con métricas
-   Búsqueda y filtros
-   Sistema de favoritos

### 🔄 Modificado

-   Layout actualizado para manejar auth()->check()
-   Eliminado layout.blade.php duplicado
-   Limpieza de dropdowns en header

### 🗑️ Eliminado

-   Menús de notificaciones y ayuda del header
-   Layout duplicado (layout.blade.php)

---

## Tipos de Cambios

-   `✨ Añadido` - Para nuevas características
-   `🔄 Modificado` - Para cambios en funcionalidad existente
-   `🗑️ Eliminado` - Para características eliminadas
-   `🐛 Corregido` - Para corrección de bugs
-   `🔒 Seguridad` - Para vulnerabilidades
-   `📚 Documentación` - Para cambios en documentación
-   `🚀 Rendimiento` - Para mejoras de rendimiento

---

## Enlaces

-   [Repositorio](https://github.com/Guillen-cloud/PromptVault-)
-   [Issues](https://github.com/Guillen-cloud/PromptVault-/issues)

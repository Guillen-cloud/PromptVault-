# 📝 Changelog - PromptVault

Todos los cambios notables en este proyecto serán documentados en este archivo.

El formato está basado en [Keep a Changelog](https://keepachangelog.com/es-ES/1.0.0/),
y este proyecto adhiere a [Semantic Versioning](https://semver.org/lang/es/).

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

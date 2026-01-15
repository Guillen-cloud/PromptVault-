# 🧪 Guía de Testing - PromptVault

Esta guía explica cómo ejecutar y entender los tests del proyecto.

---

## 📋 Tabla de Contenidos

-   [Requisitos](#requisitos)
-   [Configuración](#configuración)
-   [Ejecutar Tests](#ejecutar-tests)
-   [Tests Disponibles](#tests-disponibles)
-   [Escribir Nuevos Tests](#escribir-nuevos-tests)
-   [Cobertura de Tests](#cobertura-de-tests)
-   [Solución de Problemas](#solución-de-problemas)

---

## 🔧 Requisitos

-   PHP >= 8.2
-   Composer instalado
-   Base de datos de prueba configurada
-   Dependencias instaladas (`composer install`)

---

## ⚙️ Configuración

### 1. Base de Datos de Prueba

Crea un archivo `.env.testing` en la raíz del proyecto:

```env
APP_ENV=testing
APP_KEY=base64:tu_key_aqui
APP_DEBUG=true

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=promptvault_test
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

### 2. Crear Base de Datos de Tests

```bash
mysql -u root -p
CREATE DATABASE promptvault_test CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
exit;
```

### 3. Ejecutar Migraciones de Test

```bash
php artisan migrate --env=testing
```

---

## 🚀 Ejecutar Tests

### Todos los Tests

```bash
php artisan test
```

O con Pest:

```bash
./vendor/bin/pest
```

### Tests Específicos

```bash
# Solo tests de Prompts
php artisan test --filter=PromptTest

# Solo tests de Autenticación
php artisan test --filter=AuthTest

# Un test específico
php artisan test --filter=test_user_can_create_prompt
```

### Con Detalles

```bash
# Modo verbose
php artisan test --verbose

# Con cobertura
php artisan test --coverage
```

---

## 📝 Tests Disponibles

### 🔐 AuthTest (6 tests)

#### `test_login_with_valid_credentials()`

**Qué prueba:** Login con credenciales correctas  
**Espera:** Redirige a dashboard y usuario autenticado

```bash
php artisan test --filter=test_login_with_valid_credentials
```

#### `test_login_with_invalid_credentials()`

**Qué prueba:** Login con contraseña incorrecta  
**Espera:** Error de validación y usuario no autenticado

#### `test_user_registration()`

**Qué prueba:** Registro de nuevo usuario  
**Espera:** Usuario creado, autenticado y redirigido

#### `test_registration_fails_with_duplicate_email()`

**Qué prueba:** Registro con email existente  
**Espera:** Error de validación en campo email

#### `test_user_logout()`

**Qué prueba:** Cerrar sesión  
**Espera:** Redirige a login y usuario no autenticado

#### `test_authenticated_user_redirected_from_login()`

**Qué prueba:** Usuario logueado intenta acceder a /login  
**Espera:** Redirige a dashboard

---

### 📝 PromptTest (6 tests)

#### `test_user_can_create_prompt()`

**Qué prueba:** Creación de prompt  
**Espera:** Prompt guardado en BD con user_id correcto

```bash
php artisan test --filter=test_user_can_create_prompt
```

#### `test_user_can_view_own_prompts()`

**Qué prueba:** Visualización de prompts propios  
**Espera:** Lista muestra prompts del usuario

#### `test_user_cannot_edit_others_prompts()`

**Qué prueba:** Política de autorización  
**Espera:** Error 403 (Forbidden) al intentar editar prompt ajeno

#### `test_user_can_search_prompts()`

**Qué prueba:** Funcionalidad de búsqueda  
**Espera:** Solo muestra prompts que coinciden con búsqueda

#### `test_user_can_favorite_prompt()`

**Qué prueba:** Sistema de favoritos  
**Espera:** Campo `es_favorito` se actualiza correctamente

#### `test_authentication_required()`

**Qué prueba:** Protección de rutas  
**Espera:** Redirige a /login si no está autenticado

---

## ✍️ Escribir Nuevos Tests

### Estructura Básica

```php
<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MiNuevoTest extends TestCase
{
    use RefreshDatabase; // Resetea BD entre tests

    public function test_descripcion_de_la_prueba()
    {
        // 1. Arrange (Preparar)
        $user = User::factory()->create();

        // 2. Act (Actuar)
        $response = $this->actingAs($user)->get('/ruta');

        // 3. Assert (Afirmar)
        $response->assertStatus(200);
    }
}
```

### Assertions Comunes

```php
// Respuestas HTTP
$response->assertStatus(200);
$response->assertRedirect('/ruta');
$response->assertSee('Texto visible');
$response->assertDontSee('Texto oculto');

// Base de Datos
$this->assertDatabaseHas('tabla', ['campo' => 'valor']);
$this->assertDatabaseMissing('tabla', ['campo' => 'valor']);

// Autenticación
$this->assertAuthenticated();
$this->assertGuest();
$this->assertAuthenticatedAs($user);

// Sesión
$response->assertSessionHas('key');
$response->assertSessionHasErrors('field');
```

---

## 📊 Cobertura de Tests

### Generar Reporte de Cobertura

```bash
php artisan test --coverage --min=70
```

### Ver Cobertura HTML

```bash
php artisan test --coverage-html coverage_report
```

Abre `coverage_report/index.html` en tu navegador.

### Cobertura Actual

| Módulo        | Cobertura | Tests             |
| ------------- | --------- | ----------------- |
| Autenticación | 100%      | 6 tests           |
| Prompts       | 80%       | 6 tests           |
| Validación    | 100%      | Incluido en tests |
| Políticas     | 75%       | Incluido en tests |

---

## 🐛 Solución de Problemas

### Error: "Database doesn't exist"

```bash
# Crear BD de prueba
mysql -u root -p
CREATE DATABASE promptvault_test;
exit;

# Ejecutar migraciones
php artisan migrate --env=testing
```

### Error: "Class not found"

```bash
composer dump-autoload
```

### Tests lentos

```bash
# Usar base de datos en memoria (SQLite)
# En .env.testing:
DB_CONNECTION=sqlite
DB_DATABASE=:memory:
```

### Error de Seeders en Tests

```php
// En tu test, usa:
protected function setUp(): void
{
    parent::setUp();
    $this->seed(); // Ejecuta seeders necesarios
}
```

---

## 🎯 Buenas Prácticas

### ✅ DO (Hacer)

-   ✅ Usa `RefreshDatabase` para resetear BD
-   ✅ Nombra tests descriptivamente (`test_user_can_...`)
-   ✅ Un test, una afirmación principal
-   ✅ Usa factories para crear datos
-   ✅ Tests independientes (no dependen de otros)

### ❌ DON'T (No Hacer)

-   ❌ Tests que modifican BD real
-   ❌ Tests que dependen de orden de ejecución
-   ❌ Tests sin assertions
-   ❌ Datos hardcodeados (usar factories)
-   ❌ Tests de más de 50 líneas

---

## 📚 Recursos

-   [Testing Laravel](https://laravel.com/docs/11.x/testing)
-   [HTTP Tests](https://laravel.com/docs/11.x/http-tests)
-   [Database Testing](https://laravel.com/docs/11.x/database-testing)
-   [Pest PHP](https://pestphp.com/)

---

## 🚀 Integración Continua (CI)

### GitHub Actions

Crea `.github/workflows/tests.yml`:

```yaml
name: Tests

on: [push, pull_request]

jobs:
    test:
        runs-on: ubuntu-latest
        steps:
            - uses: actions/checkout@v2
            - name: Setup PHP
              uses: shivammathur/setup-php@v2
              with:
                  php-version: "8.2"
            - name: Install Dependencies
              run: composer install
            - name: Run Tests
              run: php artisan test
```

---

**¡Tests = Confianza = Código de Calidad!** 🎉

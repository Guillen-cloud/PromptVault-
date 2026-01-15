# 🚀 Guía de Colaboración - PromptVault

## 📌 Información del Proyecto

-   **Nombre:** PromptVault - Sistema de Gestión de Prompts
-   **Repositorio:** https://github.com/Guillen-cloud/PromptVault-
-   **Tecnologías:** Laravel 11, PHP, MySQL, Vite, CSS

---

## 👥 Para Nuevos Colaboradores

### 1️⃣ Primera vez - Clonar el proyecto

```bash
# Clonar el repositorio
git clone https://github.com/Guillen-cloud/PromptVault-.git

# Entrar al proyecto
cd PromptVault-

# Instalar dependencias de PHP
composer install

# Instalar dependencias de JavaScript
npm install

# Copiar el archivo de configuración
cp .env.example .env

# Generar la clave de aplicación
php artisan key:generate

# Configurar base de datos en .env
# Editar DB_DATABASE, DB_USERNAME, DB_PASSWORD

# Ejecutar migraciones y seeders
php artisan migrate --seed

# Compilar assets
npm run dev
```

---

## 🔄 Flujo de Trabajo Diario

### ✅ ANTES de empezar a trabajar

```bash
# 1. Asegúrate de estar en la rama main
git checkout main

# 2. Descarga los últimos cambios
git pull origin main

# 3. Inicia los servidores
php artisan serve
npm run dev
```

### 💻 MIENTRAS trabajas

```bash
# Crea una rama para tu funcionalidad (OPCIONAL pero recomendado)
git checkout -b feature/nombre-de-tu-funcionalidad

# Ejemplos:
# git checkout -b feature/sistema-etiquetas
# git checkout -b fix/correccion-dashboard
```

### 📤 DESPUÉS de terminar tu trabajo

```bash
# 1. Ver qué archivos modificaste
git status

# 2. Agregar los archivos modificados
git add .

# 3. Hacer commit con mensaje descriptivo
git commit -m "Descripción clara de lo que hiciste"

# Ejemplos de buenos mensajes:
# git commit -m "Agregado sistema de filtros en prompts"
# git commit -m "Corregido error en edición de categorías"
# git commit -m "Mejorado diseño del dashboard"

# 4. Subir tus cambios
git push origin main
# O si creaste una rama:
# git push origin feature/nombre-de-tu-funcionalidad
```

---

## ⚠️ REGLAS IMPORTANTES

### ✅ SIEMPRE HACER

1. **Hacer `git pull` ANTES de empezar a trabajar**
2. **Hacer commits frecuentes** (cada funcionalidad completa)
3. **Escribir mensajes de commit descriptivos**
4. **Probar tu código** antes de hacer push
5. **Comunicar en el grupo** qué estás trabajando

### ❌ NUNCA HACER

1. ❌ Hacer `git push -f` (force push) - Puede borrar trabajo de otros
2. ❌ Subir archivos `.env` o contraseñas
3. ❌ Subir la carpeta `vendor/` o `node_modules/`
4. ❌ Trabajar sin hacer `git pull` primero
5. ❌ Hacer cambios directos en archivos de migración ya ejecutados

---

## 🔧 Comandos Útiles

### Ver historial de cambios

```bash
git log --oneline
```

### Ver quién modificó un archivo

```bash
git blame nombre-archivo.php
```

### Descartar cambios locales (CUIDADO)

```bash
git checkout -- nombre-archivo.php
```

### Volver a un commit anterior

```bash
git log --oneline  # busca el ID del commit
git checkout [ID-commit] nombre-archivo.php
```

---

## 🆘 Solución de Problemas Comunes

### Conflicto al hacer pull

```bash
# Si git dice que hay conflictos:
# 1. Abre los archivos en conflicto
# 2. Busca las líneas con <<<<<<, ======, >>>>>>
# 3. Edita manualmente para resolver el conflicto
# 4. Guarda el archivo
# 5. Haz:
git add .
git commit -m "Resuelto conflicto en [nombre-archivo]"
git push origin main
```

### Olvidé hacer pull y ya tengo cambios locales

```bash
# Guarda tus cambios temporalmente
git stash

# Descarga los últimos cambios
git pull origin main

# Recupera tus cambios
git stash pop

# Si hay conflictos, resuélvelos como arriba
```

### Error: "Your branch is behind"

```bash
# Simplemente descarga los cambios
git pull origin main
```

---

## 📁 Estructura del Proyecto

```
ProyectoFinal_v1/
├── app/
│   ├── Http/Controllers/     # Controladores (lógica)
│   └── Models/               # Modelos (base de datos)
├── database/
│   ├── migrations/           # Estructura de BD
│   └── seeders/              # Datos de prueba
├── resources/
│   ├── css/                  # Estilos
│   ├── js/                   # JavaScript
│   └── views/                # Vistas Blade (HTML)
├── routes/
│   └── web.php               # Rutas de la aplicación
└── public/                   # Archivos públicos
```

---

## 🎯 División de Trabajo (Ejemplo)

### Persona 1: Backend - Prompts

-   Controlador de prompts
-   Validaciones
-   Filtros y búsqueda

### Persona 2: Backend - Categorías/Etiquetas

-   Sistema de categorización
-   Gestión de etiquetas
-   Relaciones

### Persona 3: Frontend - Diseño

-   Mejoras de UI/UX
-   Responsividad
-   Animaciones

### Persona 4: Base de Datos/Testing

-   Optimización de consultas
-   Seeders
-   Tests

---

## 📞 Contacto

**Ante cualquier duda:**

-   Pregunta en el grupo antes de hacer cambios grandes
-   Usa Issues en GitHub para reportar bugs
-   Documenta funcionalidades nuevas

---

## 📝 Checklist para Cada Sesión

-   [ ] `git pull origin main`
-   [ ] Trabajar en tu funcionalidad
-   [ ] Probar que funciona
-   [ ] `git add .`
-   [ ] `git commit -m "Mensaje descriptivo"`
-   [ ] `git push origin main`
-   [ ] Avisar al grupo qué completaste

---

**¡Éxito con el proyecto! 🎓**

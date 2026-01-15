@echo off
echo Creando base de datos promptvault...
"C:\xampp\mysql\bin\mysql.exe" -u root -e "CREATE DATABASE IF NOT EXISTS promptvault CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
if %errorlevel% equ 0 (
    echo Base de datos 'promptvault' creada exitosamente!
    echo.
    echo Ejecutando migraciones y seeders...
    php artisan migrate:fresh --seed
) else (
    echo Error: No se pudo conectar a MySQL.
    echo Asegurate de que MySQL este corriendo en XAMPP.
)
pause

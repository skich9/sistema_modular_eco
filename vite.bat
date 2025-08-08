@echo off
REM Script para ejecutar comandos de Vite dentro del contenedor Node.js en Windows

REM Verificar si el contenedor está en ejecución
docker ps | findstr laravel_node > nul
if %errorlevel% neq 0 (
    echo Iniciando el contenedor de Node.js...
    docker-compose up -d node
)

REM Ejecutar el comando especificado dentro del contenedor
if "%1"=="dev" (
    echo Iniciando servidor de desarrollo Vite...
    docker-compose exec node sh -c "cd /var/www/html && npm run dev -- --host"
) else if "%1"=="build" (
    echo Compilando assets con Vite...
    docker-compose exec node sh -c "cd /var/www/html && npm run build"
) else (
    echo Uso: vite.bat [dev^|build]
    echo   dev   - Inicia el servidor de desarrollo de Vite
    echo   build - Compila los assets para producción
)

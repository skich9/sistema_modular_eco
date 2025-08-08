#!/bin/bash

# Script para ejecutar comandos de Vite dentro del contenedor Node.js

# Verificar si el contenedor está en ejecución
if ! docker ps | grep -q laravel_node; then
    echo "Iniciando el contenedor de Node.js..."
    docker-compose up -d node
fi

# Ejecutar el comando especificado dentro del contenedor
if [ "$1" = "dev" ]; then
    echo "Iniciando servidor de desarrollo Vite..."
    docker-compose exec node sh -c "cd /var/www/html && npm run dev -- --host"
elif [ "$1" = "build" ]; then
    echo "Compilando assets con Vite..."
    docker-compose exec node sh -c "cd /var/www/html && npm run build"
else
    echo "Uso: ./vite.sh [dev|build]"
    echo "  dev   - Inicia el servidor de desarrollo de Vite"
    echo "  build - Compila los assets para producción"
fi

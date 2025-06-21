#!/bin/bash
set -e

echo "➡️ Instalando dependencias de Composer..."
composer install --no-dev --optimize-autoloader

echo "➡️ Instalando dependencias de NPM..."
npm install

echo "➡️ Compilando assets con Vite..."
npm run build

echo "➡️ Limpiando y cacheando configuración..."
php artisan config:clear
php artisan config:cache

chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

echo "➡️ Creando symlink de storage (si no existe)..."
php artisan storage:link || true

echo "✅ Todo listo. Iniciando servicios..."
# 2) Inicia PHP-FPM en segundo plano
php-fpm &

# 3) Inicia Nginx en primer plano para mantener el contenedor vivo
exec nginx -g "daemon off;"

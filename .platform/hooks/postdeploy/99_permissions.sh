#!/bin/bash
set -e

APP_DIR=/var/app/current
cd $APP_DIR

# Instalar vendor si no está incluido
if [ ! -d "$APP_DIR/vendor" ]; then
  /opt/php/bin/composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist
fi

# Ajustar permisos
chown -R webapp:webapp storage bootstrap/cache || true
chmod -R 775 storage bootstrap/cache || true

# Crear link de storage si no existe
php artisan storage:link || true

# Ejecutar migraciones con --force si quieres automatizar (opcional)
# php artisan migrate --force || true

# Re-cache
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

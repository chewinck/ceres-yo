FROM php:8.4-fpm

ARG UID=1000
ARG GID=1000

# Crear usuario con mismo UID/GID que en el host
RUN usermod -u ${UID} www-data && groupmod -g ${GID} www-data

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev \
    libzip-dev libpq-dev gnupg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Instalar Node.js 18
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && apt-get install -y nodejs

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copiar el código antes de cambiar de usuario
COPY . .

# Ejecutar dependencias como root (sin problemas de permisos)
RUN composer config --global --no-plugins allow-plugins.git-dependency true \
 && git config --global --add safe.directory /var/www/html \
 && composer install --no-dev --no-interaction --optimize-autoloader \
 && npm install \
 && npm run build

# Asegurar permisos y cambiar al usuario www-data
RUN chown -R www-data:www-data /var/www/html

USER www-data

CMD ["php-fpm"]

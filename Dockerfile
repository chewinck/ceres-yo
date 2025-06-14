FROM php:8.4-fpm

ARG UID=1000
ARG GID=1000

# Crear usuario www-data con UID/GID personalizados
RUN usermod -u $UID www-data && groupmod -g $GID www-data

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev \
    gnupg libzip-dev libpq-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Instalar Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && apt-get install -y nodejs

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copiar código fuente
COPY . .

# Instalar dependencias PHP como root
RUN composer install --no-dev --no-interaction --optimize-autoloader

# Instalar dependencias de Node.js como root (para evitar errores con cache/permiso)
RUN npm install && npm run build

# Ajustar permisos después de instalaciones
RUN chown -R www-data:www-data /var/www/html /var/www/.npm

# Cambiar a usuario no root
USER www-data

CMD ["php-fpm"]

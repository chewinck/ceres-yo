FROM php:8.4-fpm

ARG UID=1000
ARG GID=1000

RUN usermod -u $UID www-data && groupmod -g $GID www-data

# Dependencias del sistema
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev \
    gnupg libzip-dev libpq-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Instalar Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && apt-get install -y nodejs

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copiar todo el proyecto (incluyendo artisan)
COPY . .

# Asignar permisos
RUN chown -R www-data:www-data /var/www/html

USER www-data

# Ahora sí: instalar dependencias PHP y JS
RUN composer install --no-dev --no-interaction --optimize-autoloader \
    && npm install \
    && npm run build

CMD ["php-fpm"]

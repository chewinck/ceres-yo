# imagen de dockerhub que descargara
FROM php:8.4-fpm

# Set working directory
WORKDIR /var/www/html

# Ajusta UID y GID de www-data
RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copia el código fuente al contenedor
COPY . /var/www/html

# Crea las carpetas necesarias si no existen
RUN mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd


# Asigna el propietario 'www-data' a las carpetas que Laravel necesita escribir
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache


# Ejecuta el contenedor con php-fpm
CMD ["php-fpm"]
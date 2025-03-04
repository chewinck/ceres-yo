# imagen de dockerhub que descargara
FROM php:8.4-fpm

# Set working directory
WORKDIR /var/www/html

# Copia el código fuente al contenedor
COPY . /var/www/html

# Ajusta UID y GID de www-data
RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Crea las carpetas necesarias si no existen
RUN mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache

RUN mkdir -p /var/www/.npm && chown -R www-data:www-data /var/www/.npm /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Instala las dependencias necesarias y Node.js
RUN apt-get update && apt-get install -y curl gnupg && \
    curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs && \
    rm -rf /var/lib/apt/lists/*

# Ejecuta npm install y build
RUN npm install && npm run build

# Verifica la instalación
RUN php -v && node -v && npm -v

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*


# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Usa el usuario www-data antes de ejecutar npm
USER www-data

# Asigna el propietario 'www-data' a las carpetas que Laravel necesita escribir
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache


# Ejecuta el contenedor con php-fpm
CMD ["php-fpm"]
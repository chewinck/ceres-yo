# Imagen base
FROM php:8.4-fpm

# Establecer directorio de trabajo
WORKDIR /var/www/html

# Ajustar UID y GID de www-data para que coincida con tu host (usualmente UID 1000)
RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    gnupg \
    && curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

# Instalar extensiones PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar proyecto al contenedor
COPY . /var/www/html

# Asegurar que Git confíe en el directorio
RUN git config --global --add safe.directory /var/www/html

# Crear carpetas necesarias con permisos correctos
RUN mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache /var/www/.npm \
    && chown -R www-data:www-data /var/www/html /var/www/.npm

# Cambiar a usuario www-data
USER www-data

# Instalar dependencias de PHP (composer)
RUN composer install --no-interaction --no-dev --optimize-autoloader

# Instalar dependencias JS y compilar assets (si aplica)
RUN npm install && npm run build

# Establecer permisos finales
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Comando por defecto
CMD ["php-fpm"]

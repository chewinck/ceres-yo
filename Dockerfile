# Imagen base PHP
FROM php:8.4-fpm

# Set working directory
WORKDIR /var/www/html

# Copia el código fuente al contenedor
COPY . /var/www/html

# Ajusta UID y GID de www-data para que coincida con el host (opcional)
RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instala dependencias del sistema
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

# Instala extensiones PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Marca el directorio como "seguro" para Git
RUN git config --global --add safe.directory /var/www/html

# Crea las carpetas necesarias para Laravel
RUN mkdir -p /var/www/.npm /var/www/html/storage /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/.npm /var/www/html

# Usa el usuario www-data a partir de aquí
USER www-data

# (Opcional) Instalar dependencias de Node y compilar assets (si aplica)
RUN npm install && npm run build

# (Opcional) Instalar dependencias PHP (si quieres hacer esto en build-time)
# Si prefieres hacerlo al correr el contenedor, puedes quitar esta línea
RUN composer install --no-interaction --no-dev --optimize-autoloader || true

# Permisos finales
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Ejecuta el contenedor con PHP-FPM
CMD ["php-fpm"]

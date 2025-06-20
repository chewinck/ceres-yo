FROM php:8.4-fpm

ARG UID=1000
ARG GID=1000

# 1) Asegura que re‑asignas UID/GID sólo si son distintos
RUN set -eux; \
    CURRENT_UID=$(id -u www-data); \
    if [ "$UID" != "$CURRENT_UID" ]; then usermod -u "$UID" www-data; fi; \
    CURRENT_GID=$(getent group www-data | cut -d: -f3); \
    if [ "$GID" != "$CURRENT_GID" ]; then groupmod -g "$GID" www-data || true; usermod -g "$GID" www-data; fi; \
    \
    # 2) Instala Nginx, Git, PHP‑ext y las librerías para zip
    apt-get update && apt-get install -y \
      nginx \
      git \
      curl \
      zip \
      unzip \
      libpng-dev \
      libonig-dev \
      libxml2-dev \
      gnupg \
      libzip-dev \
      pkg-config && \
    docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip
    
# 3) Instala Node.js y Composer
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
 && apt-get install -y nodejs \
 && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# 4) Copia tu aplicación y construye assets
WORKDIR /var/www/html
COPY . .
RUN composer install --no-dev --optimize-autoloader \
 && npm install \
 && npm run build \
 && chown -R www-data:www-data /var/www/html

# 5) Configura Nginx y el entrypoint
COPY ./nginx/nginx.conf /etc/nginx/nginx.conf
COPY ./docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# 6) Arranca como www-data
USER www-data
ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
CMD ["php-fpm"]

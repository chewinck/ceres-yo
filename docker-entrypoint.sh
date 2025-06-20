#!/bin/bash
# Dentro del contenedor:
# 1) asegúrate de que el storage link existe
php artisan storage:link || true
# 2) arranca nginx y php-fpm
service nginx start
php-fpm

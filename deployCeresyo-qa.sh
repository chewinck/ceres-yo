#!/bin/bash

tag="qa"
compose_file="docker-compose-qa.yml"
image_name="1121872835/amy-ceresyo"

ENV_FILE="/home/adminqa/environments/ceresyo-env/.env"

if [ ! -f $ENV_FILE ]; then
    echo "❌ ERROR: No se encontró el archivo de entorno en $ENV_FILE"
    exit 1
fi

# Login a DockerHub (si no usas login persistente, pon esto manualmente)
echo 'DockerHub/2024*' | docker login -u '1121872835' --password-stdin

# Pull de imagen
echo "Haciendo pull de la imagen desde Docker Hub..."
docker pull $image_name:$tag

# Detener servicios existentes
echo "Deteniendo contenedores anteriores..."
docker compose -f $compose_file down

# Subir contenedores nuevos
echo "Levantando nuevos contenedores..."
docker compose --env-file $ENV_FILE -f $compose_file up -d

echo "✅ Despliegue terminado"

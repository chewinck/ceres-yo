base_name="amy-ceresyo"
container="ceresyo-app-container"
image="1121872835/${base_name}"
tag="qa"
folder_env="ceresyo-env"
compose_file="docker-compose-qa.yml"

# Autenticarse en Docker Hub
echo 'DockerHub/2024*' | docker login -u '1121872835' --password-stdin

# Hacer pull de las imágenes definidas en docker-compose
docker compose -f $compose_file pull

# Detener y eliminar contenedores si ya existen
echo "Deteniendo contenedores existentes (si los hay)..."
docker compose -f $compose_file down

# Reemplazar archivo .env si es necesario
# Esto asume que estás copiando un nuevo archivo .env antes del deploy
# cp ${HOME}/environments/${folder_env}/.env .env

ENV_FILE="/home/adminqa/environments/ceresyo-env/.env"

if [ ! -f $ENV_FILE ]; then
    echo "❌ ERROR: No se encontró el archivo de entorno en $ENV_FILE"
    exit 1
fi

# Levantar todo con docker-compose
echo "Levantando aplicación con docker-compose..."
docker compose --env-file $ENV_FILE -f $compose_file up -d


# (Opcional) Limpiar imágenes antiguas si deseas
oldImage=$(docker images $image | awk '{print $3}' | awk 'NR==2')
if [ "$oldImage" ]; then
    echo "Eliminando imagen antigua: $oldImage"
    docker rmi $oldImage || true
fi

echo "🚀 Deploy finalizado con éxito."
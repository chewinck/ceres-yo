
# Nombre de la imagen y tag proporcionado como argumento
image_name="amy-ceresyo"
tag=$1

# Etiquetas permitidas
allowed_tags=("qa" "latest" "stable" "test")

# Verificar si se proporcionó un tag válido
if [[ -z "$tag" ]]; then
    echo "Please provide a tag, one of: ${allowed_tags[@]}"
    exit 1
fi

# Comprobar si el tag es válido
found=false
for allowed_tag in "${allowed_tags[@]}"; do
    if [[ "$tag" == "$allowed_tag" ]]; then
        found=true
        break
    fi
done

if [[ "$found" == "false" ]]; then
    echo "Tag must be one of: ${allowed_tags[@]}"
    exit 1
fi

# Verificar si la imagen ya existe localmente y eliminarla
if [ "$(docker images -q $image_name:$tag)" ]; then
    echo "Imagen local existente encontrada, eliminándola..."
    docker rmi $image_name:$tag
fi

# Crear la imagen
echo "Creando la imagen $image_name:$tag..."
docker build --no-cache -t $image_name:$tag -f Dockerfile . --platform linux/x86_64

# Verificar si la imagen se creó correctamente
if [ $? -eq 0 ]; then
    echo "Imagen creada exitosamente"
else
    echo "Error al crear la imagen"
    exit 1
fi

# Mostrar imágenes locales para confirmar que la imagen fue creada
echo "Imágenes locales disponibles:"
docker images

# Etiquetar la imagen con el nombre de usuario de Docker Hub
docker tag $image_name:$tag 1121872835/$image_name:$tag

# Iniciar sesión en Docker Hub si no lo has hecho
echo "Iniciando sesión en Docker Hub..."
docker login

# Empujar la imagen a Docker Hub
echo "Empujando la imagen $image_name:$tag al repositorio 1121872835/$image_name..."
docker push 1121872835/$image_name:$tag

# Verificar si la imagen fue empujada correctamente
if [ $? -eq 0 ]; then
    echo "Imagen empujada exitosamente a Docker Hub"
else
    echo "Error al empujar la imagen a Docker Hub"
    exit 1
fi

# Eliminar la imagen local etiquetada
echo "Eliminando la imagen local $image_name:$tag..."
docker rmi 1121872835/$image_name:$tag
# test_pokemon
Challenge

## Requisitos

Asegúrate de tener instalado Docker y Docker Compose en tu máquina.

## Configuración
1. Clonar el repositorio <br>
   ```
   git clone https://github.com/tu-usuario/test_pokemon.git
   cd test_pokemon
   ```

3. Configuración de entorno: copia el archivo .env.example a .env. <br>
      ```cp .env.example .env ```

5. Construir y ejecutar el Contenedor: <br>
   ``` docker-compose up -d --build```

6. Instalar dependencias de Composer: <br>
   ``` docker-compose exec app composer install ```

## Acceso a la aplicación
La aplicación estará disponible en http://localhost:8080.

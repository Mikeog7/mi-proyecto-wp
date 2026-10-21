# Mi Proyecto WP: Tema de WordPress con Docker

Entorno de desarrollo contenerizado para un tema de WordPress propio, responsivo y replicable en cualquier equipo con un solo comando.

## Requisitos previos

- [Docker Desktop](https://www.docker.com/products/docker-desktop/) (o Docker Engine + plugin Compose en Linux)
- Docker Compose v2
- Git

Comprueba la instalacion:

```bash
docker --version
docker compose version
```

## Instalacion

```bash
git clone https://github.com/tu-usuario/mi-proyecto-wp.git
cd mi-proyecto-wp
cp .env.example .env
```

Edita `.env` y cambia los valores `cambia_esto` por contrasenas propias. Despues:

```bash
docker compose up -d --build
```

La primera vez tarda unos minutos porque descarga las imagenes.

## Acceso

- Sitio: http://localhost:8080
- Panel de administracion: http://localhost:8080/wp-admin

Al entrar por primera vez se mostrara el asistente de instalacion de WordPress. Una vez completado, ve a Apariencia => Temas y activa Mi Tema.

> Las entradas, paginas, menus y el usuario administrador se guardan en la base de datos (volumen de Docker) y "no" se incluyen en el repositorio. Cada instalacion nueva empieza vacia.

## Desarrollo

El tema esta en `themes/mi-tema/` y se monta en el contenedor mediante un *bind mount*:

```yaml
- ./themes/mi-tema:/var/www/html/wp-content/themes/mi-tema
```

Docker no copia los archivos, los comparte con tu equipo. Cualquier cambio que guardes se refleja al recargar el navegador, sin reconstruir ni reiniciar nada.

El modo debug esta activado (`WORDPRESS_DEBUG=1`), por lo que los errores de PHP se muestran en pantalla y en los logs.

## Estructura del proyecto

```
mi-proyecto-wp/
 docker-compose.yaml   # Servicios: WordPress y MySQL
 Dockerfile            # Imagen personalizada de WordPress
.env                  # Credenciales (NO se sube a git)
.env.example          # Plantilla de variables de entorno
.gitignore
README.md
themes/
    mi-tema/
    style.css     # Estilos y cabecera del tema
    index.php     # Plantilla principal
    header.php
    footer.php
    functions.php


## Variables de entorno

| Variable | Descripcion |
|---|---|
| `MYSQL_ROOT_PASSWORD` | Contrasena del usuario root de MySQL |
| `MYSQL_DATABASE` | Nombre de la base de datos |
| `MYSQL_USER` | Usuario de la base de datos para WordPress |
| `MYSQL_PASSWORD` | Contrasena de ese usuario |
| `WORDPRESS_DB_HOST` | Host de la BD (`db:3306`, nombre del servicio) |
| `WORDPRESS_DEBUG` | `1` activa el modo debug |
| `WP_PORT` | Puerto local donde se publica WordPress (por defecto 8080) |

## Comandos utiles

| Comando | Descripcion |
|---|---|
| `docker compose up -d` | Levanta los servicios en segundo plano |
| `docker compose up -d --build` | Reconstruye la imagen y levanta |
| `docker compose stop` | Detiene los contenedores sin borrarlos |
| `docker compose start` | Arranca contenedores detenidos |
| `docker compose down` | Detiene y elimina contenedores (conserva datos) |
| `docker compose down -v` | Elimina tambien los volumenes (reset total) |
| `docker compose ps` | Muestra el estado de los servicios |
| `docker compose logs -f wordpress` | Logs de WordPress en tiempo real |
| `docker build -t mi-wp .` | Construye la imagen desde el Dockerfile |
| `docker run -d -p 8080:80 mi-wp` | Ejecuta un contenedor suelto desde una imagen |
| `docker stop wp_app` | Detiene un contenedor concreto |
| `docker exec -it wp_app bash` | Abre una terminal dentro del contenedor |
| `docker exec -it wp_db mysql -u root -p` | Entra en la base de datos |

## Resetear el entorno

```bash
docker compose down -v
docker compose up -d --build
```

Esto borra la base de datos y los archivos de WordPress, y deja una instalacion limpia.

## El Dockerfile

| Instruccion | Funcion | 
|---|---|
| `FROM wordpress:latest` | Imagen base oficial (Apache + PHP + WordPress) |
| `RUN apt-get ...` | Instala herramientas de desarrollo (`less`, `vim`) |
| `RUN { echo ... } > custom.ini` | Ajusta limites de PHP (subidas y memoria) |
| `EXPOSE 80` | Documenta el puerto en el que escucha el contenedor |

## Teoria

### Que es Docker

Docker es una plataforma que empaqueta una aplicacion junto con todo lo que necesita para funcionar (codigo, librerias, configuracion) en una **imagen**. Al ejecutar una imagen se obtiene un **contenedor**: un proceso aislado que corre siempre igual, sin importar en que equipo este.

### Ventajas de los contenedores

- **Reproducibilidad**: el entorno es identico en todos los equipos.
- **Ligereza**: consumen pocos recursos y arrancan en segundos.
- **Aislamiento**: cada proyecto tiene sus propias dependencias sin conflictos.
- **Portabilidad**: funcionan igual en desarrollo, pruebas y produccion.
- **Facil de versionar**: el entorno se define en archivos de texto (`Dockerfile`, `docker-compose.yaml`).

### Contenedor vs. maquina virtual

| | Contenedor | Maquina virtual |
|---|---|---|
| Sistema operativo | Comparte el kernel del host | Incluye un SO completo |
| Tamano | Megabytes | Gigabytes |
| Arranque | Segundos | Minutos |
| Aislamiento | A nivel de proceso | A nivel de hardware virtualizado (mas fuerte) |
| Rendimiento | Casi nativo | Overhead por el hipervisor |

La maquina virtual virtualiza el **hardware**; el contenedor virtualiza el **sistema operativo**, compartiendo el kernel del equipo anfitrion.

## Solucion de problemas

| Problema | Solucion |
|---|---|
| Puerto 8080 ocupado | Cambia `WP_PORT` en `.env` |
| `Error establishing a database connection` | Espera unos segundos a que MySQL arranque o revisa las variables de `.env` |
| `variable is not set` | Comprueba que `.env` existe junto al `docker-compose.yaml` |
| Cambios en `.env` no se aplican | `docker compose down -v` y levantar de nuevo (MySQL solo lee las variables al crear el volumen) |
| El tema no aparece | Comprueba que `style.css` tiene la cabecera `Theme Name` |
| Los estilos no se actualizan | Recarga forzada (Ctrl+Shift+R) |
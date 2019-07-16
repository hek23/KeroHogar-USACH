# Página de administración

### Requisitos
- Base de datos MySQL 5.7 o patch versión similar.
- PHP >= 7.1.3
- Composer para el manejo de dependencias.

### Instalación
- [Crear una base de datos MySQL](https://www.digitalocean.com/community/tutorials/como-instalar-mysql-en-ubuntu-18-04-es)
- Crear el archivo donde se cambian las variables de entorno: 
```sh
cp .env.example .env 
```
- Generar una llave para la aplicación: 
```sh
php artisan key:generate 
```
- Cambiar la variable APP_NAME en el archivo .env
- Configurar la conexión a la base de datos MySQL en el archivo .env
- Generar y poblar las tablas de la base de datos: 
```sh
php artisan migrate --seed 
```
- Instalar las dependencias de laravel:
```sh
composer install 
```
- En caso de que hayan problemas, [revisar la documentación de laravel 5.8](https://laravel.com/docs/5.8/installation)

### Conexión a la base de datos
- DB_USERNAME : representa el nombre de usuario usado en la base de datos
- DB_DATABASE : representa el nombre de la base de datos creada
- DB_PASSWORD: Contraseña del usuario para su uso
- DB_HOST: Enlace para el acceso a la base de datos
- DB_PORT: Puerto para acceder a la base de datos

### Ejecución

Para hacer correr la página, luego de instaladas las dependencias, se debe ejecutar el siguiente comando:

```sh
php artisan serve
```

Ahora se puede acceder al sitio en el enlace http://localhost:8000

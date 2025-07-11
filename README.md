<div align="center">
    
# 🏊 Pool Control

![PHP Version](https://img.shields.io/badge/PHP-8.1%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PostgreSQL](https://img.shields.io/badge/PostgreSQL-316192?style=for-the-badge&logo=postgresql&logoColor=white)

Sistema de gestión integral para el control de albercas y membresías.

</div>

## 📋 Requisitos Previos

| Requisito | Versión |
|-----------|---------|
| PHP | 8.1 o superior |
| Composer | Última estable |
| PostgreSQL | 12 o superior |
| Node.js | 16.x o superior (Opcional) |
| NPM | 8.x o superior (Opcional) |

## 🚀 Instalación Rápida

Sigue estos pasos para configurar el proyecto en tu entorno local:

### 1. Clonar el Repositorio

```bash
git clone https://github.com/omancillav/pool-control.git
cd pool_control
```

### 2. Configuración del Entorno

1. Copia el archivo `.env.example` y renómbralo a `.env`:
   ```powershell
   Copy-Item .env.example .env
   ```

2. Crea una base de datos en PostgreSQL con el nombre `pool_control` para el proyecto.

3. Abre el archivo `.env` y configura tus variables de entorno. Asegúrate de que `DB_DATABASE` coincida con el nombre de la base de datos que creaste:
   ```env
   # Configuración de la base de datos PostgreSQL
   DB_CONNECTION=pgsql
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=pool_control
   DB_USERNAME=postgres
   DB_PASSWORD=tu_contraseña_de_postgres

   # Configuración de Google Authentication
   GOOGLE_CLIENT_ID=tu_client_id_google
   GOOGLE_CLIENT_SECRET=tu_client_secret_google

   # Configuración de Facebook Authentication
   FACEBOOK_CLIENT_ID=tu_client_id_facebook
   FACEBOOK_CLIENT_SECRET=tu_client_secret_facebook
   FACEBOOK_REDIRECT_URI=http://localhost:8000/auth/facebook/callback
   ```

### 3. Instalar Dependencias

1. Instala las dependencias de Composer:
   ```powershell
   composer install
   ```

2. Genera la clave de la aplicación:
   ```powershell
   php artisan key:generate
   ```

3. Instala AdminLTE (panel de administración):
   ```powershell
   php artisan adminlte:install
   ```
   > **Nota:** Si aparece el mensaje `AdminLTE asset files were already published. Want to replace? (yes/no) [no]:`, escribe **no** y presiona Enter para evitar que se sobrescriban los archivos.

### 4. Configuración de la Base de Datos

1. Ejecuta las migraciones y seeders (asegúrate de que el servicio de PostgreSQL esté en ejecución):
   ```powershell
   php artisan migrate:fresh --seed
   ```
   
   > ℹ️ Esto creará todas las tablas necesarias y cargará datos de prueba.

### 5. Iniciar la Aplicación

1. Inicia el servidor de desarrollo de Laravel:
   ```powershell
   php artisan serve
   ```
   
   > 💡 Si el puerto 8000 está en uso, puedes especificar otro puerto con: `php artisan serve --port=8080`

2. Abre tu navegador web favorito y visita:
   ```
   http://localhost:8000
   ```
   
   > 🔍 Si usaste un puerto diferente, asegúrate de usarlo en la URL (ej: `http://localhost:8080`)

## 🔑 Credenciales por Defecto

Se crea un usuario administrador con las siguientes credenciales:

- **Email:** admin@example.com
- **Contraseña:** password

> ⚠️ **Importante:** Cambia estas credenciales después del primer inicio de sesión.

## 🛠️ Comandos Útiles en Windows

| Comando | Descripción |
|---------|-------------|
| `php artisan serve` | Inicia el servidor de desarrollo |
| `php artisan migrate` | Ejecuta las migraciones pendientes |
| `php artisan db:seed` | Ejecuta los seeders |
| `php artisan optimize:clear` | Limpia la caché de la aplicación |
| `php artisan storage:link` | Crea el enlace simbólico para el almacenamiento |
| `php artisan queue:work` | Procesa trabajos en cola (si se usan) |

> 📝 **Nota para Windows:** Asegúrate de que PHP esté agregado al PATH del sistema o abre la terminal desde la carpeta donde está instalado PHP.

## 🖥️ Configuración Adicional para Windows

### Configurar el PATH de PHP
Para poder usar los comandos de PHP desde cualquier ubicación:

1. Busca "Variables de entorno" en el menú Inicio
2. Haz clic en "Variables de entorno"
3. En "Variables del sistema", selecciona "Path" y haz clic en "Editar"
4. Agrega la ruta a tu directorio PHP (ej: `C:\php`)

---

<div align="center">
    Hecho con ❤️ por el equipo de Pool Control
</div>

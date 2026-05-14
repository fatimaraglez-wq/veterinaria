# 🐾 Sistema de Gestión Veterinaria

Sistema web desarrollado en **Laravel 12** para la gestión de una clínica veterinaria, con autenticación, control de acceso basado en roles y paneles diferenciados por tipo de usuario.

---

## 🚀 Tecnologías utilizadas

| Tecnología | Versión |
|---|---|
| PHP | ^8.2 |
| Laravel | ^12.0 |
| Composer | 2.x |
| MySQL | 5.7+ / 8.x |
| Node.js | 18.x |
| SB Admin 2 (StartBootstrap) | Incluido en `public/startbootstrap/` |

---

## 📋 Requisitos previos

- PHP 8.2 o superior
- Composer 2.x
- MySQL 5.7+ o 8.x
- Node.js 18.x (para assets, si aplica)
- Servidor web (Apache / Nginx) o `php artisan serve`

---

## ⚙️ Instalación

### 1. Clonar el repositorio

```bash
git clone https://github.com/fatimaraglez-wq/veterinaria.git
cd veterinaria
```

### 2. Instalar dependencias PHP

```bash
composer install
```

### 3. Crear el archivo de entorno

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configurar la base de datos

Edita el archivo `.env` con los datos de tu servidor MySQL:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=veterinaria
DB_USERNAME=root
DB_PASSWORD=tu_contraseña
```

### 5. Ejecutar migraciones y seeders

```bash
php artisan migrate --seed
```

> Esto crea todas las tablas y los usuarios de prueba automáticamente.

### 6. Levantar el servidor

```bash
php artisan serve
```

Accede en: [http://localhost:8000](http://localhost:8000)

---

## 👥 Usuarios de prueba

| Rol | Email | Contraseña | Redirige a |
|---|---|---|---|
| Administrador | `admin@veterinaria.com` | `admin` | `/admin/home` |
| Veterinario | `vet@veterinaria.com` | `veterinario` | `/home` |

---

## 🔐 Sistema de autenticación y roles

El sistema implementa autenticación con Laravel Auth y despacho automático por rol tras el login:

- **Veterinario** → redirige al dashboard veterinario (`/home`)
- **Administrador** → redirige al panel de administración (`/admin/home`)

Las rutas están protegidas con el middleware personalizado `CheckRole`, que verifica el campo `rol` del usuario autenticado y redirige al dashboard correcto si intenta acceder a una sección que no le corresponde.

### Roles disponibles (ENUM en base de datos)

```
administrador | veterinario
```

---

## 🗺️ Rutas principales

| Método | URI | Nombre | Middleware | Descripción |
|---|---|---|---|---|
| GET | `/` | `login` | guest | Formulario de login |
| POST | `/logear` | `logear` | guest | Procesar credenciales |
| GET | `/home` | `home` | auth, role:veterinario | Dashboard veterinario |
| GET | `/admin/home` | `admin.home` | auth, role:administrador | Dashboard administrador |
| GET | `/logout` | `logout` | auth | Cerrar sesión |

---

## 🗂️ Estructura de vistas

```
resources/views/
├── layouts/
│   ├── app.blade.php          # Layout principal (veterinario)
│   ├── admin.blade.php        # Layout del panel de administración
│   └── auth.blade.php         # Layout para páginas de autenticación
├── partials/
│   ├── sidebar.blade.php      # Sidebar veterinario (azul)
│   ├── topbar.blade.php       # Topbar veterinario
│   ├── footer.blade.php       # Footer veterinario
│   └── admin/
│       ├── sidebar.blade.php  # Sidebar administrador (oscuro)
│       ├── topbar.blade.php   # Topbar administrador
│       └── footer.blade.php   # Footer administrador
└── modules/
    ├── auth/
    │   └── login.blade.php    # Página de inicio de sesión
    ├── dashboard/
    │   └── home.blade.php     # Dashboard del veterinario
    └── admin/
        └── home.blade.php     # Dashboard del administrador
```

---

## 🧩 Archivos clave del proyecto

| Archivo | Descripción |
|---|---|
| `app/Http/Controllers/AuthController.php` | Maneja login, logout y redirección por rol |
| `app/Http/Middleware/CheckRole.php` | Middleware de control de acceso por rol |
| `bootstrap/app.php` | Registro del alias `role` para el middleware |
| `routes/web.php` | Definición de rutas con sus middlewares |
| `database/migrations/0001_01_01_000000_create_users_table.php` | Migración de la tabla `users` con campo `rol` |
| `database/seeders/UserSeeder.php` | Seeders de usuarios de prueba |
| `public/startbootstrap/` | Plantilla SB Admin 2 (assets CSS, JS, imágenes) |

---

## 🎨 Plantilla de interfaz

Se utiliza **SB Admin 2** de StartBootstrap, incluida directamente en `public/startbootstrap/`. Los assets se referencian con rutas absolutas desde las vistas Blade:

```html
<link href="/startbootstrap/css/sb-admin-2.min.css" rel="stylesheet">
<script src="/startbootstrap/vendor/jquery/jquery.min.js"></script>
<script src="/startbootstrap/js/sb-admin-2.min.js"></script>
```

### Diferenciación visual por rol

| Panel | Color del sidebar | Ícono |
|---|---|---|
| Veterinario | Azul (`bg-gradient-primary`) | 🐾 `fa-paw` |
| Administrador | Oscuro (`bg-gradient-dark`) | 🛡️ `fa-shield-alt` |

---

## 🗃️ Base de datos

### Tabla `users`

| Campo | Tipo | Descripción |
|---|---|---|
| `id` | bigint | Clave primaria |
| `name` | varchar | Nombre del usuario |
| `email` | varchar (único) | Correo electrónico |
| `email_verified_at` | timestamp | Verificación de email |
| `password` | varchar | Contraseña hasheada (bcrypt) |
| `rol` | enum | Rol del usuario: `administrador` o `veterinario` |
| `remember_token` | varchar | Token de sesión persistente |
| `created_at` / `updated_at` | timestamp | Marcas de tiempo |

---

## 📜 Licencia

Este proyecto es de uso académico/institucional — ITMA.

# Inventario de Equipos

Aplicación web (CRUD) construida con Laravel 12 para registrar, listar, editar y eliminar equipos (por ejemplo, de un laboratorio o sala de cómputo).

## Ficha técnica

| Componente | Versión exacta |
|---|---|
| Sistema operativo | Windows 11 Pro, versión 23H2 (build 22631.6199) |
| Lenguaje | PHP 8.2.12 |
| Framework | Laravel 12.62.0 |
| Base de datos | PostgreSQL 17.10 |
| ORM | Eloquent (incluido en Laravel) + migraciones |
| Gestor de dependencias | Composer (composer.json) |
| Framework de pruebas | PHPUnit (incluido en Laravel) |

## Requisitos previos

- PHP 8.2 o superior
- Composer
- PostgreSQL 17.x
- Git

## Instalación

Clonar el repositorio:

```bash
git clone https://github.com/AndreaCaisa/inventario-equipos.git
cd inventario-equipos
```

Instalar dependencias de PHP:

```bash
composer install
```

Configurar variables de entorno:

```bash
cp .env.example .env
php artisan key:generate
```

Variables requeridas en `.env`:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=inventario_equipos
DB_USERNAME=postgres
DB_PASSWORD=tu_password
```

Crear la base de datos en PostgreSQL:

```sql
CREATE DATABASE inventario_equipos;
```

Ejecutar las migraciones:

```bash
php artisan migrate
```

Levantar el servidor:

```bash
php artisan serve
```

Abrir en el navegador: `http://127.0.0.1:8000/equipos`

## Pruebas automatizadas

```bash
php artisan test
```

## Estructura del proyecto

```
inventario-equipos/
├── app/
│   ├── Models/
│   │   └── Equipo.php              Modelo Eloquent: nombre, tipo, marca, estado, ubicacion, urgente
│   └── Http/Controllers/
│       └── EquipoController.php    CRUD completo + marcar urgente
├── database/
│   ├── migrations/                 Definicion y versionado de las tablas
│   └── factories/
│       └── EquipoFactory.php       Generador de datos de prueba
├── resources/views/
│   ├── layouts/
│   │   └── app.blade.php           Plantilla base (navbar, alertas, Bootstrap)
│   └── equipos/
│       ├── index.blade.php         Listado de equipos
│       ├── create.blade.php        Formulario de registro
│       └── edit.blade.php          Formulario de edicion
├── routes/
│   └── web.php                     Rutas del recurso equipos
├── tests/Feature/
│   └── EquipoTest.php              Pruebas automatizadas
├── .github/workflows/
│   └── tests.yml                   CI: corre las pruebas en cada Pull Request
├── .env.example                    Plantilla de variables de entorno
├── composer.json                   Dependencias de PHP
└── artisan                         CLI de Laravel
```

## Flujo de trabajo con Git

Este repositorio usa la rama `main` protegida: ningún cambio se sube directo, todo pasa por Pull Request y debe pasar el workflow de pruebas automaticas antes de poder fusionarse.

```
main                              rama protegida, solo se actualiza por Pull Request
  feature/nombre-funcionalidad    para agregar algo nuevo
  fix/nombre-correccion           para corregir un error
  chore/nombre-tarea              tareas de mantenimiento (dependencias, CI, etc.)
```

Convencion de nombres de commits:

```
feat:     nueva funcionalidad
fix:      correccion de error
chore:    mantenimiento, dependencias, configuracion
docs:     documentacion
refactor: reorganizar codigo sin cambiar su comportamiento
test:     pruebas
```

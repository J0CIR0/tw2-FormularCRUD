# CRUD de Usuarios en PHP + MySQL

<p align="center">
  <img alt="PHP" src="https://img.shields.io/badge/PHP-8%2B-777BB4?style=for-the-badge&logo=php&logoColor=white">
  <img alt="MySQL" src="https://img.shields.io/badge/MySQL-8%2B-4479A1?style=for-the-badge&logo=mysql&logoColor=white">
  <img alt="Bootstrap" src="https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white">
  <img alt="Estado" src="https://img.shields.io/badge/Estado-Funcional-1f8b4c?style=for-the-badge">
</p>

Aplicacion web CRUD (Crear, Leer, Actualizar, Eliminar) para gestion de usuarios, desarrollada con **PHP (sin framework)**, **PDO** y **MySQL**.

Incluye una interfaz moderna con Bootstrap, validaciones basicas y separacion por capas (configuracion, modelo y vistas).

---

## Tabla de contenido

- [1. Caracteristicas](#1-caracteristicas)
- [2. Estructura del proyecto](#2-estructura-del-proyecto)
- [3. Requisitos](#3-requisitos)
- [4. Instalacion y puesta en marcha](#4-instalacion-y-puesta-en-marcha)
- [5. Configuracion de base de datos](#5-configuracion-de-base-de-datos)
- [6. Flujo de la aplicacion](#6-flujo-de-la-aplicacion)
- [7. Validaciones implementadas](#7-validaciones-implementadas)
- [8. Seguridad y buenas practicas](#8-seguridad-y-buenas-practicas)
- [9. Posibles mejoras](#9-posibles-mejoras)
- [10. Autor y licencia](#10-autor-y-licencia)

---

## 1. Caracteristicas

- Listado de usuarios con tabla responsive.
- Creacion de usuario nuevo.
- Edicion de usuario existente.
- Eliminacion con pantalla de confirmacion.
- Validacion de campos obligatorios.
- Validacion de formato de correo.
- Verificacion de correo unico.
- Uso de consultas preparadas con PDO.
- Interfaz visual limpia con Bootstrap 5.

---

## 2. Estructura del proyecto

```text
usuariosCRUD/
├── index.php
├── config/
│   └── database.php
├── models/
│   └── Usuario.php
└── views/
    ├── delete.php
    ├── footer.php
    ├── form.php
    ├── header.php
    └── index.php
```

Descripcion rapida:

- `index.php`: enrutador simple por parametro `action`.
- `config/database.php`: conexion PDO a MySQL.
- `models/Usuario.php`: logica de acceso a datos (CRUD + validacion de correo).
- `views/`: capas de interfaz (listado, formulario, eliminar, layout).

---

## 3. Requisitos

- PHP 8.0 o superior.
- Extension PDO habilitada.
- MySQL 5.7+ (recomendado MySQL 8+).
- Servidor local (Apache/Nginx o `php -S`).
- Navegador moderno.

---

## 4. Instalacion y puesta en marcha

1. Clona o descarga este repositorio.
2. Copia el proyecto dentro de tu servidor web local.
3. Crea la base de datos y tabla `usuarios`.
4. Ajusta las credenciales en `config/database.php`.
5. Inicia el servidor PHP o Apache/Nginx.
6. Abre la aplicacion en el navegador.

Ejemplo con servidor embebido de PHP:

```bash
cd usuariosCRUD
php -S localhost:8000
```

Luego abre:

```text
http://localhost:8000
```

---

## 5. Configuracion de base de datos

La app espera una tabla `usuarios` con campos compatibles con el modelo.

Script sugerido:

```sql
CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  apellido VARCHAR(100) NOT NULL,
  correo VARCHAR(150) NOT NULL UNIQUE,
  celular VARCHAR(30) NULL,
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

Conexion actual (archivo `config/database.php`):

- Host: `172.25.0.208`
- Puerto: `3306`
- Base de datos: `db01`
- Usuario: `root`
- Charset: `utf8mb4`

> Recomendacion: mover las credenciales a variables de entorno para no exponer datos sensibles en el repositorio.

---

## 6. Flujo de la aplicacion

`index.php` toma la accion desde `$_GET['action']` y carga la vista correspondiente:

- `index` (por defecto): listado.
- `create`: formulario de alta.
- `edit`: formulario de edicion.
- `delete`: confirmacion de eliminacion.

El modelo `Usuario` centraliza todas las operaciones SQL:

- `getAll()`
- `getById(int $id)`
- `create(...)`
- `update(...)`
- `delete(int $id)`
- `emailExists(...)`

---

## 7. Validaciones implementadas

En `views/form.php`:

- Campos obligatorios: nombre, apellido y correo.
- Correo con formato valido (`filter_var`).
- Correo no duplicado:
  - En creacion: evita registrar un email ya existente.
  - En edicion: permite el email actual del usuario y bloquea duplicados de otros usuarios.

En `views/delete.php`:

- Verifica que exista `id` valido.
- Verifica que el usuario exista antes de eliminar.

---

## 8. Seguridad y buenas practicas

Puntos ya aplicados:

- Consultas preparadas (mitiga SQL injection).
- Escape de salida HTML con `htmlspecialchars`.
- Manejo de excepciones PDO en conexion.

Puntos recomendados para produccion:

- Usar variables de entorno para secretos.
- Agregar token CSRF en formularios.
- Implementar autenticacion y control de acceso.
- Registrar logs de errores sin exponer detalle sensible al usuario.
- Validar politicas mas estrictas para campos (longitud, regex, etc.).

---

## 9. Posibles mejoras

- Paginacion y buscador por nombre/correo.
- Ordenamiento por columnas.
- API REST para integracion externa.
- Docker para entorno reproducible.
- Tests automatizados (PHPUnit).
- Separar controlador de vistas (MVC mas estricto).

---

## 10. Autor y licencia

Puedes reemplazar esta seccion con tus datos:

- Autor: Tu nombre
- Licencia: MIT (recomendado para proyectos de ejemplo)

Ejemplo de licencia en repositorio:

```text
MIT License
```

---

## Vista rapida del proyecto

Aplicacion simple, clara y util para aprendizaje o base de un sistema mas grande.
Si quieres profesionalizarlo para un entorno real, el siguiente paso clave es **externalizar configuracion sensible** y **agregar capa de autenticacion**.

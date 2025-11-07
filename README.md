# 🦷 Dentista Muelitas - Sistema de Gestión Dental

Sistema completo de gestión para consultorio dental desarrollado con Laravel 11 y Vite.

## 📋 Descripción

Sistema de gestión integral para el consultorio "Dentista Muelitas" que permite:

-   ✅ Gestión de usuarios y roles (Gerente/Odontólogo, Asistentes, Recepcionista, Enfermera)
-   ✅ Registro y administración de pacientes
-   ✅ Agenda de citas con recordatorios
-   ✅ Expedientes médicos digitales centralizados
-   ✅ Control de inventario de materiales dentales
-   ✅ Emisión de facturas y control de pagos
-   ✅ Generación de reportes

## 🛠️ Tecnologías

-   **Backend:** Laravel 11 (PHP 8.2+)
-   **Frontend:** Vite + Blade
-   **Base de Datos:** MySQL/MariaDB
-   **Gestión de dependencias:** Composer + npm

## 📦 Requisitos Previos e Instalación de Herramientas

### 🖥️ Software Necesario

#### 1. **XAMPP** (Incluye PHP, MySQL/MariaDB y Apache)

📍 **Qué es:** Paquete que incluye todo lo necesario para desarrollo web  
📍 **Dónde descargar:** [https://www.apachefriends.org/download.html](https://www.apachefriends.org/download.html)  
📍 **Versión recomendada:** XAMPP 8.2.x (incluye PHP 8.2)

**Instalación:**

1. Descargar XAMPP para Windows
2. Ejecutar instalador (instalar en `C:\xampp` o `D:\Aplicaciones\xampp`)
3. Durante instalación, seleccionar: Apache, MySQL, PHP, phpMyAdmin
4. Iniciar XAMPP Control Panel
5. Hacer click en "Start" para Apache y MySQL

**Verificar instalación:**

```powershell
# Verificar PHP
php -v
# Debería mostrar: PHP 8.2.x

# Abrir phpMyAdmin en navegador
# http://localhost/phpmyadmin
```

---

#### 2. **Composer** (Gestor de dependencias PHP)

📍 **Qué es:** Herramienta para instalar paquetes/librerías de PHP (como Laravel)  
📍 **Dónde descargar:** [https://getcomposer.org/download/](https://getcomposer.org/download/)  
📍 **Versión:** Latest (última versión estable)

**Instalación:**

1. Descargar `Composer-Setup.exe`
2. Ejecutar instalador
3. Cuando pregunte por PHP, seleccionar: `D:\Aplicaciones\xampp\php\php.exe` (o donde instalaste XAMPP)
4. Completar instalación

**Verificar instalación:**

```powershell
composer --version
# Debería mostrar: Composer version 2.x.x
```

---

#### 3. **Node.js** (Incluye npm - para compilar assets)

📍 **Qué es:** Entorno JavaScript para ejecutar Vite (compilador de CSS/JS)  
📍 **Dónde descargar:** [https://nodejs.org/](https://nodejs.org/)  
📍 **Versión recomendada:** LTS (Long Term Support) - actualmente v20.x o v22.x

**Instalación:**

1. Descargar instalador Windows (.msi)
2. Ejecutar instalador (instalar con opciones por defecto)
3. Reiniciar PowerShell/Terminal

**Verificar instalación:**

```powershell
node --version
# Debería mostrar: v20.x.x o superior

npm --version
# Debería mostrar: 10.x.x o superior
```

---

#### 4. **Git** (Control de versiones)

📍 **Qué es:** Sistema para clonar repositorios y trabajar en equipo  
📍 **Dónde descargar:** [https://git-scm.com/downloads](https://git-scm.com/downloads)  
📍 **Versión:** Latest

**Instalación:**

1. Descargar Git para Windows
2. Ejecutar instalador
3. Opciones recomendadas durante instalación:
    - Editor: Visual Studio Code (o tu preferido)
    - Use Git from Windows Command Prompt
    - Use OpenSSL library
    - Checkout Windows-style, commit Unix-style line endings

**Verificar instalación:**

```powershell
git --version
# Debería mostrar: git version 2.x.x
```

---

#### 5. **Editor de Código** (Opcional pero recomendado)

📍 **Visual Studio Code:**  
🔗 [https://code.visualstudio.com/](https://code.visualstudio.com/)

**Extensiones recomendadas para VS Code:**

-   Laravel Extension Pack
-   PHP Intelephense
-   Blade Formatter
-   GitLens

---

### ✅ Checklist de Verificación

Antes de clonar el proyecto, verifica que todo esté instalado:

```powershell
# Ejecuta estos comandos en PowerShell para verificar:
php -v          # PHP 8.2 o superior
composer --version  # Composer 2.x
node --version      # Node.js 18.x o superior
npm --version       # npm 9.x o superior
git --version       # Git 2.x o superior
```

**Verificar servicios XAMPP:**

-   Abrir XAMPP Control Panel
-   Verificar que Apache esté en verde (Running)
-   Verificar que MySQL esté en verde (Running)
-   Abrir navegador: http://localhost (debería mostrar página de XAMPP)
-   Abrir navegador: http://localhost/phpmyadmin (debería abrir phpMyAdmin)

---

### 🔧 Configuración Inicial de PowerShell (Windows)

Si tienes problemas ejecutando `npm` en PowerShell:

```powershell
# Ejecutar PowerShell como Administrador y ejecutar:
Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Scope CurrentUser -Force
```

---

### 🌐 Puertos Utilizados

Asegúrate de que estos puertos estén libres:

| Servicio       | Puerto | URL                         |
| -------------- | ------ | --------------------------- |
| Apache (XAMPP) | 80     | http://localhost            |
| MySQL          | 3306   | localhost:3306              |
| Laravel Serve  | 8000   | http://127.0.0.1:8000       |
| Vite (dev)     | 5173   | http://localhost:5173       |
| phpMyAdmin     | 80     | http://localhost/phpmyadmin |

---

## 📋 Resumen Rápido (Lo que necesitas instalado)

## ⚡ Inicio Rápido (Resumen Visual)

```
┌─────────────────────────────────────────────────────────────────┐
│  PASO  │  DÓNDE                    │  QUÉ HACER                 │
├────────┼───────────────────────────┼────────────────────────────┤
│   1    │  Terminal/Git Bash        │  git clone + cd proyecto   │
│   2    │  Terminal (proyecto)      │  composer install          │
│   3    │  Terminal (proyecto)      │  npm install               │
│   4    │  Terminal (proyecto)      │  Copy-Item .env.example    │
│   5    │  Terminal (proyecto)      │  php artisan key:generate  │
│   6    │  Editor de texto          │  Editar .env (MySQL)       │
│   7    │  phpMyAdmin o PowerShell  │  Crear BD dentista_muelitas│
│   8    │  Terminal (proyecto)      │  php artisan migrate:seed  │
│   9    │  Terminal (proyecto)      │  php artisan storage:link  │
│  10    │  Terminal 1 (proyecto)    │  npm run dev (mantener)    │
│  11    │  Terminal 2 (proyecto)    │  php artisan serve (mant.) │
│  12    │  Navegador                │  http://127.0.0.1:8000     │
└────────┴───────────────────────────┴────────────────────────────┘
```

## 🚀 Instalación para Desarrollo (Nuevos Miembros del Equipo)

### 1. Clonar el repositorio

📍 **Dónde:** Git Bash, PowerShell o Terminal

```bash
git clone <url-del-repositorio>
cd dentista-muelitas
```

### 2. Instalar dependencias PHP

📍 **Dónde:** PowerShell o Terminal (dentro del proyecto)

```bash
composer install
```

> ⚠️ **Nota Windows:** Si da error con `npm`, usar `npm.cmd` o ejecutar: `Set-ExecutionPolicy RemoteSigned -Scope CurrentUser`

### 3. Instalar dependencias JavaScript

📍 **Dónde:** PowerShell o Terminal (dentro del proyecto)

```bash
npm install
```

### 4. Configurar archivo de entorno

📍 **Dónde:** PowerShell o Terminal (dentro del proyecto)

Copia el archivo `.env.example` a `.env`:

**En PowerShell (Windows):**

```powershell
Copy-Item .env.example .env
```

**En Linux/Mac:**

```bash
cp .env.example .env
```

### 5. Generar clave de aplicación

📍 **Dónde:** PowerShell o Terminal (dentro del proyecto)

```bash
php artisan key:generate
```

### 6. Configurar la base de datos

📍 **Dónde:** Editor de texto (VS Code, Notepad++, etc.)

Edita el archivo `.env` y **asegúrate de descomentar** y configurar las credenciales de MySQL:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dentista_muelitas
DB_USERNAME=root
DB_PASSWORD=
```

> ⚠️ **IMPORTANTE:** Verifica que estas líneas NO tengan `#` al inicio. Si están comentadas (con `#`), quita el `#` para activarlas.

### 7. Crear la base de datos

📍 **Dónde:** phpMyAdmin (navegador) o PowerShell

**Opción A - Desde phpMyAdmin (Navegador web):**

1. Abre http://localhost/phpmyadmin
2. Click en "Nueva"
3. Nombre: `dentista_muelitas`
4. Cotejamiento: `utf8mb4_unicode_ci`
5. Click "Crear"

**Opción B - Desde PowerShell (Línea de comandos):**

```powershell
& 'D:\Aplicaciones\xampp\mysql\bin\mysql.exe' -u root -e "CREATE DATABASE IF NOT EXISTS dentista_muelitas CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

_(Ajusta la ruta `D:\Aplicaciones\xampp\` según tu instalación de XAMPP)_

### 8. Ejecutar migraciones y seeders

📍 **Dónde:** PowerShell o Terminal (dentro del proyecto)

Este comando creará todas las tablas y las llenará con datos de prueba:

```bash
php artisan migrate --seed
```

✨ **Esto creará automáticamente:**

-   5 usuarios con diferentes roles
-   10 pacientes de ejemplo
-   15 tratamientos odontológicos
-   15 materiales de inventario
-   7 citas agendadas
-   3 expedientes médicos
-   4 facturas (pagadas, pendientes y parciales)
-   9 movimientos de inventario

### 9. Crear enlace simbólico de storage

📍 **Dónde:** PowerShell o Terminal (dentro del proyecto)

```bash
php artisan storage:link
```

### 10. Compilar assets (desarrollo)

📍 **Dónde:** PowerShell o Terminal (dentro del proyecto)

```bash
npm run dev
```

> 💡 **Tip:** Este comando se queda ejecutándose. Déjalo abierto mientras desarrollas para que compile automáticamente los cambios.

### 11. Levantar servidor de desarrollo

📍 **Dónde:** Nueva ventana de PowerShell o Terminal (dentro del proyecto)

En una **nueva terminal** (deja la anterior con `npm run dev` abierta), ejecuta:

```bash
php artisan serve
```

> 💡 **Tip:** Este comando también se queda ejecutándose. Déjalo abierto mientras trabajas en el proyecto.

### 12. Abrir en el navegador

📍 **Dónde:** Navegador web (Chrome, Firefox, Edge, etc.)

Abre: **http://127.0.0.1:8000**

---

## ✅ Verificación de Instalación Exitosa

### Checklist Final

Después de completar todos los pasos, verifica:

-   [ ] **XAMPP:** Apache y MySQL en verde (Running) en Control Panel
-   [ ] **phpMyAdmin:** http://localhost/phpmyadmin abre correctamente
-   [ ] **Base de datos:** `dentista_muelitas` existe con 8 tablas pobladas
-   [ ] **Terminal 1:** `npm run dev` ejecutándose sin errores (mostrando "ready in Xms")
-   [ ] **Terminal 2:** `php artisan serve` ejecutándose (mostrando "Server running on [http://127.0.0.1:8000]")
-   [ ] **Navegador:** http://127.0.0.1:8000 muestra la página de Laravel

### Verificar datos en la base de datos

📍 **Opción 1 - phpMyAdmin (navegador):**

1. Abrir http://localhost/phpmyadmin
2. Click en base de datos `dentista_muelitas`
3. Verificar que existan 11 tablas (3 de Laravel + 8 del proyecto)
4. Click en tabla `usuarios` → Ver datos (deberías ver 5 usuarios)

📍 **Opción 2 - PowerShell:**

```powershell
# Desde el directorio del proyecto
cd 'D:\Aplicaciones\xampp'
.\mysql\bin\mysql.exe -u root dentista_muelitas -e "SELECT COUNT(*) as total_usuarios FROM usuarios;"
# Debería mostrar: 5

# Ver todas las tablas con sus conteos
.\mysql\bin\mysql.exe -u root dentista_muelitas -e "SELECT 'usuarios' as tabla, COUNT(*) as registros FROM usuarios UNION ALL SELECT 'pacientes', COUNT(*) FROM pacientes UNION ALL SELECT 'citas', COUNT(*) FROM citas UNION ALL SELECT 'tratamientos', COUNT(*) FROM tratamientos;"
```

### Conteo esperado de registros:

| Tabla                  | Registros |
| ---------------------- | --------- |
| usuarios               | 5         |
| pacientes              | 10        |
| citas                  | 7         |
| tratamientos           | 15        |
| expedientes            | 3         |
| materiales             | 15        |
| movimientos_inventario | 9         |
| facturas               | 4         |

---

## 🌐 URLs del Proyecto

Una vez todo esté funcionando, estas son las URLs disponibles:

| Servicio                    | URL                                |
| --------------------------- | ---------------------------------- |
| 🏠 Aplicación Laravel       | http://127.0.0.1:8000              |
| 🗄️ phpMyAdmin               | http://localhost/phpmyadmin        |
| 📊 XAMPP Dashboard          | http://localhost                   |
| 🔥 Vite Dev Server (assets) | http://localhost:5173 (automático) |

---

## 👥 Usuarios de Prueba

Después de ejecutar `php artisan migrate --seed`, tendrás estos usuarios disponibles:

| Email                   | Password    | Rol                |
| ----------------------- | ----------- | ------------------ |
| dr.limachi@muelitas.com | password123 | Gerente/Odontólogo |
| asistente1@muelitas.com | password123 | Asistente Directo  |
| asistente2@muelitas.com | password123 | Asistente Directo  |
| recepcion@muelitas.com  | password123 | Recepcionista      |
| enfermera@muelitas.com  | password123 | Enfermera          |

## 📊 Estructura de la Base de Datos

El sistema cuenta con 8 tablas principales:

1. **usuarios** - Personal de la clínica con roles
2. **pacientes** - Registro de pacientes
3. **citas** - Agenda de citas con recordatorios
4. **tratamientos** - Catálogo de servicios
5. **expedientes** - Historiales clínicos
6. **materiales** - Inventario de materiales dentales
7. **movimientos_inventario** - Control de entradas/salidas
8. **facturas** - Facturas y pagos

## 🔧 Comandos Útiles

### Desarrollo

📍 **Dónde ejecutar:** PowerShell o Terminal (dentro del proyecto)

```bash
# Compilar assets en modo desarrollo (hot reload)
npm run dev

# Compilar assets para producción
npm run build

# Ejecutar servidor Laravel
php artisan serve

# Limpiar caché de configuración
php artisan config:clear

# Limpiar todas las cachés
php artisan optimize:clear
```

### Base de Datos

📍 **Dónde ejecutar:** PowerShell o Terminal (dentro del proyecto)

```bash
# Ver estado de migraciones
php artisan migrate:status

# Revertir última migración
php artisan migrate:rollback

# Reiniciar BD y volver a seedear (⚠️ ELIMINA TODOS LOS DATOS)
php artisan migrate:fresh --seed

# Ejecutar solo seeders
php artisan db:seed
```

### Testing

📍 **Dónde ejecutar:** PowerShell o Terminal (dentro del proyecto)

```bash
# Ejecutar todos los tests
php artisan test

# Tests con coverage
php artisan test --coverage
```

## 📁 Estructura del Proyecto

```
dentista-muelitas/
├── app/
│   ├── Http/Controllers/  # Controladores
│   ├── Models/            # Modelos Eloquent
│   └── Providers/         # Service Providers
├── database/
│   ├── migrations/        # Migraciones de BD
│   └── seeders/           # Seeders con datos iniciales
├── public/                # Assets públicos
├── resources/
│   ├── css/              # Estilos
│   ├── js/               # JavaScript
│   └── views/            # Vistas Blade
├── routes/
│   └── web.php           # Rutas web
├── storage/              # Archivos almacenados
└── .env                  # Configuración de entorno
```

## ⚙️ Configuración Avanzada (Opcional)

### 🔐 Cambiar Puerto de Laravel

Si el puerto 8000 está ocupado:

```bash
# Usar otro puerto (ejemplo: 8080)
php artisan serve --port=8080
```

### 📁 Cambiar ubicación de XAMPP

Si instalaste XAMPP en otra ubicación diferente a `D:\Aplicaciones\xampp`:

**En el paso 7 de instalación, ajusta la ruta:**

```powershell
# Ejemplo si XAMPP está en C:\xampp
& 'C:\xampp\mysql\bin\mysql.exe' -u root -e "CREATE DATABASE..."
```

**Para verificar datos:**

```powershell
# Ajustar ruta según tu instalación
cd 'C:\xampp'
.\mysql\bin\mysql.exe -u root dentista_muelitas -e "SELECT * FROM usuarios;"
```

### 🌍 Cambiar idioma de Laravel

El proyecto ya está configurado para español. Si necesitas ajustar:

**Editar `.env`:**

```env
APP_LOCALE=es
APP_FALLBACK_LOCALE=es
APP_FAKER_LOCALE=es_ES
```

### 🔒 Configurar contraseña de MySQL

Si tu XAMPP tiene contraseña en MySQL (no recomendado para desarrollo local):

**Editar `.env`:**

```env
DB_USERNAME=root
DB_PASSWORD=tu_contraseña_aqui
```

### 📧 Configurar correo (para envío de recordatorios)

Para usar correo electrónico (opcional):

**Editar `.env`:**

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tucorreo@gmail.com
MAIL_PASSWORD=tu_contraseña_de_aplicacion
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=tucorreo@gmail.com
MAIL_FROM_NAME="Dentista Muelitas"
```

### 🐳 Docker (Alternativa a XAMPP)

Si prefieres usar Docker en lugar de XAMPP:

```bash
# Usar Laravel Sail (requiere WSL2 en Windows)
composer require laravel/sail --dev
php artisan sail:install
./vendor/bin/sail up
```

---

## 🐛 Solución de Problemas Comunes

### Error: "No se puede cargar el archivo npm.ps1"

📍 **Dónde ejecutar:** PowerShell (como Administrador)

**Solución:**

```powershell
Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Scope CurrentUser -Force
```

O usa `npm.cmd` en lugar de `npm`:

```powershell
npm.cmd install
npm.cmd run dev
```

### Error: "SQLSTATE[HY000] [1045] Access denied"

📍 **Dónde revisar:** Archivo `.env` (editor de texto)

Verifica las credenciales en `.env` y asegúrate de que MySQL esté corriendo en XAMPP (Panel de Control XAMPP → Start MySQL).

### Error: "Class 'Carbon\Carbon' not found"

📍 **Dónde ejecutar:** PowerShell o Terminal (dentro del proyecto)

Ejecuta:

```bash
composer dump-autoload
```

### Migraciones fallan por tablas existentes

📍 **Dónde ejecutar:** PowerShell o Terminal (dentro del proyecto)

Elimina la base de datos y vuélvela a crear, o ejecuta:

```bash
php artisan migrate:fresh --seed
```

### Error: Base de datos comentada en .env

📍 **Dónde revisar:** Archivo `.env` (editor de texto)

Asegúrate que estas líneas NO tengan `#` al inicio:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dentista_muelitas
```

### Error: "Port 8000 is already in use"

📍 **Dónde ejecutar:** PowerShell o Terminal (dentro del proyecto)

**Causa:** Ya hay otro proceso usando el puerto 8000.

**Solución 1 - Usar otro puerto:**

```bash
php artisan serve --port=8080
# Luego abrir: http://127.0.0.1:8080
```

**Solución 2 - Cerrar el proceso que usa el puerto:**

```powershell
# Ver qué está usando el puerto 8000
netstat -ano | findstr :8000

# Matar el proceso (reemplazar PID con el número que aparece)
taskkill /PID <numero_pid> /F
```

### Error: "Apache no inicia en XAMPP - Puerto 80 ocupado"

📍 **Dónde revisar:** XAMPP Control Panel

**Causa:** Otro programa (Skype, IIS, otro servidor) está usando el puerto 80.

**Solución 1 - Cambiar puerto de Apache:**

1. XAMPP Control Panel → Apache → Config → httpd.conf
2. Buscar `Listen 80` y cambiar a `Listen 8080`
3. Buscar `ServerName localhost:80` y cambiar a `ServerName localhost:8080`
4. Guardar y reiniciar Apache
5. Acceder a phpMyAdmin: http://localhost:8080/phpmyadmin

**Solución 2 - Liberar el puerto 80:**

```powershell
# Ver qué proceso usa el puerto 80
netstat -ano | findstr :80

# Si es IIS (World Wide Web Publishing Service):
net stop W3SVC
```

### Error: "MySQL no inicia en XAMPP - Puerto 3306 ocupado"

📍 **Dónde revisar:** XAMPP Control Panel

**Causa:** Ya tienes MySQL instalado como servicio o hay otro programa usando el puerto.

**Solución:**

```powershell
# Ver qué está usando el puerto 3306
netstat -ano | findstr :3306

# Detener servicio MySQL si existe
net stop MySQL
net stop MySQL80
```

### Error: "npm ERR! code ENOENT" o "npm ERR! enoent"

📍 **Dónde ejecutar:** PowerShell o Terminal (dentro del proyecto)

**Causa:** No existe el archivo `package.json` o estás en el directorio incorrecto.

**Solución:**

```bash
# Verifica que estés en el directorio correcto
pwd
# Debería mostrar: D:\Aplicaciones\xampp\htdocs\dentista-muelitas

# Si package.json no existe, reinstalar:
composer install
```

### Error: "VITE" warnings o errores al compilar

📍 **Dónde ejecutar:** PowerShell o Terminal (dentro del proyecto)

**Solución:**

```bash
# Limpiar cache de node y reinstalar
Remove-Item -Recurse -Force node_modules
Remove-Item -Force package-lock.json
npm install
npm run dev
```

### Error: "No application encryption key has been specified"

📍 **Dónde ejecutar:** PowerShell o Terminal (dentro del proyecto)

**Solución:**

```bash
php artisan key:generate
```

### Error: Seeders no insertan datos

📍 **Dónde revisar:** Archivo `.env` + PowerShell

**Causa:** Base de datos comentada en `.env` (usando SQLite en lugar de MySQL).

**Solución:**

1. Editar `.env` y verificar que esté descomentado:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dentista_muelitas
```

2. Limpiar configuración y reejecutar:

```bash
php artisan config:clear
php artisan migrate:fresh --seed
```

### Error: "419 Page Expired" al enviar formularios

📍 **Dónde ejecutar:** PowerShell o Terminal (dentro del proyecto)

**Solución:**

```bash
# Limpiar sesiones
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

---

## 📞 ¿Necesitas Más Ayuda?

Si encuentras un error que no está en esta lista:

1. **Copiar el mensaje de error completo**
2. **Verificar:**
    - ¿XAMPP Apache y MySQL están corriendo?
    - ¿Archivo `.env` está configurado correctamente?
    - ¿Las dependencias están instaladas? (`composer install` y `npm install`)
3. **Buscar en:**
    - 📚 Documentación de Laravel: https://laravel.com/docs
    - 🔍 Stack Overflow: https://stackoverflow.com/questions/tagged/laravel
    - 💬 Contactar al equipo de desarrollo

---

## 📝 Notas Importantes

-   **Datos en español:** Todos los datos de seeders están en español con contexto boliviano (nombres, direcciones, teléfonos).
-   **Passwords de prueba:** Todos los usuarios de prueba usan `password123` como contraseña.
-   **Precios en bolivianos:** Los precios de tratamientos están en Bs.
-   **Git:** No subas `.env` al repositorio (ya está en `.gitignore`).
-   **Producción:** Cambiar `APP_DEBUG=false` y `APP_ENV=production` en `.env` antes de desplegar.
-   **Backups:** Hacer backups regulares de la base de datos en producción.
-   **Seguridad:** Cambiar todas las contraseñas en producción (especialmente la de `password123`).

---

## 🔗 Recursos Útiles

### 📚 Documentación Oficial

-   **Laravel 11:** https://laravel.com/docs/11.x
-   **Vite:** https://vitejs.dev/
-   **Blade Templates:** https://laravel.com/docs/11.x/blade
-   **Eloquent ORM:** https://laravel.com/docs/11.x/eloquent
-   **Migrations:** https://laravel.com/docs/11.x/migrations

### 🎓 Tutoriales y Cursos

-   **Laracasts:** https://laracasts.com/ (Tutoriales en video)
-   **Laravel Bootcamp:** https://bootcamp.laravel.com/ (Tutorial oficial gratis)
-   **Laravel Daily:** https://laraveldaily.com/ (Tips y trucos)

### 🛠️ Herramientas Recomendadas

-   **Laravel Debugbar:** Para debugging (instalable con `composer require barryvdh/laravel-debugbar --dev`)
-   **Laravel Telescope:** Para monitoreo (instalable con `composer require laravel/telescope`)
-   **Postman:** Para probar APIs - https://www.postman.com/
-   **HeidiSQL:** Cliente MySQL alternativo - https://www.heidisql.com/

### 🎨 Recursos de Diseño

-   **Tailwind CSS:** Framework CSS (si quieres agregar) - https://tailwindcss.com/
-   **Bootstrap:** Framework CSS - https://getbootstrap.com/
-   **Heroicons:** Iconos SVG - https://heroicons.com/
-   **Font Awesome:** Biblioteca de iconos - https://fontawesome.com/

---

## 📊 Estadísticas del Proyecto

```
📁 Archivos del Proyecto
├── 8 Tablas de Base de Datos
├── 8 Migrations
├── 8 Seeders
├── 68 Registros de Prueba
│   ├── 5 Usuarios
│   ├── 10 Pacientes
│   ├── 15 Tratamientos
│   ├── 15 Materiales
│   ├── 7 Citas
│   ├── 3 Expedientes
│   ├── 4 Facturas
│   └── 9 Movimientos Inventario
└── Base de datos lista para usar
```

---

## 🎯 Roadmap (Próximas Características)

-   [ ] Sistema de autenticación completo (Login/Registro)
-   [ ] Dashboard con estadísticas
-   [ ] CRUD completo de pacientes
-   [ ] Sistema de agenda de citas (calendario)
-   [ ] Gestión de inventario con alertas de stock bajo
-   [ ] Generación de reportes PDF
-   [ ] Sistema de notificaciones por email/SMS
-   [ ] Módulo de pagos y facturación electrónica
-   [ ] Historial clínico con imágenes
-   [ ] Sistema de respaldos automáticos
-   [ ] API REST para integración con otras apps
-   [ ] App móvil (futuro)

---

## 👨‍💻 Información del Equipo

### Roles del Proyecto

-   **Project Manager:** [Nombre]
-   **Backend Developer:** [Nombre]
-   **Frontend Developer:** [Nombre]
-   **Database Administrator:** [Nombre]
-   **QA Tester:** [Nombre]

### Convenciones de Código

**Commits:**

-   `feat:` Nueva funcionalidad
-   `fix:` Corrección de bugs
-   `docs:` Cambios en documentación
-   `style:` Formato de código
-   `refactor:` Refactorización
-   `test:` Agregar tests
-   `chore:` Tareas de mantenimiento

**Ejemplo:**

```bash
git commit -m "feat: agregar CRUD de pacientes"
git commit -m "fix: corregir validación de email en usuarios"
git commit -m "docs: actualizar README con instrucciones de deployment"
```

### Flujo de Trabajo Git

```bash
# 1. Actualizar rama principal
git checkout main
git pull origin main

# 2. Crear rama para tu feature
git checkout -b feature/nombre-descriptivo

# 3. Hacer cambios y commits
git add .
git commit -m "feat: descripción del cambio"

# 4. Subir cambios
git push origin feature/nombre-descriptivo

# 5. Crear Pull Request en GitHub/GitLab
# 6. Code Review
# 7. Merge a main
```

---

## 🤝 Colaboración

📍 **Dónde ejecutar:** Git Bash, PowerShell o Terminal (dentro del proyecto)

### Primeros Pasos

1. Crea una rama para tu feature: `git checkout -b feature/nombre-feature`
2. Commit tus cambios: `git commit -m 'feat: descripción'`
3. Push a la rama: `git push origin feature/nombre-feature`
4. Abre un Pull Request (📍 en GitHub/GitLab desde el navegador)

### Antes de hacer Push

```bash
# Asegúrate de que todo funcione:
composer install          # Instalar dependencias
npm install              # Instalar dependencias JS
php artisan migrate      # Ejecutar migraciones
php artisan test         # Ejecutar tests (si existen)
```

---

## 📄 Licencia

Este proyecto es privado y pertenece a **Dentista Muelitas**.  
Todos los derechos reservados © 2025

---

## 👨‍💻 Créditos y Contacto

### Equipo de Desarrollo

-   **Proyecto:** Dentista Muelitas - Sistema de Gestión Dental
-   **Tipo:** Proyecto académico/profesional
-   **Framework:** Laravel 11
-   **Año:** 2025

### Soporte

-   **Email del proyecto:** [tu-email@ejemplo.com]
-   **Repositorio:** [URL del repositorio]
-   **Documentación:** Este README.md

### Agradecimientos

-   Laravel Framework - https://laravel.com
-   Comunidad de Laravel
-   Documentación y recursos en español

---

## 📌 Información Rápida de Referencia

### Comandos Más Usados

```bash
# Iniciar proyecto
php artisan serve        # Iniciar servidor (http://127.0.0.1:8000)
npm run dev             # Compilar assets en tiempo real

# Base de datos
php artisan migrate              # Ejecutar migraciones
php artisan migrate:fresh --seed # Resetear BD con datos
php artisan db:seed              # Solo ejecutar seeders

# Cache
php artisan cache:clear          # Limpiar cache
php artisan config:clear         # Limpiar cache de config
php artisan optimize:clear       # Limpiar todo

# Crear archivos
php artisan make:model Nombre         # Crear modelo
php artisan make:controller Nombre    # Crear controlador
php artisan make:migration nombre     # Crear migración
php artisan make:seeder Nombre        # Crear seeder
```

### Archivos Importantes

| Archivo                 | Propósito                                   |
| ----------------------- | ------------------------------------------- |
| `.env`                  | Configuración del entorno (BD, email, etc.) |
| `routes/web.php`        | Definir rutas de la aplicación              |
| `database/migrations/`  | Estructura de la base de datos              |
| `database/seeders/`     | Datos de prueba                             |
| `resources/views/`      | Vistas HTML (Blade)                         |
| `app/Models/`           | Modelos Eloquent                            |
| `app/Http/Controllers/` | Controladores                               |
| `composer.json`         | Dependencias PHP                            |
| `package.json`          | Dependencias JavaScript                     |

---

<div align="center">

## 🦷 ¡Gracias por usar Dentista Muelitas!

**Construido con ❤️ usando Laravel**

Si este README te ayudó, no olvides dar ⭐ al repositorio

</div>

---

**Última actualización:** Noviembre 2025  
**Versión del README:** 1.0  
**¿Problemas?** Contacta al líder del proyecto o revisa la [documentación de Laravel](https://laravel.com/docs)

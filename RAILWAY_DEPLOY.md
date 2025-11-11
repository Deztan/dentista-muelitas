# 🚂 GUÍA DE DESPLIEGUE A RAILWAY - DENTISTA MUELITAS

## 📋 PASO 1: PREPARAR EL PROYECTO

### 1.1 Verificar archivos necesarios
✅ Ya tienes el `Procfile` creado
✅ Las migraciones están listas

### 1.2 Verificar archivo .env
Asegúrate de que tu archivo `.env` local tenga estos valores configurados:
```env
APP_NAME="Dentista Muelitas"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tu-app.up.railway.app

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dentista_muelitas
DB_USERNAME=root
DB_PASSWORD=
```

---

## 📋 PASO 2: PREPARAR GIT

### 2.1 Verificar estado actual
```bash
git status
```

### 2.2 Agregar todos los cambios recientes
```bash
git add .
git commit -m "Preparar proyecto para Railway - CRUD de Usuarios completado"
git push origin main
```

---

## 📋 PASO 3: CREAR PROYECTO EN RAILWAY

### 3.1 Acceder a Railway
1. Ve a https://railway.app/
2. Inicia sesión con tu cuenta de GitHub
3. Click en **"New Project"**

### 3.2 Seleccionar repositorio
1. Click en **"Deploy from GitHub repo"**
2. Busca y selecciona: **Deztan/dentista-muelitas**
3. Click en **"Deploy Now"**

---

## 📋 PASO 4: CONFIGURAR BASE DE DATOS MYSQL

### 4.1 Agregar servicio MySQL
1. En tu proyecto de Railway, click en **"+ New"**
2. Selecciona **"Database"**
3. Selecciona **"Add MySQL"**
4. Railway creará automáticamente la base de datos

### 4.2 Obtener credenciales de MySQL
1. Click en el servicio **MySQL** que acabas de crear
2. Ve a la pestaña **"Variables"**
3. Verás estas variables (Railway las crea automáticamente):
   - `MYSQLHOST`
   - `MYSQLPORT`
   - `MYSQLDATABASE`
   - `MYSQLUSER`
   - `MYSQLPASSWORD`
   - `MYSQL_URL`

---

## 📋 PASO 5: CONFIGURAR VARIABLES DE ENTORNO

### 5.1 Ir a tu aplicación Laravel
1. Click en el servicio de tu aplicación (dentista-muelitas)
2. Ve a la pestaña **"Variables"**

### 5.2 Agregar variables de entorno (una por una)
```
APP_NAME=Dentista Muelitas
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:TU_APP_KEY_AQUI
APP_URL=${{RAILWAY_PUBLIC_DOMAIN}}

DB_CONNECTION=mysql
DB_HOST=${{MYSQLHOST}}
DB_PORT=${{MYSQLPORT}}
DB_DATABASE=${{MYSQLDATABASE}}
DB_USERNAME=${{MYSQLUSER}}
DB_PASSWORD=${{MYSQLPASSWORD}}

SESSION_DRIVER=database
CACHE_DRIVER=database
QUEUE_CONNECTION=database

LOG_CHANNEL=stack
LOG_LEVEL=debug
```

### 5.3 Generar APP_KEY
Si no tienes un APP_KEY, genera uno localmente:
```bash
php artisan key:generate --show
```
Copia el valor que aparece y úsalo en Railway.

---

## 📋 PASO 6: EJECUTAR MIGRACIONES Y SEEDERS

### 6.1 Acceder a Railway CLI (Opción 1)
1. En tu proyecto de Railway, click en **Settings**
2. Baja hasta **"Deployments"**
3. Click en el último deployment exitoso
4. Click en **"View Logs"**
5. Una vez desplegado, en la pestaña del servicio, click en los 3 puntos (...)
6. Selecciona **"Create ephemeral shell"** o busca la opción de terminal

### 6.2 Ejecutar comandos (Opción 2 - Desde variables)
Agrega estas variables temporales en Railway:
```
RAILWAY_RUN_MIGRATE=yes
RAILWAY_RUN_SEED=yes
```

Luego modifica tu `Procfile` temporalmente:
```
web: php artisan migrate --force && php artisan db:seed --force && php artisan serve --host=0.0.0.0 --port=$PORT
```

### 6.3 Opción más simple - Script de inicio
Voy a crear un script que se ejecute automáticamente.

---

## 📋 PASO 7: CONFIGURAR DOMINIO PÚBLICO

### 7.1 Generar dominio
1. En tu servicio de aplicación, ve a **"Settings"**
2. Baja hasta **"Networking"**
3. Click en **"Generate Domain"**
4. Railway te dará un dominio como: `https://dentista-muelitas-production.up.railway.app`

### 7.2 Actualizar APP_URL
Vuelve a **Variables** y actualiza:
```
APP_URL=https://tu-dominio-generado.up.railway.app
```

---

## 📋 TABLAS EN TU BASE DE DATOS

### ✅ Tablas necesarias con datos (seeders):
1. **usuarios** - 6 usuarios del sistema ✅
2. **pacientes** - Ejemplos de pacientes ✅
3. **tratamientos** - Catálogo de tratamientos ✅
4. **materiales** - Inventario de materiales ✅
5. **citas** - Citas de ejemplo ✅
6. **expedientes** - Historiales clínicos ✅
7. **facturas** - Facturas de ejemplo ✅
8. **movimientos_inventario** - Movimientos de stock ✅

### ✅ Tablas del sistema (se crean vacías):
9. **sessions** - Sesiones de usuarios (Laravel) ✅
10. **cache** - Caché del sistema (Laravel) ✅
11. **jobs** - Cola de trabajos (Laravel) ✅
12. **migrations** - Control de migraciones ✅

**TODAS SON NECESARIAS** - El sistema las necesita para funcionar correctamente.

---

## 📋 PASO 8: ACCEDER A TU APLICACIÓN

### 8.1 URL de acceso
Una vez desplegado, accede a:
```
https://tu-dominio.up.railway.app/login
```

### 8.2 Credenciales de acceso
**Gerente (acceso completo):**
- Email: dr.limachi@muelitas.com
- Contraseña: DrLimachi2024!

---

## 🔧 SOLUCIÓN DE PROBLEMAS

### Error: "No application encryption key has been specified"
- Genera un APP_KEY: `php artisan key:generate --show`
- Agrégalo a las variables de entorno en Railway

### Error: "SQLSTATE[HY000] [2002] Connection refused"
- Verifica que las variables de BD estén correctamente configuradas
- Asegúrate de usar las variables de referencia: `${{MYSQLHOST}}`

### Error: "Table not found"
- Las migraciones no se ejecutaron
- Usa el Railway CLI o modifica el Procfile para ejecutar migraciones

### La aplicación no carga
- Revisa los logs en Railway: **View Logs**
- Verifica que el puerto esté correctamente configurado en el Procfile

---

## 💰 COSTOS DE RAILWAY

**Plan Trial (Gratis):**
- $5 USD de crédito gratis
- Aproximadamente 500 horas de uso
- Perfecto para desarrollo y pruebas (~1 mes)

**Después del trial:**
- ~$5-10 USD/mes dependiendo del uso
- Solo pagas lo que uses

---

## 📞 SIGUIENTES PASOS

1. ¿Quieres que cree un script automático para las migraciones?
2. ¿Necesitas ayuda con algún paso específico?
3. ¿Prefieres que te guíe paso a paso mientras lo haces?


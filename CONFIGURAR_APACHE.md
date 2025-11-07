# CONFIGURACIÓN PARA APACHE (XAMPP)

## Pasos para configurar el proyecto en Apache XAMPP:

1. **Abrir el archivo de hosts de Windows:**

    - Ruta: `C:\Windows\System32\drivers\etc\hosts`
    - Abrir como Administrador con Notepad
    - Agregar al final:
        ```
        127.0.0.1    dentista-muelitas.test
        ```

2. **Configurar Virtual Host en Apache:**

    - Abrir: `D:\Aplicaciones\xampp\apache\conf\extra\httpd-vhosts.conf`
    - Agregar al final:
        ```apache
        <VirtualHost *:80>
            DocumentRoot "D:/Aplicaciones/xampp/htdocs/dentista-muelitas/public"
            ServerName dentista-muelitas.test

            <Directory "D:/Aplicaciones/xampp/htdocs/dentista-muelitas/public">
                Options Indexes FollowSymLinks
                AllowOverride All
                Require all granted
            </Directory>
        </VirtualHost>
        ```

3. **Verificar que mod_rewrite esté habilitado:**

    - Abrir: `D:\Aplicaciones\xampp\apache\conf\httpd.conf`
    - Buscar la línea: `#LoadModule rewrite_module modules/mod_rewrite.so`
    - Quitar el `#` al inicio si lo tiene

4. **Reiniciar Apache desde el Panel de Control de XAMPP**

5. **Acceder al sitio:**
    - URL: http://dentista-muelitas.test

## Ventajas de usar Apache:

-   ✅ No necesitas tener una terminal abierta
-   ✅ El servidor está siempre disponible mientras Apache esté corriendo
-   ✅ Más similar a un entorno de producción

## Desventajas:

-   ❌ Requiere configuración adicional
-   ❌ Necesitas reiniciar Apache cada vez que cambies configuraciones
-   ❌ Puede haber conflictos si tienes otros proyectos

## RECOMENDACIÓN:

Para desarrollo, usa **php artisan serve** (más simple y rápido).
Para producción local o múltiples proyectos, usa Apache.

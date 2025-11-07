@echo off
echo ========================================
echo    DENTISTA MUELITAS - Servidor Laravel
echo ========================================
echo.
echo Iniciando servidor en http://127.0.0.1:8000
echo.
echo IMPORTANTE: NO CIERRES ESTA VENTANA
echo El servidor se ejecutara mientras esta ventana este abierta
echo.
echo Para detener el servidor: Presiona Ctrl + C
echo ========================================
echo.

cd /d D:\Aplicaciones\xampp\htdocs\dentista-muelitas
php artisan serve

pause

@echo off
echo ========================================
echo Setup Database Sistem Laundry
echo ========================================
echo.
echo IMPORTANT: Pastikan database 'laundry' sudah dibuat di MySQL!
echo.
echo Cara membuat database:
echo 1. Buka MySQL Command Line atau phpMyAdmin
echo 2. Jalankan: CREATE DATABASE laundry;
echo.
echo Tekan Enter untuk melanjutkan setelah database dibuat...
pause
echo.

echo [1/4] Checking .env file...
if not exist .env (
    echo .env file not found, copying from .env.example...
    copy .env.example .env
    echo .env file created!
) else (
    echo .env file already exists
)
echo.

echo [2/4] Generating application key...
php artisan key:generate
echo.

echo [3/4] Running migrations...
php artisan migrate
echo.

echo [4/4] Running seeders...
php artisan db:seed
echo.

echo ========================================
echo Setup completed successfully!
echo ========================================
echo.
echo Login credentials:
echo - Admin: username 'admin', password 'password'
echo - Staff: username 'staff', password 'password'
echo.
echo To start the application, run:
echo   php artisan serve
echo.
echo Then open: http://localhost:8000
echo.
pause

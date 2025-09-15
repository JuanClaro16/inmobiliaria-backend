<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Inmobiliaria – Backend (Laravel)

### Requisitos
- PHP 8.1+
- Composer
- PostgreSQL o MySQL
- Extensiones: mbstring, openssl, pdo, etc.

### Setup
```bash
cp .env
# edita credenciales DB en .env
composer install
php artisan key:generate
php artisan migrate --seed   # si tienes seeders
php artisan storage:link
php artisan serve

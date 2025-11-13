# 🚀 Setup Guide - Sistem Laundry

## Prerequisites

- PHP 8.2+
- Composer
- Node.js & NPM
- MySQL

## Quick Setup

### 1. Install Dependencies
```bash
composer install
npm install
```

### 2. Environment Setup
```bash
# Copy .env file
copy .env.example .env

# Generate application key
php artisan key:generate
```

### 3. Database Configuration

Edit `.env` file:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laundry
DB_USERNAME=root
DB_PASSWORD=
```

Create database:
```sql
CREATE DATABASE laundry;
```

### 4. Run Migrations & Seeders
```bash
php artisan migrate
php artisan db:seed
```

### 5. Run Application
```bash
# Terminal 1 - Laravel
php artisan serve

# Terminal 2 - Vite
npm run dev
```

Open: **http://localhost:8000**

## Automated Setup (Windows)

```bash
scripts/setup-database.bat
```

This script will automatically:
- Copy .env.example to .env
- Generate application key
- Run migrations
- Run seeders

## Login Credentials

**Admin:**
- Username: `admin`
- Password: `password`

**Staff:**
- Username: `staff`
- Password: `password`

## Sample Data

After seeding, you will have:
- 2 Users (admin & staff)
- 2 Staff records
- 5 Laundry service types
- 3 Sample customers

## Troubleshooting

### Database Error
```bash
# Make sure database exists
CREATE DATABASE laundry;

# Check .env configuration
DB_DATABASE=laundry
```

### Key Error
```bash
php artisan key:generate
```

### Assets Not Loading
```bash
npm run dev
```

### Port Already in Use
```bash
php artisan serve --port=8001
```

## Useful Commands

```bash
# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Fresh migration (reset database)
php artisan migrate:fresh --seed

# Run specific seeder
php artisan db:seed --class=LaundrySeeder
```

## Production Deployment

1. Set environment to production:
```env
APP_ENV=production
APP_DEBUG=false
```

2. Optimize application:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

3. Build assets:
```bash
npm run build
```

4. Set proper permissions:
```bash
chmod -R 755 storage bootstrap/cache
```

## Next Steps

After setup is complete:
1. Login as admin
2. Explore the dashboard
3. Add customers
4. Create orders
5. Manage services

For detailed documentation, see [README.md](README.md) and [STRUKTUR_LAUNDRY.md](STRUKTUR_LAUNDRY.md).

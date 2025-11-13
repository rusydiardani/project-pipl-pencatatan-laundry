# 📚 Dokumentasi Sistem Laundry

## 🚀 Quick Start

### 1. Setup Database
```bash
# Buat database MySQL
CREATE DATABASE laundry;

# Copy file .env
cp .env.example .env

# Update konfigurasi database di .env
DB_DATABASE=laundry
DB_USERNAME=root
DB_PASSWORD=
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Generate Key & Migrate
```bash
php artisan key:generate
php artisan migrate
php artisan db:seed
```

### 4. Jalankan Aplikasi
```bash
# Terminal 1: Laravel
php artisan serve

# Terminal 2: Vite (untuk assets)
npm run dev
```

Buka: `http://localhost:8000`

### 5. Login
- **Admin**: username `admin`, password `password`
- **Staff**: username `staff`, password `password`

## 📖 Dokumentasi Lengkap

- **STRUKTUR_LAUNDRY.md** - Detail database schema, models, dan relationships
- **CHANGELOG.md** - Daftar perubahan dari template apotek ke sistem laundry
- **PERBANDINGAN.md** - Perbandingan konsep apotek vs laundry

## 🎯 Fitur Utama

✅ **Manajemen Pelanggan** - CRUD pelanggan dengan pencarian
✅ **Layanan Laundry** - Kelola jenis layanan dan harga per kg
✅ **Pesanan** - Buat pesanan dengan multiple items
✅ **Tracking Status** - Pending → Processing → Ready → Completed
✅ **Pembayaran** - Support pembayaran bertahap (DP/Lunas)
✅ **Print Nota** - Cetak nota pesanan
✅ **Dashboard** - Statistik dan pesanan terbaru
✅ **Role Management** - Admin dan Staff dengan akses berbeda
✅ **Staff Management** - Kelola data karyawan
✅ **User Management** - Kelola akun pengguna

## 🗂️ Struktur Database

```
customers → orders → order_items → laundry_items
users → staff → orders
```

## 📁 Struktur Views

```
resources/views/
├── layouts/
│   └── app.blade.php          # Layout utama
├── pages/
│   ├── login.blade.php        # Halaman login
│   ├── dashboard.blade.php    # Dashboard
│   ├── customers/             # CRUD Pelanggan
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   └── edit.blade.php
│   ├── laundry-items/         # CRUD Layanan
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   └── edit.blade.php
│   ├── orders/                # Pesanan
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   ├── show.blade.php
│   │   └── print.blade.php
│   ├── staff/                 # CRUD Staff (Admin only)
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   └── edit.blade.php
│   └── users/                 # CRUD Users (Admin only)
│       ├── index.blade.php
│       ├── create.blade.php
│       └── edit.blade.php
```

## 🔧 Troubleshooting

### Error: SQLSTATE[HY000] [1049] Unknown database
Pastikan database `laundry` sudah dibuat di MySQL

### Error: No application encryption key
Jalankan: `php artisan key:generate`

### Assets tidak muncul
Pastikan `npm run dev` berjalan di terminal terpisah

### Error 403 saat akses Staff/Users
Fitur ini hanya untuk Admin, login dengan username `admin`

# 🧺 Sistem Pencatatan Laundry

Aplikasi web untuk manajemen dan pencatatan laundry berbasis Laravel 12 dengan Tailwind CSS.

## ✨ Fitur Utama

- 📋 **Manajemen Pesanan** - Buat pesanan dengan multiple items, tracking status
- 👥 **Manajemen Pelanggan** - CRUD pelanggan dengan pencarian
- 🧼 **Layanan Laundry** - Kelola jenis layanan dan harga per kg
- 💰 **Pembayaran Bertahap** - Support DP dan pelunasan
- 📄 **Print Nota** - Cetak nota pesanan untuk pelanggan
- 📊 **Dashboard** - Statistik real-time dan pesanan terbaru
- 💼 **Manajemen Staff** - Kelola data karyawan (Admin only)
- 👤 **User Management** - Kelola akun pengguna dengan role (Admin only)
- 🔐 **Role Management** - Admin dan Staff dengan akses berbeda

## 🛠️ Teknologi

- **Backend**: Laravel 12
- **Frontend**: Tailwind CSS 4, Vite
- **Database**: MySQL
- **PHP**: 8.2+

## 🚀 Quick Start

### Cara Cepat (Windows)
```bash
# 1. Install dependencies
composer install
npm install

# 2. Setup database (otomatis)
setup-database.bat

# 3. Jalankan aplikasi
php artisan serve
# Di terminal lain:
npm run dev
```

### Manual Setup

1. **Clone & Install**
```bash
git clone <repository-url>
cd PencatatanLaundry
composer install
npm install
```

2. **Setup Environment**
```bash
copy .env.example .env
php artisan key:generate
```

3. **Buat Database**

**Opsi 1 - MySQL Command Line:**
```bash
mysql -u root -p < scripts/create-database.sql
```

**Opsi 2 - phpMyAdmin:**
- Buka phpMyAdmin
- Klik tab "SQL"
- Copy isi file `scripts/create-database.sql`
- Klik "Go"

**Opsi 3 - Manual:**
```sql
CREATE DATABASE laundry CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

4. **Konfigurasi Database**
Edit file `.env`:
```env
DB_DATABASE=laundry
DB_USERNAME=root
DB_PASSWORD=
```

5. **Migrate & Seed**
```bash
php artisan migrate
php artisan db:seed
```

6. **Jalankan Aplikasi**
```bash
# Terminal 1
php artisan serve

# Terminal 2
npm run dev
```

Buka: `http://localhost:8000`

## 🔑 Login Default

- **Admin**
  - Username: `admin`
  - Password: `password`
  - Akses: Semua fitur termasuk Staff & User Management

- **Staff**
  - Username: `staff`
  - Password: `password`
  - Akses: Dashboard, Pelanggan, Layanan, Pesanan

## 📖 Dokumentasi

Dokumentasi lengkap tersedia di folder `docs/`:
- [README.md](docs/README.md) - Panduan lengkap
- [STRUKTUR_LAUNDRY.md](docs/STRUKTUR_LAUNDRY.md) - Database schema & models
- [CHANGELOG.md](docs/CHANGELOG.md) - Riwayat perubahan
- [PERBANDINGAN.md](docs/PERBANDINGAN.md) - Perbandingan konsep

## 📁 Struktur Proyek

```
PencatatanLaundry/
├── app/
│   ├── Http/Controllers/      # Controllers
│   ├── Models/                # Eloquent Models
│   └── Http/Middleware/       # Custom Middleware
├── database/
│   ├── migrations/            # Database migrations
│   └── seeders/               # Database seeders
├── resources/
│   ├── views/
│   │   ├── layouts/          # Layout templates
│   │   └── pages/            # Page views
│   ├── css/                  # Tailwind CSS
│   └── js/                   # JavaScript
├── routes/
│   └── web.php               # Web routes
└── docs/                     # Dokumentasi
```

## 🎯 Workflow Pesanan

1. **Pending** - Pesanan baru masuk
2. **Processing** - Sedang dikerjakan
3. **Ready** - Selesai, siap diambil
4. **Completed** - Sudah diambil pelanggan
5. **Cancelled** - Dibatalkan

## 💡 Tips

- Gunakan fitur pencarian di halaman Pelanggan dan Pesanan
- Filter pesanan berdasarkan status untuk mempermudah tracking
- Print nota untuk diberikan ke pelanggan
- Pembayaran bisa dilakukan bertahap (DP dulu, pelunasan kemudian)

## 🐛 Troubleshooting

**Error: Unknown database 'laundry'**
```bash
# Buat database dulu
mysql -u root -p
CREATE DATABASE laundry;
```

**Error: No application encryption key**
```bash
php artisan key:generate
```

**Assets tidak muncul**
```bash
# Pastikan npm run dev berjalan
npm run dev
```

## 📝 License

MIT License

## 👨‍💻 Developer

Sistem ini dikembangkan menggunakan Laravel 12 dan Tailwind CSS 4.

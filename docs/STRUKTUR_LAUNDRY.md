# Struktur Sistem Pencatatan Laundry

## Database Schema

### 1. Users (users)
Tabel untuk autentikasi pengguna sistem
- id
- name
- username (untuk login)
- password
- role (admin/user)
- timestamps

### 2. Staff (staff)
Tabel untuk data karyawan laundry
- id
- user_id (foreign key ke users)
- name
- phone
- address
- position (Manager, Operator, dll)
- is_active
- timestamps

### 3. Customers (customers)
Tabel untuk data pelanggan
- id
- name
- phone (unique)
- address
- email
- timestamps

### 4. Laundry Items (laundry_items)
Tabel untuk jenis layanan laundry
- id
- name (Cuci Kering, Cuci Setrika, dll)
- description
- price_per_kg
- estimated_days (estimasi hari selesai)
- is_active
- timestamps

### 5. Orders (orders)
Tabel untuk pesanan laundry
- id
- order_number (unique, format: ORD-YYYYMMDD-0001)
- customer_id (foreign key)
- staff_id (foreign key)
- order_date
- estimated_finish_date
- actual_finish_date
- status (pending, processing, ready, completed, cancelled)
- total_weight (kg)
- total_price
- paid_amount
- payment_status (unpaid, partial, paid)
- notes
- timestamps

### 6. Order Items (order_items)
Tabel detail item dalam pesanan
- id
- order_id (foreign key)
- laundry_item_id (foreign key)
- weight (kg)
- price (harga per kg saat transaksi)
- subtotal
- timestamps

## Models & Relationships

### User
- hasOne: Staff
- method: isAdmin()

### Staff
- belongsTo: User
- hasMany: Orders

### Customer
- hasMany: Orders

### LaundryItem
- hasMany: OrderItems

### Order
- belongsTo: Customer
- belongsTo: Staff
- hasMany: OrderItems
- computed: remaining_amount

### OrderItem
- belongsTo: Order
- belongsTo: LaundryItem

## Routes

### Authentication
- GET `/` - Login page
- POST `/login` - Process login
- POST `/logout` - Logout

### Dashboard
- GET `/dashboard` - Main dashboard

### Customers
- Resource routes: `/customers`
  - index, create, store, show, edit, update, destroy

### Laundry Items
- Resource routes: `/laundry-items`
  - index, create, store, show, edit, update, destroy

### Orders
- Resource routes: `/orders`
  - index, create, store, show, destroy
- POST `/orders/{order}/payment` - Add payment
- PATCH `/orders/{order}/status` - Update status
- GET `/orders/{order}/print` - Print receipt

### Admin Only
- Resource routes: `/staff`
- Resource routes: `/users`

### Reports
- GET `/reports` - Reports page

## Controllers

1. **AuthController** - Handle login/logout
2. **CustomerController** - CRUD pelanggan
3. **LaundryItemController** - CRUD jenis layanan
4. **OrderController** - CRUD pesanan + payment + status
5. **StaffController** - CRUD staff (admin only)
6. **UserController** - CRUD users (admin only)

## Default Login

**Admin:**
- Username: `admin`
- Password: `password`

**Staff:**
- Username: `staff`
- Password: `password`

## Setup Instructions

1. Buat database `laundry` di MySQL
2. Jalankan migrasi:
   ```bash
   php artisan migrate
   ```
3. Jalankan seeder:
   ```bash
   php artisan db:seed --class=LaundrySeeder
   ```
4. Jalankan aplikasi:
   ```bash
   composer run dev
   ```

## Fitur Utama

1. **Manajemen Pelanggan** - Tambah, edit, hapus data pelanggan
2. **Manajemen Layanan** - Kelola jenis layanan laundry dan harga
3. **Pesanan Laundry** - Buat pesanan dengan multiple items
4. **Tracking Status** - Pending → Processing → Ready → Completed
5. **Pembayaran** - Support pembayaran bertahap (DP/Lunas)
6. **Laporan** - Dashboard dan laporan transaksi
7. **Multi User** - Admin dan Staff dengan role berbeda

## Status Pesanan

- **pending** - Pesanan baru masuk
- **processing** - Sedang dikerjakan
- **ready** - Sudah selesai, siap diambil
- **completed** - Sudah diambil pelanggan
- **cancelled** - Dibatalkan

## Status Pembayaran

- **unpaid** - Belum bayar
- **partial** - Bayar sebagian (DP)
- **paid** - Lunas

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Staff;
use App\Models\LaundryItem;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

class LaundrySeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        $admin = User::create([
            'name' => 'Admin Laundry',
            'username' => 'admin',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Staff User
        $staffUser = User::create([
            'name' => 'Staff Laundry',
            'username' => 'staff',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // Create Staff Records
        Staff::create([
            'user_id' => $admin->id,
            'name' => 'Admin Laundry',
            'phone' => '081234567890',
            'address' => 'Jl. Laundry No. 1',
            'position' => 'Manager',
        ]);

        Staff::create([
            'user_id' => $staffUser->id,
            'name' => 'Staff Laundry',
            'phone' => '081234567891',
            'address' => 'Jl. Laundry No. 2',
            'position' => 'Operator',
        ]);

        // Create Laundry Items (Jenis Layanan)
        LaundryItem::create([
            'name' => 'Cuci Kering',
            'description' => 'Layanan cuci dan kering menggunakan mesin',
            'price_per_kg' => 5000,
            'estimated_days' => 2,
            'is_active' => true,
        ]);

        LaundryItem::create([
            'name' => 'Cuci Setrika',
            'description' => 'Layanan cuci, kering, dan setrika rapi',
            'price_per_kg' => 7000,
            'estimated_days' => 3,
            'is_active' => true,
        ]);

        LaundryItem::create([
            'name' => 'Setrika Saja',
            'description' => 'Layanan setrika saja tanpa cuci',
            'price_per_kg' => 3000,
            'estimated_days' => 1,
            'is_active' => true,
        ]);

        LaundryItem::create([
            'name' => 'Cuci Express',
            'description' => 'Layanan cuci kilat selesai dalam 1 hari',
            'price_per_kg' => 10000,
            'estimated_days' => 1,
            'is_active' => true,
        ]);

        LaundryItem::create([
            'name' => 'Dry Clean',
            'description' => 'Layanan dry cleaning untuk pakaian khusus',
            'price_per_kg' => 15000,
            'estimated_days' => 3,
            'is_active' => true,
        ]);

        // Create Sample Customers
        Customer::create([
            'name' => 'Budi Santoso',
            'phone' => '081234567892',
            'address' => 'Jl. Merdeka No. 10',
            'email' => 'budi@example.com',
        ]);

        Customer::create([
            'name' => 'Siti Nurhaliza',
            'phone' => '081234567893',
            'address' => 'Jl. Sudirman No. 20',
            'email' => 'siti@example.com',
        ]);

        Customer::create([
            'name' => 'Ahmad Wijaya',
            'phone' => '081234567894',
            'address' => 'Jl. Gatot Subroto No. 30',
            'email' => null,
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        $services = [
            // Cuci Reguler
            ['name' => 'Cuci Komplit (Reguler)', 'price' => 6000, 'available' => true],
            ['name' => 'Cuci Komplit (Express)', 'price' => 10000, 'available' => true],
            ['name' => 'Cuci Kering Saja', 'price' => 4000, 'available' => true],
            ['name' => 'Setrika Saja', 'price' => 4000, 'available' => true],

            // Bedcover & Selimut
            ['name' => 'Cuci Bedcover (Kecil)', 'price' => 15000, 'available' => true],
            ['name' => 'Cuci Bedcover (Besar)', 'price' => 25000, 'available' => true],
            ['name' => 'Cuci Selimut', 'price' => 12000, 'available' => true],
            ['name' => 'Cuci Sprei', 'price' => 8000, 'available' => true],

            // Karpet & Gordyn
            ['name' => 'Cuci Karpet (per m²)', 'price' => 15000, 'available' => true],
            ['name' => 'Cuci Gordyn (per m²)', 'price' => 12000, 'available' => true],

            // Pakaian Khusus
            ['name' => 'Cuci Jas / Blazer', 'price' => 20000, 'available' => true],
            ['name' => 'Cuci Gaun / Dress', 'price' => 25000, 'available' => true],
            ['name' => 'Cuci Kebaya', 'price' => 30000, 'available' => true],
            ['name' => 'Cuci Jaket Kulit', 'price' => 35000, 'available' => true],

            // Sepatu & Tas
            ['name' => 'Cuci Sepatu', 'price' => 25000, 'available' => true],
            ['name' => 'Cuci Tas', 'price' => 30000, 'available' => true],

            // Boneka & Lainnya
            ['name' => 'Cuci Boneka (Kecil)', 'price' => 15000, 'available' => true],
            ['name' => 'Cuci Boneka (Besar)', 'price' => 30000, 'available' => true],
        ];

        foreach ($services as $s) {
            Service::create($s);
        }
    }
}

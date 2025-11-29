<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        $services = [
            ['name' => 'Cuci Komplit (Reguler)', 'price' => 6000, 'available' => true],
            ['name' => 'Cuci Komplit (Express)', 'price' => 10000, 'available' => true],
            ['name' => 'Cuci Kering', 'price' => 4000, 'available' => true],
            ['name' => 'Setrika Saja', 'price' => 4000, 'available' => true],
            ['name' => 'Cuci Bedcover (Kecil)', 'price' => 15000, 'available' => true],
            ['name' => 'Cuci Bedcover (Besar)', 'price' => 20000, 'available' => true],
            ['name' => 'Cuci Karpet (per meter)', 'price' => 12000, 'available' => true],
        ];

        foreach ($services as $s) {
            Service::create($s);
        }
    }
}

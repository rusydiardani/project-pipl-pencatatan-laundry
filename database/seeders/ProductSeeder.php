<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            ['name' => 'Detergen Cair (Liter)', 'price' => 15000, 'stock' => 50],
            ['name' => 'Parfum Laundry (Liter)', 'price' => 25000, 'stock' => 30],
            ['name' => 'Plastik Packing (Pack)', 'price' => 10000, 'stock' => 100],
            ['name' => 'Hanger Kawat (Lusin)', 'price' => 12000, 'stock' => 40],
            ['name' => 'Pemutih Pakaian (Botol)', 'price' => 8000, 'stock' => 60],
        ];

        foreach ($products as $p) {
            Product::create($p);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;
use App\Models\Customer;
use App\Models\Service;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class TransactionSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');
        $customers = Customer::all();
        $services = Service::all();

        if ($customers->isEmpty() || $services->isEmpty()) {
            return;
        }

        // Create 15 dummy transactions
        for ($i = 0; $i < 15; $i++) {
            $customer = $customers->random();
            $refNo = 'TX-' . strtoupper(Str::random(8));
            $date = $faker->dateTimeBetween('-1 month', 'now');
            $status = $faker->randomElement(['PROCESS', 'COMPLETED', 'CANCELLED']);
            $paymentStatus = $faker->randomElement(['PAID', 'UNPAID']);
            
            // Each transaction has 1-3 items
            $itemCount = rand(1, 3);
            
            for ($j = 0; $j < $itemCount; $j++) {
                $service = $services->random();
                $weight = $faker->randomFloat(1, 1, 10); // 1.0 - 10.0 kg
                
                Transaction::create([
                    'ref_no' => $refNo,
                    'channel' => 'web',
                    'created_at_manual' => $date,
                    'created_by' => 'admin', // Asumsi admin yg buat
                    'client_name' => $customer->name,
                    'customer_id' => $customer->id,
                    'product_type' => 'service',
                    'product_id' => $service->id,
                    'product_name' => $service->name,
                    'weight' => $weight,
                    'price' => $service->price,
                    'scheduled_date' => $date,
                    'scheduled_time' => $date->format('H:i'),
                    'status' => $status,
                    'payment_status' => $paymentStatus,
                    'created_at' => $date,
                    'updated_at' => $date,
                ]);
            }
        }
    }
}

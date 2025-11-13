<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laundry_items', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama layanan: Cuci Kering, Setrika, Cuci Lipat, dll
            $table->text('description')->nullable();
            $table->decimal('price_per_kg', 10, 2); // Harga per kg
            $table->integer('estimated_days')->default(3); // Estimasi hari selesai
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laundry_items');
    }
};

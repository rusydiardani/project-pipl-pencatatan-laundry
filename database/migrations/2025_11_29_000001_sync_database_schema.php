<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Rename meds table to products
        if (Schema::hasTable('meds') && !Schema::hasTable('products')) {
            Schema::rename('meds', 'products');
        }

        // 2. Add payment_status column to transactions
        if (Schema::hasTable('transactions') && !Schema::hasColumn('transactions', 'payment_status')) {
            Schema::table('transactions', function (Blueprint $table) {
                $table->enum('payment_status', ['PAID', 'UNPAID'])->default('UNPAID')->after('price');
            });
        }

        // 3. Modify product_type and status columns to be flexible strings
        // We use raw SQL because doctrine/dbal might be missing
        try {
            DB::statement("ALTER TABLE transactions MODIFY COLUMN product_type VARCHAR(50)");
            DB::statement("ALTER TABLE transactions MODIFY COLUMN status VARCHAR(50) DEFAULT 'NEW'");
        } catch (\Exception $e) {
            // Fallback for SQLite or other drivers if needed, or just log
            // SQLite doesn't support MODIFY COLUMN easily, but we assume MySQL here.
        }

        // 4. Data Migration: Update 'med' to 'product'
        DB::table('transactions')
            ->where('product_type', 'med')
            ->update(['product_type' => 'product']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 1. Rename back
        if (Schema::hasTable('products') && !Schema::hasTable('meds')) {
            Schema::rename('products', 'meds');
        }

        // 2. Drop payment_status
        if (Schema::hasColumn('transactions', 'payment_status')) {
            Schema::table('transactions', function (Blueprint $table) {
                $table->dropColumn('payment_status');
            });
        }
    }
};

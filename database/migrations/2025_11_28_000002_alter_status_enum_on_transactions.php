<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $driver = DB::getPDO()->getAttribute(\PDO::ATTR_DRIVER_NAME);

        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE `transactions` MODIFY COLUMN `status` ENUM('ON PROCESS','COMPLETED','CANCELLED') NOT NULL DEFAULT 'ON PROCESS'");
        } else {
            // Untuk SQLite / Postgres: ubah nilai lama 'NEW' menjadi 'ON PROCESS'
            DB::statement("UPDATE transactions SET status = 'ON PROCESS' WHERE status = 'NEW'");
        }
    }

    public function down(): void
    {
        $driver = DB::getPDO()->getAttribute(\PDO::ATTR_DRIVER_NAME);

        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE `transactions` MODIFY COLUMN `status` ENUM('NEW','COMPLETED','CANCELLED') NOT NULL DEFAULT 'NEW'");
        } else {
            DB::statement("UPDATE transactions SET status = 'NEW' WHERE status = 'ON PROCESS'");
        }
    }
};


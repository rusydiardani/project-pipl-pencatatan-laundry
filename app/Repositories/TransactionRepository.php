<?php

namespace App\Repositories;

use App\Models\Transaction;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TransactionRepository
{
    public function create(array $data): Transaction
    {
        return Transaction::create($data);
    }
    
    public function findByRefNo(string $refNo): Collection
    {
        return Transaction::where('ref_no', $refNo)
            ->orderBy('id')
            ->get();
    }
    
    public function getTodayTransactions()
    {
        return Transaction::whereDate('created_at', today())->get();
    }
    
    public function getTodayRevenue(): float
    {
        return Transaction::whereDate('created_at', today())
            ->where('payment_status', 'PAID')
            ->get()
            ->sum(function ($transaction) {
                return $transaction->weight * $transaction->price;
            });
    }
    
    public function getTransactionsByStatus(string $status): int
    {
        return Transaction::where('status', $status)->count();
    }

    public function getRecentTransactions(int $limit = 10)
    {
        return DB::table('transactions')
            ->select(
                'ref_no',
                DB::raw('MIN(created_at) as created_at'),
                DB::raw('MIN(created_by) as created_by'),
                DB::raw('MIN(client_name) as client_name'),
                DB::raw('COUNT(*) as items_count'),
                DB::raw('SUM(weight * price) as total')
            )
            ->groupBy('ref_no')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}

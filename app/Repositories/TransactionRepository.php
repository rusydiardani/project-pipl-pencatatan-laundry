<?php

namespace App\Repositories;

use App\Models\Transaction;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class TransactionRepository
{
    /**
     * Create a new transaction
     */
    public function create(array $data): Transaction
    {
        return Transaction::create($data);
    }
    
    /**
     * Find all transactions by ref_no
     */
    public function findByRefNo(string $refNo): Collection
    {
        return Transaction::where('ref_no', $refNo)
            ->orderBy('id')
            ->get();
    }

    /**
     * Get paginated list of transactions grouped by ref_no
     */
    public function getPaginatedList(int $perPage = 10, string $search = ''): LengthAwarePaginator
    {
        $query = Transaction::select(
            'ref_no',
            DB::raw('MIN(created_at) as created_at'),
            DB::raw('MIN(created_by) as created_by'),
            DB::raw('MIN(client_name) as client_name'),
            DB::raw('SUM(weight * price) as total'),
            DB::raw('COUNT(*) as items_count'),
            DB::raw('MIN(status) as status')
        )
        ->groupBy('ref_no')
        ->orderBy(DB::raw('MIN(created_at)'), 'desc');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('ref_no', 'like', "%{$search}%")
                  ->orWhere('client_name', 'like', "%{$search}%");
            });
        }

        return $query->paginate($perPage);
    }

    /**
     * Delete all transactions by ref_no
     */
    public function deleteByRefNo(string $refNo): int
    {
        return Transaction::where('ref_no', $refNo)->delete();
    }

    /**
     * Count transactions by ref_no
     */
    public function countByRefNo(string $refNo): int
    {
        return Transaction::where('ref_no', $refNo)->count();
    }

    /**
     * Get transaction detail with header info
     */
    public function getDetailByRefNo(string $refNo): ?array
    {
        $items = Transaction::where('ref_no', $refNo)
            ->orderBy('id')
            ->get();

        if ($items->isEmpty()) {
            return null;
        }

        $first = $items->first();
        $header = (object)[
            'ref_no'      => $first->ref_no,
            'created_at'  => $first->created_at,
            'created_by'  => $first->created_by,
            'client_name' => $first->client_name,
        ];

        $services = $items->where('product_type', 'service')->values();
        $meds     = $items->where('product_type', 'product')->values();
        $total    = $items->reduce(fn($c, $it) => $c + ($it->weight * $it->price), 0);

        return compact('header', 'services', 'meds', 'total');
    }

    /**
     * Update status for all transactions with same ref_no
     */
    public function updateStatusByRefNo(string $refNo, string $status, string $paymentStatus): int
    {
        return Transaction::where('ref_no', $refNo)->update([
            'status' => $status,
            'payment_status' => $paymentStatus,
        ]);
    }
    
    /**
     * Get today's transactions
     */
    public function getTodayTransactions(): Collection
    {
        return Transaction::whereDate('created_at', today())->get();
    }
    
    /**
     * Get today's revenue (PAID only)
     */
    public function getTodayRevenue(): float
    {
        return Transaction::whereDate('created_at', today())
            ->where('payment_status', 'PAID')
            ->get()
            ->sum(function ($transaction) {
                return $transaction->weight * $transaction->price;
            });
    }
    
    /**
     * Get count of transactions by status
     */
    public function getTransactionsByStatus(string $status): int
    {
        return Transaction::where('status', $status)->count();
    }

    /**
     * Get recent transactions for dashboard
     */
    public function getRecentTransactions(int $limit = 10): Collection
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

    /**
     * Get all transactions
     */
    public function getAll(): Collection
    {
        return Transaction::all();
    }

    /**
     * Find single transaction by ID
     */
    public function findById(int $id): ?Transaction
    {
        return Transaction::find($id);
    }

    /**
     * Update a transaction
     */
    public function update(Transaction $transaction, array $data): bool
    {
        return $transaction->update($data);
    }

    /**
     * Delete a transaction
     */
    public function delete(Transaction $transaction): bool
    {
        return $transaction->delete();
    }
}


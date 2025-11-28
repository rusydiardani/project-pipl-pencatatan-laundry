<?php

namespace App\Services;

use App\Repositories\TransactionRepository;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    protected $transactionRepo;

    public function __construct(TransactionRepository $transactionRepo)
    {
        $this->transactionRepo = $transactionRepo;
    }

    /**
     * Get metrik hari ini
     */
    public function getTodayMetrics(): array
    {
        $todayTransactions = $this->transactionRepo->getTodayTransactions();
        
        return [
            'total_transactions' => $todayTransactions->unique('ref_no')->count(),
            'total_revenue' => $this->transactionRepo->getTodayRevenue(),
            'pending_payments' => $this->getPendingPayments(),
            'total_items' => $todayTransactions->count(),
        ];
    }

    /**
     * Get statistik revenue
     */
    public function getRevenueStats(): array
    {
        return [
            'today' => $this->transactionRepo->getTodayRevenue(),
            'this_week' => $this->getWeeklyRevenue(),
            'this_month' => $this->getMonthlyRevenue(),
        ];
    }

    /**
     * Get breakdown berdasarkan status
     */
    public function getStatusBreakdown(): array
    {
        $statuses = ['NEW', 'RECEIVED', 'PROCESS', 'WASHING', 'IRONING', 'READY', 'COMPLETED', 'PICKED_UP', 'CANCELLED'];
        $breakdown = [];

        foreach ($statuses as $status) {
            $breakdown[$status] = $this->transactionRepo->getTransactionsByStatus($status);
        }

        return $breakdown;
    }

    /**
     * Get pending payments
     */
    protected function getPendingPayments(): array
    {
        $unpaid = DB::table('transactions')
            ->where('payment_status', 'UNPAID')
            ->selectRaw('COUNT(DISTINCT ref_no) as count, SUM(weight * price) as total')
            ->first();

        return [
            'count' => $unpaid->count ?? 0,
            'total' => $unpaid->total ?? 0,
        ];
    }

    /**
     * Get weekly revenue
     */
    protected function getWeeklyRevenue(): float
    {
        return DB::table('transactions')
            ->where('payment_status', 'PAID')
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->sum(DB::raw('weight * price'));
    }

    /**
     * Get monthly revenue
     */
    protected function getMonthlyRevenue(): float
    {
        return DB::table('transactions')
            ->where('payment_status', 'PAID')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum(DB::raw('weight * price'));
    }
    /**
     * Get recent transactions
     */
    public function getRecentTransactions(int $limit = 10)
    {
        return $this->transactionRepo->getRecentTransactions($limit);
    }
}

<?php

namespace App\Services;

use App\Models\Transaction;
use App\Repositories\TransactionRepository;
use Illuminate\Support\Facades\DB;

class TransactionService
{
    protected $repository;

    public function __construct(TransactionRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Buat transaksi baru (multi-item support)
     */
    public function createTransaction(array $clientData, array $items): array
    {
        return DB::transaction(function () use ($clientData, $items) {
            $refNo = $this->generateRefNo();
            $createdBy = auth()->user()->username ?? 'system';
            
            $transactions = [];
            foreach ($items as $item) {
                $transaction = $this->repository->create([
                    'ref_no' => $refNo,
                    'created_by' => $createdBy,
                    'client_name' => $clientData['client_name'],
                    'customer_id' => $clientData['customer_id'] ?? null,
                    'product_type' => $item['product_type'],
                    'product_id' => $item['product_id'],
                    'product_name' => $item['product_name'],
                    'weight' => $item['weight'],
                    'price' => $item['price'],
                    'scheduled_date' => $item['scheduled_date'] ?? null,
                    'scheduled_time' => $item['scheduled_time'] ?? null,
                    'status' => $item['status'] ?? 'NEW',
                    'payment_status' => $item['payment_status'] ?? 'UNPAID',
                ]);
                
                $transactions[] = $transaction;
                
                // Trigger event
                event(new \App\Events\TransactionCreated($transaction));
            }
            
            return $transactions;
        });
    }

    /**
     * Update status transaksi
     */
    public function updateStatus(Transaction $transaction, string $status, string $paymentStatus): Transaction
    {
        $oldStatus = $transaction->status;
        $oldPaymentStatus = $transaction->payment_status;
        
        $transaction->update([
            'status' => $status,
            'payment_status' => $paymentStatus,
        ]);
        
        // Trigger events
        if ($oldStatus !== $status) {
            event(new \App\Events\TransactionStatusUpdated($transaction, $oldStatus));
        }
        
        if ($oldPaymentStatus !== $paymentStatus) {
            event(new \App\Events\PaymentStatusUpdated($transaction, $oldPaymentStatus));
        }
        
        return $transaction;
    }

    /**
     * Generate unique ref_no
     */
    protected function generateRefNo(): string
    {
        return 'TX-' . now()->format('YmdHis') . rand(100, 999);
    }

    /**
     * Hitung total transaksi berdasarkan ref_no
     */
    public function calculateTotal(string $refNo): float
    {
        $transactions = $this->repository->findByRefNo($refNo);
        
        return $transactions->sum(function ($transaction) {
            return $transaction->weight * $transaction->price;
        });
    }
}

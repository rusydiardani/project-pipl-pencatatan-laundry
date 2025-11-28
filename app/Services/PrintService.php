<?php

namespace App\Services;

use App\Repositories\TransactionRepository;
use Barryvdh\DomPDF\Facade\Pdf;

class PrintService
{
    protected $transactionRepo;

    public function __construct(TransactionRepository $transactionRepo)
    {
        $this->transactionRepo = $transactionRepo;
    }

    /**
     * Generate PDF receipt untuk transaksi
     */
    public function generateReceipt(string $refNo)
    {
        $transactions = $this->transactionRepo->findByRefNo($refNo);
        
        if ($transactions->isEmpty()) {
            abort(404, "Transaksi tidak ditemukan");
        }

        $data = $this->formatReceiptData($transactions);
        
        // Load view dan convert to PDF
        $pdf = Pdf::loadView('pdf.receipt', $data);
        
        // Set paper size (A5 landscape atau thermal)
        $pdf->setPaper('a5', 'portrait');
        
        return $pdf;
    }

    /**
     * Format data untuk template receipt
     */
    protected function formatReceiptData($transactions): array
    {
        $first = $transactions->first();
        
        // Group by product type
        $services = $transactions->where('product_type', 'service');
        $products = $transactions->where('product_type', 'product');
        
        // Calculate totals
        $total = $transactions->sum(function ($transaction) {
            return $transaction->weight * $transaction->price;
        });
        
        return [
            'ref_no' => $first->ref_no,
            'date' => $first->created_at->format('d F Y, H:i'),
            'client_name' => $first->client_name,
            'created_by' => $first->created_by,
            'services' => $services,
            'products' => $products,
            'total' => $total,
            'status' => $first->status,
            'payment_status' => $first->payment_status,
        ];
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Repositories\TransactionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\PrintService;

class TransactionController extends Controller
{
    protected TransactionRepository $transactionRepo;

    public function __construct(TransactionRepository $transactionRepo)
    {
        $this->transactionRepo = $transactionRepo;
    }

    public function index()
    {
        $transactions = $this->transactionRepo->getAll();
        return response()->json($transactions);
    }

    public function createPage()
    {
        return view('pages.buat');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_name' => 'required|string',
            'customer_id' => 'nullable|exists:customers,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|integer',
            'items.*.product_name' => 'required|string',
            'items.*.product_type' => 'required|in:service,product',
            'items.*.weight' => 'required|numeric|min:0.1',
            'items.*.price' => 'required|numeric|min:0',
            'items.*.scheduled_date' => 'nullable|date',
            'items.*.scheduled_time' => 'nullable',
            'items.*.status' => 'nullable|in:ON PROCESS,COMPLETED',
        ]);

        $ref  = 'TX-' . now()->format('YmdHis') . rand(100, 999);
        $user = Auth::user()?->username ?? 'system';

        foreach ($validated['items'] as $item) {
            $transaction = $this->transactionRepo->create([
                'ref_no'            => $ref,
                'channel'           => 'Point Of Sale',
                'created_at_manual' => now(),
                'created_by'        => $user,
                'client_name'       => $validated['client_name'],
                'customer_id'       => $validated['customer_id'] ?? null,
                'product_id'        => $item['product_id'],
                'product_name'      => $item['product_name'],
                'product_type'      => $item['product_type'],
                'weight'            => $item['weight'],
                'price'             => $item['price'],
                'scheduled_date'    => $item['product_type'] === 'service' ? ($item['scheduled_date'] ?? null) : null,
                'scheduled_time'    => $item['product_type'] === 'service' ? ($item['scheduled_time'] ?? null) : null,
                'status'            => $item['status'] ?? 'ON PROCESS',
            ]);

            \App\Events\TransactionCreated::dispatch($transaction);
        }

        return response()->json(['success' => true, 'ref_no' => $ref]);
    }

    public function show(Transaction $transaction)
    {
        return response()->json($transaction);
    }

    public function update(Request $request, Transaction $transaction)
    {
        $data = $request->validate([
            'client_name' => 'nullable|string',
            'status' => 'in:ON PROCESS,COMPLETED'
        ]);

        $this->transactionRepo->update($transaction, $data);

        if ($request->wantsJson()) {
            return response()->json($transaction);
        }
        return redirect()->route('transactions.detail', $transaction->ref_no)
            ->with('success', 'Status transaksi berhasil diperbarui.');
    }

    public function destroy(Transaction $transaction)
    {
        $this->transactionRepo->delete($transaction);
        return response()->noContent();
    }

    public function listPage(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);
        $search  = trim($request->query('search', ''));

        $rows = $this->transactionRepo->getPaginatedList($perPage, $search)
            ->appends($request->query());

        return view('pages.list', compact('rows', 'search'));
    }

    public function destroyByRef(string $ref_no)
    {
        $count = $this->transactionRepo->countByRefNo($ref_no);

        if ($count === 0) {
            return redirect()->route('list.page')->with('error', "Transaksi {$ref_no} tidak ditemukan.");
        }

        $this->transactionRepo->deleteByRefNo($ref_no);

        return redirect()->route('list.page')->with('success', "Transaksi {$ref_no} ({$count} item) berhasil dihapus.");
    }

    public function detailByRef(string $ref_no)
    {
        $detail = $this->transactionRepo->getDetailByRefNo($ref_no);

        if ($detail === null) {
            return redirect()->route('list.page')->with('error', "Transaksi $ref_no tidak ditemukan.");
        }

        return view('pages.detail', $detail);
    }

    public function edit(string $refNo)
    {
        $transactions = $this->transactionRepo->findByRefNo($refNo);
        
        if ($transactions->isEmpty()) {
            return redirect()->route('list.page')->with('error', 'Transaksi tidak ditemukan');
        }
        
        $transaction = $transactions->first();
        
        return view('pages.transaction_edit', compact('transaction', 'transactions'));
    }

    public function updateByRef(Request $request, string $refNo)
    {
        $request->validate([
            'status' => 'required|in:PROCESS,COMPLETED,CANCELLED',
            'payment_status' => 'required|in:PAID,UNPAID',
        ]);

        $this->transactionRepo->updateStatusByRefNo(
            $refNo,
            $request->status,
            $request->payment_status
        );

        return redirect()->route('list.page')->with('success', 'Status transaksi berhasil diperbarui');
    }

    public function printReceipt(string $refNo, PrintService $printService)
    {
        $pdf = $printService->generateReceipt($refNo);
        
        return $pdf->stream("struk-{$refNo}.pdf");
    }
}

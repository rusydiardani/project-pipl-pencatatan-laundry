<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Services\PrintService;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::all();
        return response()->json($transactions);
    }

    public function createPage()
    {
        return view('pages.buat');
    }

    public function store(Request $request)
    {
        // Validasi dasar (tanpa ref_no & created_by dari FE)
        $validated = $request->validate([
            'client_name' => 'required|string',
            'customer_id' => 'nullable|exists:customers,id',
            // 'age' => 'nullable|integer|min:0|max:120',
            // 'occupation' => 'nullable|string',
            // 'sex' => 'nullable|in:M,F',

            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|integer',
            'items.*.product_name' => 'required|string',
            'items.*.product_type' => 'required|in:service,med',
            'items.*.weight' => 'required|numeric|min:0.1',
            'items.*.price' => 'required|numeric|min:0',
            // 'items.*.duration' => 'nullable|string',

            'items.*.scheduled_date' => 'nullable|date',
            'items.*.scheduled_time' => 'nullable',
            // 'items.*.staff_nik' => 'required|string',
            // 'items.*.location' => 'required|string',
            'items.*.status' => 'nullable|in:ON PROCESS,COMPLETED',
        ]);

        // Jadwal bersifat opsional untuk service, dan diabaikan untuk med

        // Generate ref & created_by di server
        $ref  = 'TX-' . now()->format('YmdHis') . rand(100, 999);
        $user = Auth::user()?->username ?? 'system';

        foreach ($validated['items'] as $item) {
            $transaction = Transaction::create([
                'ref_no'            => $ref,
                'channel'           => 'Point Of Sale',
                'created_at_manual' => now(), // ubah/nullable sesuai kebutuhanmu
                'created_by'        => $user,

                'client_name'       => $validated['client_name'],
                'customer_id'       => $validated['customer_id'] ?? null,
                // 'age'               => $validated['age'] ?? null,
                // 'occupation'        => $validated['occupation'] ?? null,
                // 'sex'               => $validated['sex'] ?? null,

                'product_id'        => $item['product_id'],
                'product_name'      => $item['product_name'],
                'product_type'      => $item['product_type'],
                'weight'               => $item['weight'],
                'price'             => $item['price'],
                // 'duration'          => $item['duration'] ?? null,

                'scheduled_date'    => $item['product_type'] === 'service' ? ($item['scheduled_date'] ?? null) : null,
                'scheduled_time'    => $item['product_type'] === 'service' ? ($item['scheduled_time'] ?? null) : null,

                // 'staff_nik'         => $item['staff_nik'],
                // 'location'          => $item['location'],

                'status'            => $item['status'] ?? 'ON PROCESS',
            ]);

            // Fire event for stock deduction
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
            // 'age' => 'nullable|integer|min:0|max:120',
            // 'occupation' => 'nullable|string',
            // 'sex' => 'nullable|in:M,F',
            'status' => 'in:ON PROCESS,COMPLETED'
        ]);

        $transaction->update($data);
        if ($request->wantsJson()) {
            return response()->json($transaction);
        }
        return redirect()->route('transactions.detail', $transaction->ref_no)
            ->with('success', 'Status transaksi berhasil diperbarui.');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return response()->noContent();
    }

    public function listPage(Request $request)
{
    // berapa item per halaman (bisa lewat query ?per_page=20)
    $perPage = (int) $request->query('per_page', 10);
    $search  = trim($request->query('search', ''));

    // Baseline query: kita ringkas per ref_no
    $query = \App\Models\Transaction::select(
        'ref_no',
        DB::raw('MIN(created_at) as created_at'),
        DB::raw('MIN(created_by) as created_by'),
        DB::raw('MIN(client_name) as client_name'),
        DB::raw('SUM(weight * price) as total'),
        DB::raw('COUNT(*) as items_count'),
        DB::raw("SUM(CASE WHEN status = 'ON PROCESS' THEN 1 ELSE 0 END) as on_process_count")
    )
    ->groupBy('ref_no')
    ->orderBy(DB::raw('MIN(created_at)'), 'desc');

    // Jika ada search, tambahkan filter (by ref_no OR client_name)
    if ($search !== '') {
        $query->where(function ($q) use ($search) {
            $q->where('ref_no', 'like', "%{$search}%")
              ->orWhere('client_name', 'like', "%{$search}%");
        });
    }

    $rows = $query->paginate($perPage)->appends($request->query());

    return view('pages.list', compact('rows', 'search'));
}

public function destroyByRef(string $ref_no)
{
    // Opsi: tambahkan otorisasi di sini kalau perlu (mis. Gate/Policy)

    $count = \App\Models\Transaction::where('ref_no', $ref_no)->count();
    if ($count === 0) {
        return redirect()->route('list.page')->with('error', "Transaksi {$ref_no} tidak ditemukan.");
    }

    \App\Models\Transaction::where('ref_no', $ref_no)->delete();

    return redirect()->route('list.page')->with('success', "Transaksi {$ref_no} ({$count} item) berhasil dihapus.");
}

//detailtransaksi
    public function detailByRef(string $ref_no)
{
    $items = \App\Models\Transaction::query()
        ->where('ref_no', $ref_no)
        ->orderBy('id')
        ->get();

    if ($items->isEmpty()) {
        return redirect()->route('list.page')->with('error', "Transaksi $ref_no tidak ditemukan.");
    }

    $first = $items->first();
    $header = (object)[
        'ref_no'      => $first->ref_no,
        'created_at'  => $first->created_at,
        'created_by'  => $first->created_by,
        'client_name' => $first->client_name,
    ];

    $services = $items->where('product_type', 'service')->values();
    $meds     = $items->where('product_type', 'med')->values();

    $total = $items->reduce(fn($c,$it)=> $c + ($it->weight * $it->price), 0);

    return view('pages.detail', compact('header','services','meds','total'));
}


// public function recommend(Request $request)
// {
//     $age        = $request->filled('age') ? (int)$request->age : null;
//     $sex        = $request->sex ?: null;
//     $occupation = $request->occupation ? trim($request->occupation) : null;
//     $limit      = 10; // top-N yang kamu mau

//     // helper build query dengan opsi pelonggaran
//     $build = function(bool $useAge, int $ageRange, bool $useSex, bool $useOcc) use ($age,$sex,$occupation) {
//         $q = Transaction::query();

//         if ($useSex && $sex) {
//             $q->where('sex', $sex);
//         }

//         if ($useAge && $age !== null) {
//             $min = max(0, $age - $ageRange);
//             $max = min(120, $age + $ageRange);
//             // Sertakan age NULL supaya data lama tidak “hilang total” saat filter usia aktif
//             $q->where(function($w) use ($min,$max) {
//                 $w->whereBetween('age', [$min,$max])
//                   ->orWhereNull('age');
//             });
//         }

//         if ($useOcc && $occupation) {
//             // case-insensitive dan trimming
//             $q->whereRaw('LOWER(TRIM(occupation)) LIKE ?', ['%'.strtolower($occupation).'%']);
//         }

//         return $q;
//     };

//     // ===== Progressive backoff =====
//     // 1) ketat: age±5 + sex + occupation
//     $candidates = $build(true, 5, true, true)->get(['product_id','product_type']);
//     // 2) longgarkan usia (±10), tetap sex, drop occ jika perlu
//     if ($candidates->isEmpty()) $candidates = $build(true,10, true, true)->get(['product_id','product_type']);
//     if ($candidates->isEmpty()) $candidates = $build(true,10, true, false)->get(['product_id','product_type']);
//     // 3) hanya sex
//     if ($candidates->isEmpty()) $candidates = $build(false,0, true, false)->get(['product_id','product_type']);
//     // 4) hanya occupation
//     if ($candidates->isEmpty()) $candidates = $build(false,0, false, true)->get(['product_id','product_type']);
//     // 5) trending global (fallback)
//     $fallbackUsed = false;
//     if ($candidates->isEmpty()) {
//         $fallbackUsed = true;
//         $candidates = Transaction::query()
//             ->latest('created_at')
//             ->limit(1000) // batasi scan
//             ->get(['product_id','product_type']);
//     }

//     // Hitung frekuensi per (product_id, product_type)
//     $counts = [];
//     foreach ($candidates as $tx) {
//         if (!$tx->product_id || !$tx->product_type) continue;
//         $key = $tx->product_id . '|' . $tx->product_type;
//         $counts[$key] = ($counts[$key] ?? 0) + 1;
//     }
//     arsort($counts);

//     // Ambil Top-N dan map ke bentuk FE
//     $topKeys = array_slice(array_keys($counts), 0, $limit);
//     $recommendations = [];
//     foreach ($topKeys as $key) {
//         [$pid, $ptype] = explode('|', $key);
//         $recommendations[] = [
//             'product_id'   => (int)$pid,
//             'product_type' => $ptype,
//         ];
//     }

//     return response()->json([
//         'recommendations' => $recommendations,
//         'total_matches'   => array_sum(array_intersect_key($counts, array_flip($topKeys))) ?: $candidates->count(),
//         'fallback_used'   => $fallbackUsed,
//     ]);
// }

    /**
     * Show form edit status transaksi
     */
    public function edit(string $refNo)
    {
        $transactions = Transaction::where('ref_no', $refNo)->get();
        
        if ($transactions->isEmpty()) {
            return redirect()->route('list.page')->with('error', 'Transaksi tidak ditemukan');
        }
        
        // Ambil data umum dari item pertama
        $transaction = $transactions->first();
        
        return view('pages.transaction_edit', compact('transaction', 'transactions'));
    }

    /**
     * Update status transaksi by Ref No
     */
    public function updateByRef(Request $request, string $refNo, \App\Services\TransactionService $transactionService)
    {
        $request->validate([
            'status' => 'required|in:NEW,RECEIVED,PROCESS,WASHING,IRONING,READY,COMPLETED,PICKED_UP,CANCELLED',
            'payment_status' => 'required|in:PAID,UNPAID',
        ]);

        // Gunakan service atau direct update
        // Karena kita belum fully migrate ke service di controller ini, kita direct update dulu
        // atau gunakan logic manual untuk trigger event jika perlu.
        // Untuk sekarang direct update agar cepat fix.
        
        Transaction::where('ref_no', $refNo)->update([
            'status' => $request->status,
            'payment_status' => $request->payment_status,
        ]);

        return redirect()->route('list.page')->with('success', 'Status transaksi berhasil diperbarui');
    }

    /**
     * Generate dan download PDF receipt
     */
    public function printReceipt(string $refNo, PrintService $printService)
    {
        $pdf = $printService->generateReceipt($refNo);
        
        // Download PDF dengan nama file yang sesuai
        return $pdf->download("struk-{$refNo}.pdf");
        
        // Atau jika ingin ditampilkan di browser (bukan download):
        // return $pdf->stream("struk-{$refNo}.pdf");
    }

}

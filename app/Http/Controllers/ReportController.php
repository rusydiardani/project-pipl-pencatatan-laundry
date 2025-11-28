<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        return view('pages.reports.index');
    }

    public function generate(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'status'     => 'nullable|string',
        ]);

        $startDate = Carbon::parse($request->start_date)->startOfDay();
        $endDate   = Carbon::parse($request->end_date)->endOfDay();
        $status    = $request->status;

        $query = Transaction::query()
            ->whereBetween('created_at', [$startDate, $endDate]);

        if ($status && $status !== 'ALL') {
            $query->where('status', $status);
        }

        $transactions = $query->orderBy('created_at', 'desc')->get();

        // Calculate summary
        $totalRevenue = $transactions->sum(function($t) {
            return $t->weight * $t->price;
        });
        $totalTransactions = $transactions->unique('ref_no')->count();
        $totalItems = $transactions->count();

        return view('pages.reports.result', compact('transactions', 'totalRevenue', 'totalTransactions', 'totalItems', 'startDate', 'endDate', 'status'));
    }
}

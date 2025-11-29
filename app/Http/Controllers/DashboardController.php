<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index(Request $request)
    {
        $metrics = $this->dashboardService->getTodayMetrics();
        $revenueStats = $this->dashboardService->getRevenueStats();
        $statusBreakdown = $this->dashboardService->getStatusBreakdown();
        $recentTransactions = $this->dashboardService->getRecentTransactions();
        
        // Chart Data with Filter
        $selectedMonth = $request->query('month', now()->format('Y-m'));
        $availableMonths = $this->dashboardService->getAvailableMonths();
        $chartData = $this->dashboardService->getDailyRevenueChart($selectedMonth);
        
        return view('pages.dashboard', compact('metrics', 'revenueStats', 'statusBreakdown', 'recentTransactions', 'chartData', 'availableMonths', 'selectedMonth'));
    }
}

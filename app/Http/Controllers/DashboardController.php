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

    public function index()
    {
        $metrics = $this->dashboardService->getTodayMetrics();
        $revenueStats = $this->dashboardService->getRevenueStats();
        $statusBreakdown = $this->dashboardService->getStatusBreakdown();
        $recentTransactions = $this->dashboardService->getRecentTransactions();
        
        return view('pages.dashboard', compact('metrics', 'revenueStats', 'statusBreakdown', 'recentTransactions'));
    }
}

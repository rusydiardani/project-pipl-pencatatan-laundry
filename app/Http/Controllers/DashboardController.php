<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use App\Models\LaundryItem;
use App\Models\Staff;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'processing_orders' => Order::where('status', 'processing')->count(),
            'ready_orders' => Order::where('status', 'ready')->count(),
            'total_customers' => Customer::count(),
            'active_services' => LaundryItem::where('is_active', true)->count(),
            'total_staff' => Staff::where('is_active', true)->count(),
            'monthly_revenue' => Order::whereMonth('order_date', now()->month)
                ->whereYear('order_date', now()->year)
                ->sum('total_price'),
            'monthly_orders' => Order::whereMonth('order_date', now()->month)
                ->whereYear('order_date', now()->year)
                ->count(),
        ];

        $recentOrders = Order::with(['customer', 'staff'])
            ->latest()
            ->take(5)
            ->get();

        return view('pages.dashboard', compact('stats', 'recentOrders'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use App\Models\LaundryItem;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with(['customer', 'staff'])
            ->when($request->search, function($query, $search) {
                $query->where('order_number', 'like', "%{$search}%")
                      ->orWhereHas('customer', function($q) use ($search) {
                          $q->where('name', 'like', "%{$search}%");
                      });
            })
            ->when($request->status, function($query, $status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(20);
        return view('pages.orders.index', compact('orders'));
    }

    public function create()
    {
        $customers = Customer::all();
        $laundryItems = LaundryItem::where('is_active', true)->get();
        return view('pages.orders.create', compact('customers', 'laundryItems'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'order_date' => 'required|date',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.laundry_item_id' => 'required|exists:laundry_items,id',
            'items.*.weight' => 'required|numeric|min:0.1',
        ]);

        DB::beginTransaction();
        try {
            // Generate order number
            $orderNumber = 'ORD-' . date('Ymd') . '-' . str_pad(Order::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT);

            // Calculate totals
            $totalWeight = 0;
            $totalPrice = 0;
            $maxEstimatedDays = 0;

            foreach ($validated['items'] as $item) {
                $laundryItem = LaundryItem::find($item['laundry_item_id']);
                $weight = $item['weight'];
                $subtotal = $weight * $laundryItem->price_per_kg;
                
                $totalWeight += $weight;
                $totalPrice += $subtotal;
                $maxEstimatedDays = max($maxEstimatedDays, $laundryItem->estimated_days);
            }

            // Create order
            $order = Order::create([
                'order_number' => $orderNumber,
                'customer_id' => $validated['customer_id'],
                'staff_id' => auth()->user()->staff->id ?? 1,
                'order_date' => $validated['order_date'],
                'estimated_finish_date' => now()->addDays($maxEstimatedDays),
                'status' => 'pending',
                'total_weight' => $totalWeight,
                'total_price' => $totalPrice,
                'notes' => $validated['notes'] ?? null,
            ]);

            // Create order items
            foreach ($validated['items'] as $item) {
                $laundryItem = LaundryItem::find($item['laundry_item_id']);
                $weight = $item['weight'];
                $subtotal = $weight * $laundryItem->price_per_kg;

                OrderItem::create([
                    'order_id' => $order->id,
                    'laundry_item_id' => $item['laundry_item_id'],
                    'weight' => $weight,
                    'price' => $laundryItem->price_per_kg,
                    'subtotal' => $subtotal,
                ]);
            }

            DB::commit();

            return redirect()->route('orders.show', $order)
                ->with('success', 'Pesanan berhasil dibuat');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Gagal membuat pesanan: ' . $e->getMessage());
        }
    }

    public function show(Order $order)
    {
        $order->load(['customer', 'staff', 'orderItems.laundryItem']);
        return view('pages.orders.show', compact('order'));
    }

    public function print(Order $order)
    {
        $order->load(['customer', 'staff', 'orderItems.laundryItem']);
        return view('pages.orders.print', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,ready,completed,cancelled',
        ]);

        $order->update([
            'status' => $validated['status'],
            'actual_finish_date' => in_array($validated['status'], ['ready', 'completed']) ? now() : null,
        ]);

        return back()->with('success', 'Status pesanan berhasil diupdate');
    }

    public function addPayment(Request $request, Order $order)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);

        $newPaidAmount = $order->paid_amount + $validated['amount'];
        
        if ($newPaidAmount > $order->total_price) {
            return back()->with('error', 'Jumlah pembayaran melebihi total harga');
        }

        $paymentStatus = 'unpaid';
        if ($newPaidAmount >= $order->total_price) {
            $paymentStatus = 'paid';
        } elseif ($newPaidAmount > 0) {
            $paymentStatus = 'partial';
        }

        $order->update([
            'paid_amount' => $newPaidAmount,
            'payment_status' => $paymentStatus,
        ]);

        return back()->with('success', 'Pembayaran berhasil ditambahkan');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')
            ->with('success', 'Pesanan berhasil dihapus');
    }
}

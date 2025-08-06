<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('items');

        // Search logic from your Vue.js component
        if ($search = $request->input('search')) {
            $query->where('id', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%");
        }

        // Sort logic
        $sortBy = $request->input('sort_by', 'newest');
        if ($sortBy === 'status') {
            $query->orderByRaw("FIELD(status, 'Dipesan', 'Disiapkan', 'Dikirim', 'Selesai', 'Dibatalkan')");
        } else {
            $query->latest(); // 'newest' sort
        }

        $orders = $query->paginate(10); // Paginate the orders

        return view('admin.orders', compact('orders', 'search', 'sortBy'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:Dipesan,Disiapkan,Dikirim,Selesai,Dibatalkan',
        ]);

        $order->update($validated);

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with(['customer', 'orderItems.sparePart'])->latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:menunggu_pembayaran,diproses,selesai,dibatalkan'
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->status;

        if ($oldStatus !== 'dibatalkan' && $newStatus === 'dibatalkan') {
            // Restore stock if cancelled
            foreach ($order->orderItems as $item) {
                if ($item->sparePart) {
                    $item->sparePart->increment('stock', $item->qty);
                }
            }
        } elseif ($oldStatus === 'dibatalkan' && $newStatus !== 'dibatalkan') {
            // Deduct stock again if un-cancelled
            foreach ($order->orderItems as $item) {
                if ($item->sparePart) {
                    $item->sparePart->decrement('stock', $item->qty);
                }
            }
        }

        $order->update(['status' => $newStatus]);

        return redirect()->route('admin.orders.index')->with('success', 'Status pesanan berhasil diperbarui.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\ServiceTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminBookingController extends Controller
{
    /**
     * Tampilkan daftar booking masuk.
     */
    public function index()
    {
        $bookings = Booking::with(['customer', 'vehicle'])->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Update status booking.
     */
    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => ['required', 'in:disetujui,ditolak,dikonversi']
        ]);

        $booking->update(['status' => $request->status]);

        if ($request->status === 'dikonversi') {
            // Konversi menjadi Service Transaction
            $transaction = ServiceTransaction::create([
                'vehicle_id' => $booking->vehicle_id,
                'user_id' => Auth::id(),
                'type' => 'regular',
                'complaint' => $booking->complaint,
                'status' => 'menunggu',
                'cost' => 0,
                'transaction_date' => $booking->preferred_date,
            ]);

            $booking->update(['service_transaction_id' => $transaction->id]);

            return redirect()->route('transactions.edit', $transaction->id)->with('success', 'Booking berhasil dikonversi menjadi transaksi servis.');
        }

        return back()->with('success', 'Status booking berhasil diperbarui.');
    }
}

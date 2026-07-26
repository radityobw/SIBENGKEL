<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\ServiceTransaction;
use App\Notifications\SystemNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminBookingController extends Controller
{
    /**
     * Tampilkan daftar booking masuk.
     */
    public function index()
    {
        $bookings = Booking::with(['customer', 'vehicle', 'transaction'])->orderBy('created_at', 'desc')->paginate(15);
        $mechanics = \App\Models\Mechanic::all();
        return view('admin.bookings.index', compact('bookings', 'mechanics'));
    }

    /**
     * Update status booking.
     */
    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => ['required', 'in:disetujui,ditolak'],
            'mechanic_id' => ['required_if:status,disetujui', 'nullable', 'exists:mechanics,id'],
            'cost' => ['required_if:status,disetujui', 'nullable', 'numeric', 'min:0'],
        ]);

        $booking->update(['status' => $request->status]);
        
        $customer = $booking->customer;
        if ($customer) {
            $statusText = $request->status === 'disetujui' ? 'disetujui dan masuk antrean servis' : 'ditolak';
            $plateNumber = $booking->vehicle->plate_number ?? null;

            // Arahkan ke halaman cek status dengan nomor polisi sudah terisi
            $statusUrl = $plateNumber
                ? route('public.status.search', ['search_type' => 'nopol', 'search_query' => $plateNumber])
                : route('public.status.index');

            $customer->notify(new SystemNotification(
                'Status Booking Diperbarui', 
                "Booking servis Anda untuk {$booking->preferred_date} telah {$statusText}. Pantau progres servis kendaraan Anda sekarang.",
                $statusUrl
            ));
        }

        if ($request->status === 'disetujui') {
            // Konversi menjadi Service Transaction
            $transaction = ServiceTransaction::create([
                'vehicle_id' => $booking->vehicle_id,
                'user_id' => Auth::id(),
                'mechanic_id' => $request->mechanic_id,
                'type' => 'servis',
                'complaint' => $booking->complaint,
                'status' => 'pending',
                'cost' => $request->cost ?? 0,
                'transaction_date' => $booking->preferred_date,
            ]);

            $booking->update(['service_transaction_id' => $transaction->id]);

            return redirect()->route('transactions.index')->with('success', 'Booking berhasil disetujui dan otomatis masuk ke Transaksi Servis.');
        }

        return back()->with('success', 'Status booking berhasil diperbarui.');
    }
}

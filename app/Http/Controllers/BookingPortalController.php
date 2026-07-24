<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Vehicle;
use App\Models\User;
use App\Notifications\SystemNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingPortalController extends Controller
{
    /**
     * Tampilkan dashboard pelanggan.
     */
    public function dashboard()
    {
        $customer = Auth::guard('customer')->user();
        $vehicles = $customer->vehicles;
        $bookings = $customer->bookings()->orderBy('created_at', 'desc')->get();
        
        return view('public.dashboard', compact('customer', 'vehicles', 'bookings'));
    }

    /**
     * Tampilkan form booking servis.
     */
    public function showBookingForm()
    {
        $vehicles = Auth::guard('customer')->user()->vehicles;
        return view('public.booking.form', compact('vehicles'));
    }

    /**
     * Proses pengajuan booking servis.
     */
    public function submitBooking(Request $request)
    {
        $request->validate([
            'vehicle_id' => ['required', 'exists:vehicles,id'],
            'preferred_date' => ['required', 'date', 'after_or_equal:today'],
            'preferred_time' => ['required', 'date_format:H:i'],
            'complaint' => ['required', 'string'],
        ]);

        // Verifikasi kepemilikan kendaraan
        $vehicle = Vehicle::findOrFail($request->vehicle_id);
        if ($vehicle->customer_id !== Auth::guard('customer')->id()) {
            abort(403);
        }

        Booking::create([
            'customer_id' => Auth::guard('customer')->id(),
            'vehicle_id' => $request->vehicle_id,
            'preferred_date' => $request->preferred_date,
            'preferred_time' => $request->preferred_time,
            'complaint' => $request->complaint,
            'status' => 'menunggu_konfirmasi',
        ]);

        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new SystemNotification(
                'Booking Baru Masuk',
                Auth::guard('customer')->user()->name . ' telah mengajukan booking servis baru.',
                route('admin.bookings.index')
            ));
        }

        return redirect()->route('public.dashboard')->with('success', 'Booking berhasil diajukan dan sedang menunggu konfirmasi bengkel.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\ServiceTransaction;
use App\Models\Vehicle;
use App\Models\Customer;
use Illuminate\Http\Request;

class PublicStatusController extends Controller
{
    /**
     * Tampilkan halaman form pencarian status.
     */
    public function index()
    {
        return view('public.cek-status');
    }

    /**
     * Proses pencarian berdasarkan plat nomor atau nomor telepon.
     */
    public function search(Request $request)
    {
        $request->validate([
            'search_type' => 'required|in:nopol,notelp',
            'search_query' => 'required|string|max:50',
        ]);

        $type = $request->search_type;
        $query = $request->search_query;

        $transaction = null;

        if ($type === 'nopol') {
            // Hilangkan spasi dan jadikan kapital untuk pencarian yang lebih toleran
            $nopolClean = str_replace(' ', '', strtoupper($query));
            
            $transaction = ServiceTransaction::whereHas('vehicle', function($q) use ($nopolClean) {
                // Filter menggunakan DB raw untuk membuang spasi juga, atau gunakan like
                $q->whereRaw("REPLACE(UPPER(plate_number), ' ', '') = ?", [$nopolClean]);
            })->orderBy('created_at', 'desc')->first();

        } else if ($type === 'notelp') {
            $notelpClean = preg_replace('/[^0-9]/', '', $query);

            $transaction = ServiceTransaction::whereHas('vehicle.customer', function($q) use ($notelpClean) {
                $q->where('phone', 'like', "%{$notelpClean}%");
            })->orderBy('created_at', 'desc')->first();
        }

        if ($transaction) {
            return redirect()->route('public.status.result', $transaction->id);
        }

        return back()->with('error', 'Data servis kendaraan tidak ditemukan. Pastikan nomor yang dimasukkan sudah benar.');
    }

    /**
     * Tampilkan halaman hasil status berdasarkan ID transaksi.
     * Catatan: Karena ini halaman publik, seharusnya tidak mengekspos ID mentah,
     * tetapi untuk kesederhanaan prototipe, kita gunakan ID atau UUID.
     * Untuk keamanan, kita juga bisa menambahkan validasi bahwa transaksi masih aktif/baru.
     */
    public function result($id)
    {
        $transaction = ServiceTransaction::with(['vehicle.customer', 'mechanic'])->findOrFail($id);
        return view('public.status-result', compact('transaction'));
    }
}

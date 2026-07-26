<?php

namespace App\Http\Controllers;

use App\Models\ServiceTransaction;
use App\Models\Vehicle;
use App\Models\Mechanic;
use Illuminate\Http\Request;

class TransactionController extends Controller {
    public function index(Request $request) {
        $status = $request->query('status');
        $transactions = ServiceTransaction::with(['vehicle.customer', 'mechanic', 'user'])
            ->when($status, function($q, $status) {
                return $q->where('status', $status);
            })
            ->latest()
            ->paginate(10);

        return view('transactions.index', compact('transactions', 'status'));
    }

    public function create() {
        $vehicles = Vehicle::with('customer')->get();
        $mechanics = Mechanic::all();
        return view('transactions.create', compact('vehicles', 'mechanics'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'mechanic_id' => 'nullable|exists:mechanics,id',
            'type' => 'required|in:servis,penjualan',
            'complaint' => 'required|string',
            'cost' => 'required|numeric|min:0',
            'status' => 'required|in:pending,proses,selesai',
            'transaction_date' => 'required|date',
        ]);

        $validated['user_id'] = auth()->id();

        ServiceTransaction::create($validated);
        return redirect()->route('transactions.index')->with('success', 'Transaksi Servis baru berhasil dicatat!');
    }

    public function edit(ServiceTransaction $transaction) {
        $vehicles = Vehicle::with('customer')->get();
        $mechanics = Mechanic::all();
        return view('transactions.edit', compact('transaction', 'vehicles', 'mechanics'));
    }

    public function update(Request $request, ServiceTransaction $transaction) {
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'mechanic_id' => 'nullable|exists:mechanics,id',
            'type' => 'required|in:servis,penjualan',
            'complaint' => 'required|string',
            'cost' => 'required|numeric|min:0',
            'status' => 'required|in:pending,proses,selesai',
            'transaction_date' => 'required|date',
        ]);

        $transaction->update($validated);
        return redirect()->route('transactions.index')->with('success', 'Transaksi Servis berhasil diperbarui!');
    }

    public function updateStatus(Request $request, ServiceTransaction $transaction) {
        $validated = $request->validate([
            'status' => 'required|in:pending,proses,selesai',
        ]);

        $transaction->update(['status' => $validated['status']]);
        return redirect()->back()->with('success', 'Status Pengerjaan Servis berhasil diperbarui!');
    }

    public function destroy(ServiceTransaction $transaction) {
        // Hapus booking servis yang terhubung (cascade manual)
        \App\Models\Booking::where('service_transaction_id', $transaction->id)->delete();

        $transaction->delete();
        return redirect()->route('transactions.index')->with('success', 'Transaksi Servis dan booking terkait berhasil dihapus!');
    }

    public function printInvoice(ServiceTransaction $transaction) {
        $transaction->load(['vehicle.customer', 'mechanic', 'user']);
        return view('transactions.invoice', compact('transaction'));
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ServiceTransaction;

class ServiceApiController extends Controller {
    public function index() {
        $services = ServiceTransaction::with(['vehicle.customer', 'mechanic'])->get();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil daftar transaksi servis',
            'data' => $services
        ]);
    }
    public function store(\Illuminate\Http\Request $request) {
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

        $service = ServiceTransaction::create($validated);
        return response()->json([
            'success' => true,
            'message' => 'Transaksi servis baru berhasil dicatat via API',
            'data' => $service
        ], 201);
    }

    public function show(ServiceTransaction $service) {
        $service->load(['vehicle.customer', 'mechanic', 'user']);
        return response()->json([
            'success' => true,
            'message' => 'Detail transaksi servis',
            'data' => $service
        ]);
    }

    public function update(\Illuminate\Http\Request $request, ServiceTransaction $service) {
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'mechanic_id' => 'nullable|exists:mechanics,id',
            'type' => 'required|in:servis,penjualan',
            'complaint' => 'required|string',
            'cost' => 'required|numeric|min:0',
            'status' => 'required|in:pending,proses,selesai',
            'transaction_date' => 'required|date',
        ]);

        $service->update($validated);
        return response()->json([
            'success' => true,
            'message' => 'Berhasil memperbarui transaksi servis',
            'data' => $service
        ]);
    }

    public function updateStatus(\Illuminate\Http\Request $request, ServiceTransaction $service) {
        $validated = $request->validate([
            'status' => 'required|in:pending,proses,selesai',
        ]);

        $service->update(['status' => $validated['status']]);
        return response()->json([
            'success' => true,
            'message' => 'Status pengerjaan servis berhasil diperbarui via API',
            'data' => $service
        ]);
    }

    public function destroy(ServiceTransaction $service) {
        $service->delete();
        return response()->json([
            'success' => true,
            'message' => 'Transaksi servis berhasil dihapus'
        ]);
    }
}

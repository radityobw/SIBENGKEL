<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;

class CustomerApiController extends Controller {
    public function index() {
        $customers = Customer::withCount('vehicles')->get();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil daftar pelanggan',
            'data' => $customers
        ]);
    }
    public function store(\Illuminate\Http\Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'address' => 'nullable|string',
        ]);

        $customer = Customer::create($validated);
        return response()->json([
            'success' => true,
            'message' => 'Berhasil menambah pelanggan baru',
            'data' => $customer
        ], 201);
    }

    public function show(Customer $customer) {
        $customer->load('vehicles');
        return response()->json([
            'success' => true,
            'message' => 'Detail pelanggan',
            'data' => $customer
        ]);
    }

    public function update(\Illuminate\Http\Request $request, Customer $customer) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'address' => 'nullable|string',
        ]);

        $customer->update($validated);
        return response()->json([
            'success' => true,
            'message' => 'Berhasil memperbarui data pelanggan',
            'data' => $customer
        ]);
    }

    public function destroy(Customer $customer) {
        $customer->delete();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil menghapus data pelanggan'
        ]);
    }
}

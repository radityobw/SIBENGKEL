<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleApiController extends Controller {
    public function index() {
        $vehicles = Vehicle::with('customer')->get();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil daftar kendaraan',
            'data' => $vehicles
        ]);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'plate_number' => 'required|string|max:20|unique:vehicles',
            'brand' => 'required|string|max:50',
            'model' => 'required|string|max:100',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
        ]);

        $vehicle = Vehicle::create($validated);
        return response()->json([
            'success' => true,
            'message' => 'Berhasil menambah kendaraan baru',
            'data' => $vehicle
        ], 201);
    }

    public function show(Vehicle $vehicle) {
        $vehicle->load(['customer', 'services']);
        return response()->json([
            'success' => true,
            'message' => 'Detail kendaraan',
            'data' => $vehicle
        ]);
    }

    public function update(Request $request, Vehicle $vehicle) {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'plate_number' => 'required|string|max:20|unique:vehicles,plate_number,' . $vehicle->id,
            'brand' => 'required|string|max:50',
            'model' => 'required|string|max:100',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
        ]);

        $vehicle->update($validated);
        return response()->json([
            'success' => true,
            'message' => 'Berhasil memperbarui data kendaraan',
            'data' => $vehicle
        ]);
    }

    public function destroy(Vehicle $vehicle) {
        $vehicle->delete();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil menghapus data kendaraan'
        ]);
    }
}

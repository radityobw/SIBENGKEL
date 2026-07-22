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
}

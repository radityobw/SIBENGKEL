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
}

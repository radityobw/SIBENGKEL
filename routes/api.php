<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\CustomerApiController;
use App\Http\Controllers\Api\ServiceApiController;

use App\Http\Controllers\Api\VehicleApiController;

// Public Endpoint
Route::post('/login', [AuthApiController::class, 'login'])->middleware('throttle:10,1');

// API Endpoint untuk AJAX Polling Status Servis (Real-time tanpa reload)
Route::get('transactions/{id}/status', function ($id) {
    $transaction = \App\Models\ServiceTransaction::find($id);
    if (!$transaction) {
        return response()->json(['error' => 'Not found'], 404);
    }
    return response()->json([
        'status' => $transaction->status,
        'status_label' => ucfirst(str_replace('_', ' ', $transaction->status)),
        'updated_at' => $transaction->updated_at->diffForHumans()
    ]);
})->name('api.transactions.status');

// API Khusus Admin (Bisa digabung dengan Auth Sanctum jika dibutuhkan)
// Authenticated Endpoints (Sanctum Token Protection)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthApiController::class, 'logout']);
    
    Route::apiResource('customers', CustomerApiController::class, ['as' => 'api']);
    Route::apiResource('vehicles', VehicleApiController::class, ['as' => 'api']);
    Route::apiResource('services', ServiceApiController::class, ['as' => 'api']);
    Route::patch('/services/{service}/status', [ServiceApiController::class, 'updateStatus']);
});

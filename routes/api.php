<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\CustomerApiController;
use App\Http\Controllers\Api\ServiceApiController;

use App\Http\Controllers\Api\VehicleApiController;

// Public Endpoint
Route::post('/login', [AuthApiController::class, 'login']);

// Authenticated Endpoints (Sanctum Token Protection)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthApiController::class, 'logout']);
    
    Route::apiResource('customers', CustomerApiController::class);
    Route::apiResource('vehicles', VehicleApiController::class);
    Route::apiResource('services', ServiceApiController::class);
    Route::patch('/services/{service}/status', [ServiceApiController::class, 'updateStatus']);
});

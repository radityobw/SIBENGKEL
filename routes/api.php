<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\CustomerApiController;
use App\Http\Controllers\Api\ServiceApiController;

// Public Endpoint
Route::post('/login', [AuthApiController::class, 'login']);

// Authenticated Endpoints (Sanctum Token Protection)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthApiController::class, 'logout']);
    Route::get('/customers', [CustomerApiController::class, 'index']);
    Route::get('/services', [ServiceApiController::class, 'index']);
});

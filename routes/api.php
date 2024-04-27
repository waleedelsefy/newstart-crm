<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ExternalLeadController;
use App\Http\Controllers\Api\BranchController;

// Routes for Branches
Route::prefix('branches')->group(function () {
    Route::get('', [BranchController::class, 'index']);
    Route::get('{id}', [BranchController::class, 'show']);
    Route::post('', [BranchController::class, 'store']);
    Route::put('{id}', [BranchController::class, 'update']);
    Route::delete('{id}', [BranchController::class, 'destroy']);
});

// Other API routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

// External Lead Controller Route
Route::post('/external-lead', [ExternalLeadController::class, 'store']);

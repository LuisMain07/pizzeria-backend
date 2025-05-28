<?php

use App\Http\Controllers\api\SupplierController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();    
});

Route::get('/supplier', [SupplierController::class, 'index'])->name('suppliers');
Route::post('/supplier', [SupplierController::class, 'store'])->name('suppliers.store');
Route::delete('/supplier/{supplier}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');
Route::get('/supplier/{supplier}', [SupplierController::class, 'show'])->name('suppliers.show');
Route::put('/supplier/{supplier}', [SupplierController::class, 'update'])->name('suppliers.update');
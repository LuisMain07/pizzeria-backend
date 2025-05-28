<?php

use App\Http\Controllers\api\SupplierController;
use App\Http\Controllers\api\RawMaterialsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();    
});

//Suppliers
Route::get('/supplier', [SupplierController::class, 'index'])->name('suppliers');
Route::post('/supplier', [SupplierController::class, 'store'])->name('suppliers.store');
Route::delete('/supplier/{supplier}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');
Route::get('/supplier/{supplier}', [SupplierController::class, 'show'])->name('suppliers.show');
Route::put('/supplier/{supplier}', [SupplierController::class, 'update'])->name('suppliers.update');

//RawMaterials
Route::get('/raw-material', [RawMaterialsController::class, 'index'])->name('raw-materials');
Route::post('/raw-material', [RawMaterialsController::class, 'store'])->name('raw-materials.store');
Route::delete('/raw-material/{rawMaterial}', [RawMaterialsController::class, 'destroy'])->name('raw-materials.destroy');
Route::get('/raw-material/{rawMaterial}', [RawMaterialsController::class, 'show'])->name('raw-materials.show');
Route::put('/raw-material/{rawMaterial}', [RawMaterialsController::class, 'update'])->name('raw-materials.update');
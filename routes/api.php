<?php

use App\Http\Controllers\api\SupplierController;
use App\Http\Controllers\api\RawMaterialsController;
use App\Http\Controllers\api\PizzaRawMaterialController;
use App\Http\Controllers\api\PurchaseController;
use App\Http\Controllers\api\UserController;
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

//Purchases
Route::get('/purchase', [PurchaseController::class, 'index'])->name('purchases');
Route::post('/purchase', [PurchaseController::class, 'store'])->name('purchases.store');
Route::delete('/purchase/{purchase}', [PurchaseController::class, 'destroy'])->name('purchases.destroy');
Route::get('/purchase/{purchase}', [PurchaseController::class, 'show'])->name('purchases.show');
Route::put('/purchase/{purchase}', [PurchaseController::class, 'update'])->name('purchases.update');

//PizzaRawMaterial
Route::get('/pizza-raw-material', [PizzaRawMaterialController::class, 'index'])->name('pizza-raw-materials');
Route::post('/pizza-raw-material', [PizzaRawMaterialController::class, 'store'])->name('pizza-raw-materials.store');
Route::delete('/pizza-raw-material/{pizzaRawMaterial}', [PizzaRawMaterialController::class, 'destroy'])->name('pizza-raw-materials.destroy');
Route::get('/pizza-raw-material/{pizzaRawMaterial}', [PizzaRawMaterialController::class, 'show'])->name('pizza-raw-materials.show');
Route::put('/pizza-raw-material/{pizzaRawMaterial}', [PizzaRawMaterialController::class, 'update'])->name('pizza-raw-materials.update');

//User
Route::get('/user', [UserController::class, 'index'])->name('users');
Route::post('/user', [UserController::class, 'store'])->name('users.store');
Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('users.destroy');
Route::get('/user/{user}', [UserController::class, 'show'])->name('users.show');
Route::put('/user/{user}', [UserController::class, 'update'])->name('users.update');


<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\IngredientController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ExtraIngredientController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rutas para Pizza_Ingredients
Route::get('pizza-ingredients', [PizzaIngredientController::class, 'index']);
Route::post('pizza-ingredients', [PizzaIngredientController::class, 'store']);
Route::get('pizza-ingredients/{id}', [PizzaIngredientController::class, 'show']);
Route::put('pizza-ingredients/{id}', [PizzaIngredientController::class, 'update']);
Route::delete('pizza-ingredients/{id}', [PizzaIngredientController::class, 'destroy']);

// Rutas para Orders
Route::get('orders', [OrderController::class, 'index']);           
Route::post('orders', [OrderController::class, 'store']);          
Route::get('orders/{id}', [OrderController::class, 'show']);       
Route::put('orders/{id}', [OrderController::class, 'update']);     
Route::patch('orders/{id}', [OrderController::class, 'update']);   
Route::delete('orders/{id}', [OrderController::class, 'destroy']); 

// Rutas para Extra Ingredients
Route::get('extra-ingredients', [ExtraIngredientController::class, 'index']);          
Route::post('extra-ingredients', [ExtraIngredientController::class, 'store']);          
Route::get('extra-ingredients/{id}', [ExtraIngredientController::class, 'show']);       
Route::put('extra-ingredients/{id}', [ExtraIngredientController::class, 'update']);    
Route::patch('extra-ingredients/{id}', [ExtraIngredientController::class, 'update']);  
Route::delete('extra-ingredients/{id}', [ExtraIngredientController::class, 'destroy']); 
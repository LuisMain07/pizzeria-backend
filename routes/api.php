<?php

use App\Http\Controllers\api\PizzasController;
use App\Http\Controllers\api\PizzasSizeController;
use App\Http\Controllers\api\IngredientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// ruta de pizzas
Route::apiResource('pizzas', PizzasController::class);

// ruta de tamaños de pizzas
Route::apiResource('pizzas_sizes', PizzasSizeController::class);

// ruta de ingredientes
Route::apiResource('ingredients', IngredientController::class);



<?php

use App\Http\Controllers\api\PizzasController;
use App\Http\Controllers\api\PizzasSizeController;
use App\Http\Controllers\api\IngredientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// === RUTAS MÓDULO PIZZAS ===
Route::apiResource('pizzas', PizzasController::class);

// === RUTAS MÓDULO TAMAÑOS DE PIZZAS ===
Route::apiResource('pizzas_sizes', PizzasSizeController::class);

// === RUTAS MÓDULO INGREDIENTES ===
Route::apiResource('ingredients', IngredientController::class);

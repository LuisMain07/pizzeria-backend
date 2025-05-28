<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\PizzasController;
use App\Http\Controllers\api\PizzasSizeController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// ruta de pizzas
Route::apiResource('pizzas', PizzasController::class);

// ruta de tamaños de pizzas
Route::apiResource('pizzas_sizes', PizzasSizeController::class);


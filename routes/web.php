<?php

use App\Http\Controllers\IngredientController;
use App\Http\Controllers\BrancheController;
use App\Http\Controllers\Extra_ingredientController;
use App\Http\Controllers\Order_extra_ingredientController;
use App\Http\Controllers\Order_pizzaController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Pizza_ingredientController;
use App\Http\Controllers\Pizza_raw_materialController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\Raw_materialController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PizzasController; 
use App\Http\Controllers\Pizzas_sizeController; 
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/* Ejemplo para uso de rutas

    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    });

*/

Route::middleware('auth')->group(function () {

//Ingredient

Route::get('/ingredients', [IngredientController::class, 'index'])->name('ingredients.index');
Route::post('/ingredients', [IngredientController::class, 'store'])->name('ingredients.store');
Route::get('/ingredients/create', [IngredientController::class, 'create'])->name('ingredients.create');
Route::delete('/ingredients/{ingredient}', [IngredientController::class, 'destroy'])->name('ingredients.destroy');
Route::put('/ingredients/{ingredient}', [IngredientController::class, 'update'])->name('ingredients.update');
Route::get('/ingredients/{ingredient}/edit', [IngredientController::class, 'edit'])->name('ingredients.edit');

//Pizza_ingredient

Route::get('/pizza_ingredients', [Pizza_ingredientController::class, 'index'])->name('pizza_ingredients.index');
Route::post('/pizza_ingredients', [Pizza_ingredientController::class, 'store'])->name('pizza_ingredients.store');
Route::get('/pizza_ingredients/create', [Pizza_ingredientController::class, 'create'])->name('pizza_ingredients.create');
Route::delete('/pizza_ingredients/{pizza_ingredient}', [Pizza_ingredientController::class, 'destroy'])->name('pizza_ingredients.destroy');
Route::put('/pizza_ingredients/{pizza_ingredient}', [Pizza_ingredientController::class, 'update'])->name('pizza_ingredients.update');
Route::get('/pizza_ingredients/{pizza_ingredient}/edit', [Pizza_ingredientController::class, 'edit'])->name('pizza_ingredients.edit');

//Extra ingredient

Route::get('/extra_ingredients', [Extra_ingredientController::class, 'index'])->name('extra_ingredients.index');
Route::post('/extra_ingredients', [Extra_ingredientController::class, 'store'])->name('extra_ingredients.store');
Route::get('/extra_ingredients/create', [Extra_ingredientController::class, 'create'])->name('extra_ingredients.create');
Route::delete('/extra_ingredients/{extra_ingredient}', [Extra_ingredientController::class, 'destroy'])->name('extra_ingredients.destroy');
Route::put('/extra_ingredients/{extra_ingredient}', [Extra_ingredientController::class, 'update'])->name('extra_ingredients.update');
Route::get('/extra_ingredients/{extra_ingredient}/edit', [Extra_ingredientController::class, 'edit'])->name('extra_ingredients.edit');

//Order

Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
Route::put('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
Route::get('/orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');

//order pizza

Route::get('/orders_pizza', [Order_pizzaController::class, 'index'])->name('orders_pizza.index');
Route::post('/orders_pizza', [Order_pizzaController::class, 'store'])->name('orders_pizza.store');
Route::get('/orders_pizza/create', [Order_pizzaController::class, 'create'])->name('orders_pizza.create');
Route::delete('/orders_pizza/{order_pizza}', [Order_pizzaController::class, 'destroy'])->name('orders_pizza.destroy');
Route::put('/orders_pizza/{order_pizza}', [Order_pizzaController::class, 'update'])->name('orders_pizza.update');
Route::get('/orders_pizza/{order_pizza}/edit', [Order_pizzaController::class, 'edit'])->name('orders_pizza.edit');

//order_extra_ingredient

Route::get('/order_extra_ingredients', [Order_extra_ingredientController::class, 'index'])->name('order_extra_ingredients.index');
Route::post('/order_extra_ingredients', [Order_extra_ingredientController::class, 'store'])->name('order_extra_ingredients.store');
Route::get('/order_extra_ingredients/create', [Order_extra_ingredientController::class, 'create'])->name('order_extra_ingredients.create');
Route::delete('/order_extra_ingredients/{order_extra_ingredient}', [Order_extra_ingredientController::class, 'destroy'])->name('order_extra_ingredients.destroy');
Route::put('/order_extra_ingredients/{order_extra_ingredient}', [Order_extra_ingredientController::class, 'update'])->name('order_extra_ingredients.update');
Route::get('/order_extra_ingredients/{order_extra_ingredient}/edit', [Order_extra_ingredientController::class, 'edit'])->name('order_extra_ingredients.edit');

// branches

Route::get('/branches', [BrancheController::class, 'index'])->name('branches.index');
Route::post('/branches', [BrancheController::class, 'store'])->name('branches.store');
Route::get('/branches/create', [BrancheController::class, 'create'])->name('branches.create');
Route::delete('/branches/{branche}', [BrancheController::class, 'destroy'])->name('branches.destroy');
Route::put('/branches/{branche}', [BrancheController::class, 'update'])->name('branches.update');
Route::get('/branches/{branche}/edit', [BrancheController::class, 'edit'])->name('branches.edit');

// suppliers

Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
Route::post('/suppliers', [SupplierController::class, 'store'])->name('suppliers.store');
Route::get('/suppliers/create', [SupplierController::class, 'create'])->name('suppliers.create');
Route::delete('/suppliers/{supplier}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');
Route::put('/suppliers/{supplier}', [SupplierController::class, 'update'])->name('suppliers.update');
Route::get('/suppliers/{supplier}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit');

// raw_materials

Route::get('/raw_materials', [Raw_materialController::class, 'index'])->name('raw_materials.index');
Route::post('/raw_materials', [Raw_materialController::class, 'store'])->name('raw_materials.store');
Route::get('/raw_materials/create', [Raw_materialController::class, 'create'])->name('raw_materials.create');
Route::delete('/raw_materials/{raw_material}', [Raw_materialController::class, 'destroy'])->name('raw_materials.destroy');
Route::put('/raw_materials/{raw_material}', [Raw_materialController::class, 'update'])->name('raw_materials.update');
Route::get('/raw_materials/{raw_material}/edit', [Raw_materialController::class, 'edit'])->name('raw_materials.edit');

// purchases

Route::get('/purchases', [PurchaseController::class, 'index'])->name('purchases.index');
Route::post('/purchases', [PurchaseController::class, 'store'])->name('purchases.store');
Route::get('/purchases/create', [PurchaseController::class, 'create'])->name('purchases.create');
Route::delete('/purchases/{purchase}', [PurchaseController::class, 'destroy'])->name('purchases.destroy');
Route::put('/purchases/{purchase}', [PurchaseController::class, 'update'])->name('purchases.update');
Route::get('/purchases/{purchase}/edit', [PurchaseController::class, 'edit'])->name('purchases.edit');

// pizza_raw_material

Route::get('/pizza_raw_materials', [Pizza_raw_materialController::class, 'index'])->name('pizza_raw_materials.index');
Route::post('/pizza_raw_materials', [Pizza_raw_materialController::class, 'store'])->name('pizza_raw_materials.store');
Route::get('/pizza_raw_materials/create', [Pizza_raw_materialController::class, 'create'])->name('pizza_raw_materials.create');
Route::delete('/pizza_raw_materials/{pizza_raw_material}', [Pizza_raw_materialController::class, 'destroy'])->name('pizza_raw_materials.destroy');
Route::put('/pizza_raw_materials/{pizza_raw_material}', [Pizza_raw_materialController::class, 'update'])->name('pizza_raw_materials.update');
Route::get('/pizza_raw_materials/{pizza_raw_material}/edit', [Pizza_raw_materialController::class, 'edit'])->name('pizza_raw_materials.edit');

// pizzas

Route::get('/pizzas', [PizzasController::class, 'index'])->name('pizzas.index');
Route::post('/pizzas', [PizzasController::class, 'store'])->name('pizzas.store');
Route::get('/pizzas/create', [PizzasController::class, 'create'])->name('pizzas.create');
Route::delete('/pizzas/{pizza}', [PizzasController::class, 'destroy'])->name('pizzas.destroy');
Route::put('/pizzas/{pizza}', [PizzasController::class, 'update'])->name('pizzas.update');
Route::get('/pizzas/{pizza}/edit', [PizzasController::class, 'edit'])->name('pizzas.edit');


//pizzas_sizes
Route::get('/pizzas_sizes', [Pizzas_sizeController::class, 'index'])->name('pizzas_sizes.index');
Route::post('/pizzas_sizes', [Pizzas_sizeController::class, 'store'])->name('pizzas_sizes.store');
Route::get('/pizzas_sizes/create', [Pizzas_sizeController::class, 'create'])->name('pizzas_sizes.create');
Route::delete('/pizzas_sizes/{pizzas_size}', [Pizzas_sizeController::class, 'destroy'])->name('pizzas_sizes.destroy');
Route::put('/pizzas_sizes/{pizzas_size}', [Pizzas_sizeController::class, 'update'])->name('pizzas_sizes.update');
Route::get('/pizzas_sizes/{pizzas_size}/edit', [Pizzas_sizeController::class, 'edit'])->name('pizzas_sizes.edit');

// clients
Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');
Route::get('/clients/create', [ClientController::class, 'create'])->name('clients.create');
Route::delete('/clients/{client}', [ClientController::class, 'destroy'])->name('clients.destroy');
Route::put('/clients/{client}', [ClientController::class, 'update'])->name('clients.update');
Route::get('/clients/{client}/edit', [ClientController::class, 'edit'])->name('clients.edit');

// employees
Route::get('/employees', [EmployeesController::class, 'index'])->name('employees.index');
Route::post('/employees', [EmployeesController::class, 'store'])->name('employees.store');
Route::get('/employees/create', [EmployeesController::class, 'create'])->name('employees.create');
Route::delete('/employees/{employee}', [EmployeesController::class, 'destroy'])->name('employees.destroy');
Route::put('/employees/{employee}', [EmployeesController::class, 'update'])->name('employees.update');  
Route::get('/employees/{employee}/edit', [EmployeesController::class, 'edit'])->name('employees.edit');

//User
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');

});

require __DIR__.'/auth.php';

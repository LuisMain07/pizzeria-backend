<?php


use App\Http\Controllers\api\PizzasController;
use App\Http\Controllers\api\PizzasSizeController;
use App\Http\Controllers\api\IngredientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// routes/api.php - VERSIÓN COMPLETA CON TODOS TUS CONTROLADORES


use App\Http\Controllers\api\SupplierController;
use App\Http\Controllers\api\RawMaterialsController;
use App\Http\Controllers\api\PizzaRawMaterialController;
use App\Http\Controllers\api\PurchaseController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\ClienteController;
use App\Http\Controllers\api\EmployeesController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrancheController;
use App\Http\Controllers\Order_pizzaController;
use App\Http\Controllers\Order_extra_ingredientController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// ruta de pizzas
Route::apiResource('pizzas', PizzasController::class);

// ruta de tamaños de pizzas
Route::apiResource('pizzas_sizes', PizzasSizeController::class);

// ruta de ingredientes
Route::apiResource('ingredients', IngredientController::class);
=======

// ========== RUTAS PARA SUCURSALES ==========
Route::apiResource('branches', BrancheController::class);

// Rutas adicionales para trabajo en equipo
Route::get('branches/{id}/orders', [BrancheController::class, 'getOrders']);
Route::get('branches/{id}/stats', [BrancheController::class, 'getStats']);

// Ruta para mantener funcionalidad web (opcional)
Route::get('branches-web', [BrancheController::class, 'webIndex']);

// ========== RUTAS PARA ÓRDENES DE PIZZA ==========
Route::apiResource('orders-pizza', Order_pizzaController::class);

// Rutas adicionales para órdenes de pizza
Route::get('orders-pizza-create-data', [Order_pizzaController::class, 'create']);
Route::get('orders-pizza/{id}/edit-data', [Order_pizzaController::class, 'edit']);
Route::get('orders/{orderId}/pizzas', [Order_pizzaController::class, 'getByOrder']);
Route::get('orders-pizza-stats', [Order_pizzaController::class, 'getStats']);

// Mantener funcionalidad web (opcional)
Route::get('orders-pizza-web', [Order_pizzaController::class, 'webIndex']);

// ========== RUTAS PARA INGREDIENTES EXTRA DE ÓRDENES ==========
Route::apiResource('order-extra-ingredients', Order_extra_ingredientController::class);

// Rutas adicionales para ingredientes extra
Route::get('order-extra-ingredients-create-data', [Order_extra_ingredientController::class, 'create']);
Route::get('order-extra-ingredients/{id}/edit-data', [Order_extra_ingredientController::class, 'edit']);
Route::get('orders/{orderId}/extra-ingredients', [Order_extra_ingredientController::class, 'getByOrder']);
Route::get('ingredients/{ingredientId}/orders', [Order_extra_ingredientController::class, 'getByIngredient']);
Route::get('order-extra-ingredients-stats', [Order_extra_ingredientController::class, 'getStats']);
Route::get('orders/{orderId}/extra-ingredients-total', [Order_extra_ingredientController::class, 'calculateOrderTotal']);

// Mantener funcionalidad web (opcional)
Route::get('order-extra-ingredients-web', [Order_extra_ingredientController::class, 'webIndex']);

// ========== RUTA DE PRUEBA COMPLETA ==========
Route::get('/test', function () {
    return response()->json([
        'success' => true,
        'message' => 'API de Pizzería funcionando correctamente - TU PARTE COMPLETA',
        'timestamp' => now(),
        'team_member' => 'Tu implementación',
        'status' => 'BACKEND COMPLETO',

        'your_tables' => [
            'branches - Sucursales',
            'orders_pizza - Relación órdenes-pizzas',
            'order_extra_ingredient - Relación órdenes-ingredientes'
        ],

        'available_endpoints' => [
            // === SUCURSALES ===
            'BRANCHES' => [
                'GET /api/branches - Listar todas las sucursales',
                'POST /api/branches - Crear nueva sucursal',
                'GET /api/branches/{id} - Ver sucursal específica',
                'PUT /api/branches/{id} - Actualizar sucursal',
                'DELETE /api/branches/{id} - Eliminar sucursal',
                'GET /api/branches/{id}/orders - Órdenes de la sucursal',
                'GET /api/branches/{id}/stats - Estadísticas de sucursal'
            ],

            // === ÓRDENES DE PIZZA ===
            'ORDERS_PIZZA' => [
                'GET /api/orders-pizza - Listar órdenes de pizza',
                'POST /api/orders-pizza - Crear orden de pizza',
                'GET /api/orders-pizza/{id} - Ver orden específica',
                'PUT /api/orders-pizza/{id} - Actualizar orden',
                'DELETE /api/orders-pizza/{id} - Eliminar orden',
                'GET /api/orders-pizza-create-data - Datos para crear',
                'GET /api/orders/{orderId}/pizzas - Pizzas por orden',
                'GET /api/orders-pizza-stats - Estadísticas'
            ],

            // === INGREDIENTES EXTRA ===
            'ORDER_EXTRA_INGREDIENTS' => [
                'GET /api/order-extra-ingredients - Listar ingredientes extra',
                'POST /api/order-extra-ingredients - Agregar ingrediente',
                'GET /api/order-extra-ingredients/{id} - Ver específico',
                'PUT /api/order-extra-ingredients/{id} - Actualizar',
                'DELETE /api/order-extra-ingredients/{id} - Eliminar',
                'GET /api/orders/{orderId}/extra-ingredients - Por orden',
                'GET /api/order-extra-ingredients-stats - Estadísticas',
                'GET /api/orders/{orderId}/extra-ingredients-total - Calcular total'
            ]
        ],

        'teammates_pending' => [
            'Compañero 1: orders (órdenes principales)',
            'Compañero 2: pizzas + pizza_size (pizzas y tamaños)',
            'Compañero 3: extra_ingredients (ingredientes disponibles)'
        ],

        'integration_ready' => true,
        'smart_features' => [
            'Joins inteligentes - funcionan si existen las tablas de compañeros',
            'Validaciones FK - se activan cuando las tablas estén disponibles',
            'Respuestas consistentes - formato JSON estándar',
            'Manejo de errores - try/catch en todos los métodos'
        ],

        'next_steps' => [
            '1. Probar todos los endpoints con Postman/Thunder Client',
            '2. Crear Frontend Vue.js para consumir esta API',
            '3. Coordinar con compañeros para integración final'
        ]
    ]);
});

// ========== INFORMACIÓN PARA COMPAÑEROS ==========
Route::get('/team-info', function () {
    return response()->json([
        'message' => 'Información para compañeros de equipo',
        'implemented_by' => 'Tu nombre aquí',
        'completion_status' => 'BACKEND COMPLETO',

        'database_tables_ready' => [
            'branches' => [
                'fields' => ['id', 'name', 'address', 'created_at', 'updated_at'],
                'relationships' => 'Tiene relación con orders (cuando se implemente)'
            ],
            'orders_pizza' => [
                'fields' => ['id', 'order_id', 'pizza_size_id', 'quantity', 'created_at', 'updated_at'],
                'relationships' => 'Espera: orders.id y pizza_size.id'
            ],
            'order_extra_ingredient' => [
                'fields' => ['id', 'order_id', 'extra_ingredient_id', 'quantity', 'created_at', 'updated_at'],
                'relationships' => 'Espera: orders.id y extra_ingredients.id'
            ]
        ],

        'api_contracts_for_teammates' => [
            'orders_table_needed' => [
                'fields_expected' => ['id', 'branch_id', 'customer_name', 'customer_phone', 'total_price', 'status', 'delivery_type', 'notes'],
                'status_values' => ['pendiente', 'en_preparacion', 'listo', 'entregado'],
                'delivery_type_values' => ['en_local', 'a_domicilio']
            ],
            'pizzas_table_needed' => [
                'fields_expected' => ['id', 'name', 'description']
            ],
            'pizza_size_table_needed' => [
                'fields_expected' => ['id', 'pizza_id', 'size', 'price'],
                'size_values' => ['pequeña', 'mediana', 'grande']
            ],
            'extra_ingredients_table_needed' => [
                'fields_expected' => ['id', 'name', 'price']
            ]
        ],

        'integration_points' => [
            'When orders table exists: All JOIN queries will work automatically',
            'When pizza tables exist: Pizza size and names will display in API responses',
            'When extra_ingredients exists: Ingredient names and prices will show',
            'Foreign key validations will activate automatically'
        ]
    ]);
});

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

//Cliente
Route::get('/client', [ClienteController::class, 'index'])->name('clients');
Route::post('/client', [ClienteController::class, 'store'])->name('clients.store');
Route::delete('/client/{client}', [ClienteController::class, 'destroy'])->name('clients.destroy');
Route::get('/client/{client}', [ClienteController::class, 'show'])->name('clients.show');
Route::put('/client/{client}', [ClienteController::class, 'update'])->name('clients.update');

// Employees
Route::get('/employee', [EmployeesController::class, 'index'])->name('employees');
Route::post('/employee', [EmployeesController::class, 'store'])->name('employees.store');
Route::delete('/employee/{employee}', [EmployeesController::class, 'destroy'])->name('employees.destroy');
Route::get('/employee/{employee}', [EmployeesController::class, 'show'])->name('employees.show');
Route::put('/employee/{employee}', [EmployeesController::class, 'update'])->name('employees.update');




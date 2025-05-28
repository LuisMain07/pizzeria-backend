<?php
// routes/api.php - VERSIÓN COMPLETA CON TODOS TUS CONTROLADORES
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrancheController;
use App\Http\Controllers\Order_pizzaController;
use App\Http\Controllers\Order_extra_ingredientController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

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
        'status' => 'BACKEND COMPLETO ✅',

        'your_tables' => [
            'branches - Sucursales ✅',
            'orders_pizza - Relación órdenes-pizzas ✅',
            'order_extra_ingredient - Relación órdenes-ingredientes ✅'
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

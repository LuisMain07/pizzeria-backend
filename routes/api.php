<?php
// routes/api.php - AGREGAR ESTAS RUTAS
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrancheController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// ========== TUS RUTAS DE SUCURSALES ==========
Route::apiResource('branches', BrancheController::class);

// Rutas adicionales para trabajo en equipo
Route::get('branches/{id}/orders', [BrancheController::class, 'getOrders']);
Route::get('branches/{id}/stats', [BrancheController::class, 'getStats']);

// Ruta para mantener funcionalidad web (opcional)
Route::get('branches-web', [BrancheController::class, 'webIndex']);

// ========== RUTA DE PRUEBA ==========
Route::get('/test', function () {
    return response()->json([
        'success' => true,
        'message' => 'API de Pizzería funcionando correctamente',
        'timestamp' => now(),
        'your_endpoints' => [
            'GET /api/branches - Listar sucursales',
            'POST /api/branches - Crear sucursal',
            'GET /api/branches/{id} - Ver sucursal específica',
            'PUT /api/branches/{id} - Actualizar sucursal',
            'DELETE /api/branches/{id} - Eliminar sucursal',
            'GET /api/branches/{id}/orders - Órdenes de sucursal',
            'GET /api/branches/{id}/stats - Estadísticas de sucursal'
        ]
    ]);
});

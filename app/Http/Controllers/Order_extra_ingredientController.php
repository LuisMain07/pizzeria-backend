<?php

namespace App\Http\Controllers;

use App\Models\Order_extra_ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Order_extra_ingredientController extends Controller
{
    /**
     * Display a listing of the resource.
     * CONVERTIDO A API - Mantiene tu lógica de joins
     */
    public function index()
    {
        try {
            // Usar tu consulta existente con joins
            $order_extra_ingredients = DB::table('order_extra_ingredient')
                ->join('orders', 'order_extra_ingredient.order_id', '=', 'orders.id')
                ->join('extra_ingredients', 'order_extra_ingredient.extra_ingredient_id', '=', 'extra_ingredients.id')
                ->select(
                    'order_extra_ingredient.*',
                    'orders.id as order_code',
                    'orders.customer_name',
                    'orders.status as order_status',
                    'orders.total_price as order_total',
                    'extra_ingredients.name as ingredient_name',
                    'extra_ingredients.price as ingredient_price'
                )
                ->orderBy('order_extra_ingredient.id', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $order_extra_ingredients,
                'message' => 'Ingredientes extra de órdenes obtenidos correctamente'
            ]);

        } catch (\Exception $e) {
            // Si las tablas de compañeros no existen, devolver datos básicos
            try {
                $order_extra_ingredients_basic = DB::table('order_extra_ingredient')
                    ->orderBy('id', 'desc')
                    ->get();

                return response()->json([
                    'success' => true,
                    'data' => $order_extra_ingredients_basic,
                    'message' => 'Ingredientes extra obtenidos (vista básica - esperando tablas de compañeros)',
                    'note' => 'Joins completos disponibles cuando compañeros implementen: orders, extra_ingredients'
                ]);
            } catch (\Exception $e2) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al obtener ingredientes extra: ' . $e2->getMessage()
                ], 500);
            }
        }
    }

    /**
     * Get data for creating new order extra ingredient
     * CONVERTIDO A API - Obtiene datos necesarios para formularios
     */
    public function create()
    {
        try {
            $data = [
                'orders' => [],
                'extra_ingredients' => []
            ];

            // Intentar obtener órdenes (tabla de compañero)
            try {
                $data['orders'] = DB::table('orders')
                    ->select('id', 'customer_name', 'status', 'total_price', 'created_at')
                    ->orderBy('id', 'desc')
                    ->get();
            } catch (\Exception $e) {
                $data['orders'] = [];
                $data['orders_note'] = 'Tabla orders no disponible - esperando compañero';
            }

            // Intentar obtener ingredientes extra (tabla de compañero)
            try {
                $data['extra_ingredients'] = DB::table('extra_ingredients')
                    ->select('id', 'name', 'price')
                    ->orderBy('name')
                    ->get();
            } catch (\Exception $e) {
                $data['extra_ingredients'] = [];
                $data['extra_ingredients_note'] = 'Tabla extra_ingredients no disponible - esperando compañero';
            }

            return response()->json([
                'success' => true,
                'data' => $data,
                'message' => 'Datos para crear ingrediente extra obtenidos'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener datos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     * CONVERTIDO A API - Mantiene tu lógica con validaciones
     */
    public function store(Request $request)
    {
        // Agregar validaciones
        $request->validate([
            'order_id' => 'required|integer',
            'extra_ingredient_id' => 'required|integer',
            'quantity' => 'required|integer|min:1'
        ]);

        try {
            // Verificar que existan los registros relacionados
            $validations = [];

            try {
                $orderExists = DB::table('orders')->where('id', $request->order_id)->exists();
                if (!$orderExists) {
                    $validations[] = 'La orden especificada no existe';
                }
            } catch (\Exception $e) {
                $validations[] = 'Tabla orders no disponible - no se puede validar order_id';
            }

            try {
                $ingredientExists = DB::table('extra_ingredients')->where('id', $request->extra_ingredient_id)->exists();
                if (!$ingredientExists) {
                    $validations[] = 'El ingrediente extra especificado no existe';
                }
            } catch (\Exception $e) {
                $validations[] = 'Tabla extra_ingredients no disponible - no se puede validar extra_ingredient_id';
            }

            // Usar tu método existente de inserción
            $ingredientId = DB::table('order_extra_ingredient')->insertGetId([
                'order_id' => $request->order_id,
                'extra_ingredient_id' => $request->extra_ingredient_id,
                'quantity' => $request->quantity,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Intentar obtener el registro creado con joins
            try {
                $order_extra_ingredient = DB::table('order_extra_ingredient')
                    ->join('orders', 'order_extra_ingredient.order_id', '=', 'orders.id')
                    ->join('extra_ingredients', 'order_extra_ingredient.extra_ingredient_id', '=', 'extra_ingredients.id')
                    ->select(
                        'order_extra_ingredient.*',
                        'orders.id as order_code',
                        'orders.customer_name',
                        'extra_ingredients.name as ingredient_name',
                        'extra_ingredients.price as ingredient_price'
                    )
                    ->where('order_extra_ingredient.id', $ingredientId)
                    ->first();

                return response()->json([
                    'success' => true,
                    'data' => $order_extra_ingredient,
                    'message' => 'Ingrediente extra agregado correctamente',
                    'validations_notes' => $validations
                ], 201);

            } catch (\Exception $e) {
                // Si no se pueden hacer joins, devolver datos básicos
                $order_extra_ingredient = DB::table('order_extra_ingredient')
                    ->where('id', $ingredientId)
                    ->first();

                return response()->json([
                    'success' => true,
                    'data' => $order_extra_ingredient,
                    'message' => 'Ingrediente extra agregado correctamente (vista básica)',
                    'validations_notes' => $validations
                ], 201);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al agregar ingrediente extra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     * IMPLEMENTADO - Antes estaba vacío
     */
    public function show(string $id)
    {
        try {
            // Intentar obtener con joins completos
            try {
                $order_extra_ingredient = DB::table('order_extra_ingredient')
                    ->join('orders', 'order_extra_ingredient.order_id', '=', 'orders.id')
                    ->join('extra_ingredients', 'order_extra_ingredient.extra_ingredient_id', '=', 'extra_ingredients.id')
                    ->select(
                        'order_extra_ingredient.*',
                        'orders.id as order_code',
                        'orders.customer_name',
                        'orders.customer_phone',
                        'orders.status as order_status',
                        'orders.total_price as order_total',
                        'extra_ingredients.name as ingredient_name',
                        'extra_ingredients.price as ingredient_price'
                    )
                    ->where('order_extra_ingredient.id', $id)
                    ->first();

                if (!$order_extra_ingredient) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Ingrediente extra no encontrado'
                    ], 404);
                }

                return response()->json([
                    'success' => true,
                    'data' => $order_extra_ingredient
                ]);

            } catch (\Exception $e) {
                // Si no se pueden hacer joins, obtener datos básicos
                $order_extra_ingredient = DB::table('order_extra_ingredient')
                    ->where('id', $id)
                    ->first();

                if (!$order_extra_ingredient) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Ingrediente extra no encontrado'
                    ], 404);
                }

                return response()->json([
                    'success' => true,
                    'data' => $order_extra_ingredient,
                    'message' => 'Vista básica - joins completos disponibles cuando compañeros implementen tablas'
                ]);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener ingrediente extra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get data for editing order extra ingredient
     * CONVERTIDO A API - Para obtener datos de edición
     */
    public function edit($id)
    {
        try {
            $order_extra_ingredient = Order_extra_ingredient::find($id);

            if (!$order_extra_ingredient) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ingrediente extra no encontrado'
                ], 404);
            }

            $data = [
                'order_extra_ingredient' => $order_extra_ingredient,
                'orders' => [],
                'extra_ingredients' => []
            ];

            // Obtener órdenes disponibles (tabla de compañero)
            try {
                $data['orders'] = DB::table('orders')
                    ->select('id', 'customer_name', 'status', 'total_price')
                    ->orderBy('id', 'desc')
                    ->get();
            } catch (\Exception $e) {
                $data['orders_note'] = 'Tabla orders no disponible';
            }

            // Obtener ingredientes extra disponibles (tabla de compañero)
            try {
                $data['extra_ingredients'] = DB::table('extra_ingredients')
                    ->select('id', 'name', 'price')
                    ->orderBy('name')
                    ->get();
            } catch (\Exception $e) {
                $data['extra_ingredients_note'] = 'Tabla extra_ingredients no disponible';
            }

            return response()->json([
                'success' => true,
                'data' => $data,
                'message' => 'Datos para editar ingrediente extra obtenidos'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener datos de edición: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     * CONVERTIDO A API - Mantiene tu lógica con validaciones
     */
    public function update(Request $request, $id)
    {
        // Agregar validaciones
        $request->validate([
            'order_id' => 'required|integer',
            'extra_ingredient_id' => 'required|integer',
            'quantity' => 'required|integer|min:1'
        ]);

        try {
            $order_extra_ingredient = Order_extra_ingredient::find($id);

            if (!$order_extra_ingredient) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ingrediente extra no encontrado'
                ], 404);
            }

            // Usar tu método existente de actualización
            $order_extra_ingredient->order_id = $request->order_id;
            $order_extra_ingredient->extra_ingredient_id = $request->extra_ingredient_id;
            $order_extra_ingredient->quantity = $request->quantity;
            $order_extra_ingredient->save();

            // Intentar obtener datos actualizados con joins
            try {
                $order_extra_ingredient_updated = DB::table('order_extra_ingredient')
                    ->join('orders', 'order_extra_ingredient.order_id', '=', 'orders.id')
                    ->join('extra_ingredients', 'order_extra_ingredient.extra_ingredient_id', '=', 'extra_ingredients.id')
                    ->select(
                        'order_extra_ingredient.*',
                        'orders.id as order_code',
                        'orders.customer_name',
                        'extra_ingredients.name as ingredient_name',
                        'extra_ingredients.price as ingredient_price'
                    )
                    ->where('order_extra_ingredient.id', $id)
                    ->first();

                return response()->json([
                    'success' => true,
                    'data' => $order_extra_ingredient_updated,
                    'message' => 'Ingrediente extra actualizado correctamente'
                ]);

            } catch (\Exception $e) {
                return response()->json([
                    'success' => true,
                    'data' => $order_extra_ingredient,
                    'message' => 'Ingrediente extra actualizado correctamente (vista básica)'
                ]);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar ingrediente extra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     * CONVERTIDO A API - Mantiene tu lógica
     */
    public function destroy($id)
    {
        try {
            $order_extra_ingredient = Order_extra_ingredient::find($id);

            if (!$order_extra_ingredient) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ingrediente extra no encontrado'
                ], 404);
            }

            $order_extra_ingredient->delete();

            return response()->json([
                'success' => true,
                'message' => 'Ingrediente extra eliminado correctamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar ingrediente extra: ' . $e->getMessage()
            ], 500);
        }
    }

    // ========== MÉTODOS ADICIONALES PARA TRABAJO EN EQUIPO ==========

    /**
     * Obtener ingredientes extra por orden específica
     */
    public function getByOrder($orderId)
    {
        try {
            // Intentar con joins completos
            try {
                $order_extra_ingredients = DB::table('order_extra_ingredient')
                    ->join('extra_ingredients', 'order_extra_ingredient.extra_ingredient_id', '=', 'extra_ingredients.id')
                    ->select(
                        'order_extra_ingredient.*',
                        'extra_ingredients.name as ingredient_name',
                        'extra_ingredients.price as ingredient_price'
                    )
                    ->where('order_extra_ingredient.order_id', $orderId)
                    ->get();

                return response()->json([
                    'success' => true,
                    'data' => $order_extra_ingredients,
                    'message' => 'Ingredientes extra de la orden obtenidos'
                ]);

            } catch (\Exception $e) {
                // Si no hay joins, obtener datos básicos
                $order_extra_ingredients = DB::table('order_extra_ingredient')
                    ->where('order_id', $orderId)
                    ->get();

                return response()->json([
                    'success' => true,
                    'data' => $order_extra_ingredients,
                    'message' => 'Ingredientes extra obtenidos (vista básica)'
                ]);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener ingredientes extra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener ingredientes extra por tipo de ingrediente
     */
    public function getByIngredient($ingredientId)
    {
        try {
            $order_extra_ingredients = DB::table('order_extra_ingredient')
                ->where('extra_ingredient_id', $ingredientId)
                ->get();

            return response()->json([
                'success' => true,
                'data' => $order_extra_ingredients,
                'message' => 'Órdenes con este ingrediente obtenidas'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener órdenes: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener estadísticas de ingredientes extra
     */
    public function getStats()
    {
        try {
            $stats = [
                'total_extra_ingredients' => DB::table('order_extra_ingredient')->count(),
                'total_quantity' => DB::table('order_extra_ingredient')->sum('quantity'),
            ];

            // Estadísticas adicionales si las tablas están disponibles
            try {
                $stats['most_popular_ingredients'] = DB::table('order_extra_ingredient')
                    ->join('extra_ingredients', 'order_extra_ingredient.extra_ingredient_id', '=', 'extra_ingredients.id')
                    ->select('extra_ingredients.name', DB::raw('count(*) as count'), DB::raw('sum(order_extra_ingredient.quantity) as total_quantity'))
                    ->groupBy('extra_ingredients.name', 'extra_ingredients.id')
                    ->orderBy('count', 'desc')
                    ->limit(10)
                    ->get();

                $stats['by_order_status'] = DB::table('order_extra_ingredient')
                    ->join('orders', 'order_extra_ingredient.order_id', '=', 'orders.id')
                    ->select('orders.status', DB::raw('count(*) as count'))
                    ->groupBy('orders.status')
                    ->get();
            } catch (\Exception $e) {
                $stats['note'] = 'Estadísticas completas disponibles cuando compañeros implementen tablas';
            }

            return response()->json([
                'success' => true,
                'data' => $stats
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener estadísticas: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Calcular total de costo de ingredientes extra para una orden
     */
    public function calculateOrderTotal($orderId)
    {
        try {
            $total = 0;

            try {
                $total = DB::table('order_extra_ingredient')
                    ->join('extra_ingredients', 'order_extra_ingredient.extra_ingredient_id', '=', 'extra_ingredients.id')
                    ->where('order_extra_ingredient.order_id', $orderId)
                    ->selectRaw('SUM(extra_ingredients.price * order_extra_ingredient.quantity) as total')
                    ->value('total') ?? 0;
            } catch (\Exception $e) {
                // Si no hay tabla extra_ingredients, no se puede calcular
                $total = 0;
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'order_id' => $orderId,
                    'extra_ingredients_total' => $total
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al calcular total: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mantener funcionalidad web original (opcional)
     */
    public function webIndex()
    {
        $order_extra_ingredients = DB::table('order_extra_ingredient')
            ->join('orders', 'order_extra_ingredient.order_id', '=', 'orders.id')
            ->join('extra_ingredients', 'order_extra_ingredient.extra_ingredient_id', '=', 'extra_ingredients.id')
            ->select('order_extra_ingredient.*', 'orders.id as order_code', 'extra_ingredients.name as ingredient_name')
            ->get();

        return view('order_extra_ingredient.index', ['order_extra_ingredients' => $order_extra_ingredients]);
    }

}

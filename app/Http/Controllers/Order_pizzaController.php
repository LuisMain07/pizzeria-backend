<?php

namespace App\Http\Controllers;

use App\Models\Order_pizza;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Order_pizzaController extends Controller
{
    /**
     * Display a listing of the resource.
     * CONVERTIDO A API - Mantiene tu lógica de joins
     */
    public function index()
    {
        try {
            // Usar tu consulta existente pero con manejo de errores
            $orders_pizza = DB::table('orders_pizza')
                ->join('orders', 'orders_pizza.order_id', '=', 'orders.id')
                ->join('pizza_size', 'orders_pizza.pizza_size_id', '=', 'pizza_size.id')
                ->join('pizzas', 'pizza_size.pizza_id', '=', 'pizzas.id')
                ->select(
                    'orders_pizza.id',
                    'orders_pizza.order_id',
                    'orders_pizza.pizza_size_id',
                    'orders_pizza.quantity',
                    'orders_pizza.created_at',
                    'orders_pizza.updated_at',
                    'orders.status as order_status',
                    'orders.customer_name',
                    'orders.customer_phone',
                    'pizza_size.size as pizza_size',
                    'pizza_size.price as pizza_price',
                    'pizzas.name as pizza_name',
                    'pizzas.description as pizza_description'
                )
                ->orderBy('orders_pizza.id', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $orders_pizza,
                'message' => 'Órdenes de pizza obtenidas correctamente'
            ]);

        } catch (\Exception $e) {
            // Si las tablas de compañeros no existen aún, devolver datos básicos
            try {
                $orders_pizza_basic = DB::table('orders_pizza')
                    ->orderBy('id', 'desc')
                    ->get();

                return response()->json([
                    'success' => true,
                    'data' => $orders_pizza_basic,
                    'message' => 'Órdenes de pizza obtenidas (vista básica - esperando tablas de compañeros)',
                    'note' => 'Joins completos disponibles cuando compañeros implementen: orders, pizza_size, pizzas'
                ]);
            } catch (\Exception $e2) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al obtener órdenes de pizza: ' . $e2->getMessage()
                ], 500);
            }
        }
    }

    /**
     * Get data for creating new order pizza
     * CONVERTIDO A API - Obtiene datos necesarios para formularios
     */
    public function create()
    {
        try {
            $data = [
                'orders' => [],
                'pizza_sizes' => []
            ];

            // Intentar obtener órdenes (tabla de compañero)
            try {
                $data['orders'] = DB::table('orders')
                    ->select('id', 'customer_name', 'status', 'total_price')
                    ->orderBy('id', 'desc')
                    ->get();
            } catch (\Exception $e) {
                $data['orders'] = [];
                $data['orders_note'] = 'Tabla orders no disponible - esperando compañero';
            }

            // Intentar obtener tamaños de pizza (tabla de compañero)
            try {
                $data['pizza_sizes'] = DB::table('pizza_size')
                    ->join('pizzas', 'pizza_size.pizza_id', '=', 'pizzas.id')
                    ->select(
                        'pizza_size.id',
                        'pizza_size.size',
                        'pizza_size.price',
                        'pizzas.name as pizza_name'
                    )
                    ->get();
            } catch (\Exception $e) {
                $data['pizza_sizes'] = [];
                $data['pizza_sizes_note'] = 'Tablas pizza_size/pizzas no disponibles - esperando compañero';
            }

            return response()->json([
                'success' => true,
                'data' => $data,
                'message' => 'Datos para crear orden de pizza obtenidos'
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
     * CONVERTIDO A API - Mantiene tu lógica pero con validaciones
     */
    public function store(Request $request)
    {
        // Agregar validaciones
        $request->validate([
            'order_id' => 'required|integer',
            'pizza_size_id' => 'required|integer',
            'quantity' => 'required|integer|min:1'
        ]);

        try {
            // Verificar que existan los registros relacionados (cuando las tablas estén)
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
                $pizzaSizeExists = DB::table('pizza_size')->where('id', $request->pizza_size_id)->exists();
                if (!$pizzaSizeExists) {
                    $validations[] = 'El tamaño de pizza especificado no existe';
                }
            } catch (\Exception $e) {
                $validations[] = 'Tabla pizza_size no disponible - no se puede validar pizza_size_id';
            }

            // Usar tu método existente de creación
            $order_pizza = new Order_pizza();
            $order_pizza->order_id = $request->order_id;
            $order_pizza->pizza_size_id = $request->pizza_size_id;
            $order_pizza->quantity = $request->quantity;
            $order_pizza->save();

            // Obtener el registro creado con relaciones si están disponibles
            try {
                $order_pizza_full = DB::table('orders_pizza')
                    ->join('orders', 'orders_pizza.order_id', '=', 'orders.id')
                    ->join('pizza_size', 'orders_pizza.pizza_size_id', '=', 'pizza_size.id')
                    ->join('pizzas', 'pizza_size.pizza_id', '=', 'pizzas.id')
                    ->select(
                        'orders_pizza.*',
                        'orders.customer_name',
                        'pizza_size.size as pizza_size',
                        'pizzas.name as pizza_name'
                    )
                    ->where('orders_pizza.id', $order_pizza->id)
                    ->first();

                return response()->json([
                    'success' => true,
                    'data' => $order_pizza_full,
                    'message' => 'Orden de pizza creada correctamente',
                    'validations_notes' => $validations
                ], 201);

            } catch (\Exception $e) {
                // Si no se pueden hacer joins, devolver datos básicos
                return response()->json([
                    'success' => true,
                    'data' => $order_pizza,
                    'message' => 'Orden de pizza creada correctamente (vista básica)',
                    'validations_notes' => $validations
                ], 201);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear orden de pizza: ' . $e->getMessage()
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
                $order_pizza = DB::table('orders_pizza')
                    ->join('orders', 'orders_pizza.order_id', '=', 'orders.id')
                    ->join('pizza_size', 'orders_pizza.pizza_size_id', '=', 'pizza_size.id')
                    ->join('pizzas', 'pizza_size.pizza_id', '=', 'pizzas.id')
                    ->select(
                        'orders_pizza.*',
                        'orders.customer_name',
                        'orders.customer_phone',
                        'orders.status as order_status',
                        'orders.total_price',
                        'pizza_size.size as pizza_size',
                        'pizza_size.price as pizza_price',
                        'pizzas.name as pizza_name',
                        'pizzas.description as pizza_description'
                    )
                    ->where('orders_pizza.id', $id)
                    ->first();

                if (!$order_pizza) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Orden de pizza no encontrada'
                    ], 404);
                }

                return response()->json([
                    'success' => true,
                    'data' => $order_pizza
                ]);

            } catch (\Exception $e) {
                // Si no se pueden hacer joins, obtener datos básicos
                $order_pizza = Order_pizza::find($id);

                if (!$order_pizza) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Orden de pizza no encontrada'
                    ], 404);
                }

                return response()->json([
                    'success' => true,
                    'data' => $order_pizza,
                    'message' => 'Vista básica - joins completos disponibles cuando compañeros implementen tablas'
                ]);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener orden de pizza: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get data for editing order pizza
     * CONVERTIDO A API - Para obtener datos de edición
     */
    public function edit(string $id)
    {
        try {
            $order_pizza = Order_pizza::find($id);

            if (!$order_pizza) {
                return response()->json([
                    'success' => false,
                    'message' => 'Orden de pizza no encontrada'
                ], 404);
            }

            $data = [
                'order_pizza' => $order_pizza,
                'order' => null,
                'pizza_sizes' => []
            ];

            // Obtener orden específica (tabla de compañero)
            try {
                $data['order'] = DB::table('orders')
                    ->where('id', $order_pizza->order_id)
                    ->first();
            } catch (\Exception $e) {
                $data['order_note'] = 'Tabla orders no disponible';
            }

            // Obtener tamaños de pizza disponibles (tabla de compañero)
            try {
                $data['pizza_sizes'] = DB::table('pizza_size')
                    ->join('pizzas', 'pizza_size.pizza_id', '=', 'pizzas.id')
                    ->select(
                        'pizza_size.id',
                        'pizza_size.size',
                        'pizza_size.price',
                        'pizzas.name as pizza_name'
                    )
                    ->get();
            } catch (\Exception $e) {
                $data['pizza_sizes_note'] = 'Tablas pizza_size/pizzas no disponibles';
            }

            return response()->json([
                'success' => true,
                'data' => $data,
                'message' => 'Datos para editar orden de pizza obtenidos'
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
    public function update(Request $request, string $id)
    {
        // Agregar validaciones
        $request->validate([
            'order_id' => 'required|integer',
            'pizza_size_id' => 'required|integer',
            'quantity' => 'required|integer|min:1'
        ]);

        try {
            $order_pizza = Order_pizza::find($id);

            if (!$order_pizza) {
                return response()->json([
                    'success' => false,
                    'message' => 'Orden de pizza no encontrada'
                ], 404);
            }

            // Usar tu método existente de actualización
            $order_pizza->order_id = $request->order_id;
            $order_pizza->pizza_size_id = $request->pizza_size_id;
            $order_pizza->quantity = $request->quantity;
            $order_pizza->save();

            // Intentar obtener datos completos
            try {
                $order_pizza_updated = DB::table('orders_pizza')
                    ->join('orders', 'orders_pizza.order_id', '=', 'orders.id')
                    ->join('pizza_size', 'orders_pizza.pizza_size_id', '=', 'pizza_size.id')
                    ->join('pizzas', 'pizza_size.pizza_id', '=', 'pizzas.id')
                    ->select(
                        'orders_pizza.*',
                        'orders.customer_name',
                        'pizza_size.size as pizza_size',
                        'pizzas.name as pizza_name'
                    )
                    ->where('orders_pizza.id', $id)
                    ->first();

                return response()->json([
                    'success' => true,
                    'data' => $order_pizza_updated,
                    'message' => 'Orden de pizza actualizada correctamente'
                ]);

            } catch (\Exception $e) {
                return response()->json([
                    'success' => true,
                    'data' => $order_pizza,
                    'message' => 'Orden de pizza actualizada correctamente (vista básica)'
                ]);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar orden de pizza: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     * CONVERTIDO A API - Mantiene tu lógica
     */
    public function destroy(string $id)
    {
        try {
            $order_pizza = Order_pizza::find($id);

            if (!$order_pizza) {
                return response()->json([
                    'success' => false,
                    'message' => 'Orden de pizza no encontrada'
                ], 404);
            }

            $order_pizza->delete();

            return response()->json([
                'success' => true,
                'message' => 'Orden de pizza eliminada correctamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar orden de pizza: ' . $e->getMessage()
            ], 500);
        }
    }

    // ========== MÉTODOS ADICIONALES PARA TRABAJO EN EQUIPO ==========

    /**
     * Obtener órdenes de pizza por orden específica
     */
    public function getByOrder($orderId)
    {
        try {
            $orders_pizza = DB::table('orders_pizza')
                ->where('order_id', $orderId)
                ->get();

            return response()->json([
                'success' => true,
                'data' => $orders_pizza,
                'message' => 'Órdenes de pizza de la orden obtenidas'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener órdenes de pizza: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener estadísticas de órdenes de pizza
     */
    public function getStats()
    {
        try {
            $stats = [
                'total_orders_pizza' => DB::table('orders_pizza')->count(),
                'total_quantity' => DB::table('orders_pizza')->sum('quantity'),
            ];

            // Estadísticas adicionales si las tablas están disponibles
            try {
                $stats['by_status'] = DB::table('orders_pizza')
                    ->join('orders', 'orders_pizza.order_id', '=', 'orders.id')
                    ->select('orders.status', DB::raw('count(*) as count'))
                    ->groupBy('orders.status')
                    ->get();

                $stats['by_pizza_size'] = DB::table('orders_pizza')
                    ->join('pizza_size', 'orders_pizza.pizza_size_id', '=', 'pizza_size.id')
                    ->select('pizza_size.size', DB::raw('count(*) as count'))
                    ->groupBy('pizza_size.size')
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
     * Mantener funcionalidad web original (opcional)
     */
    public function webIndex()
    {
        $orders_pizza = DB::table('orders_pizza')
            ->join('orders', 'orders_pizza.order_id', '=', 'orders.id')
            ->join('pizza_size', 'orders_pizza.pizza_size_id', '=', 'pizza_size.id')
            ->join('pizzas', 'pizza_size.pizza_id', '=', 'pizzas.id')
            ->select(
                'orders_pizza.id',
                'orders.status as order_status',
                'pizza_size.size as pizza_size',
                'pizzas.name as pizza_name',
                'orders_pizza.quantity'
            )
            ->orderBy('orders_pizza.id', 'asc')
            ->get();
        return view('order_pizza.index', ['orders_pizza' => $orders_pizza]);
    }
}

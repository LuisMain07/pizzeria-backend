<?php

namespace App\Http\Controllers;

use App\Models\Branche;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BrancheController extends Controller
{
    /**
     * Display a listing of the resource.
     * CONVERTIDO A API - Devuelve JSON en lugar de view
     */
    public function index()
    {
        try {
            $branches = DB::table('branches')
                ->orderBy('name', 'asc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $branches,
                'message' => 'Sucursales obtenidas correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener sucursales: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     * MÉTODO OPCIONAL - Solo si quieres mantener funcionalidad web
     */
    public function create()
    {
        // Mantener solo si necesitas vistas web también
        return view('branche.new');
    }

    /**
     * Store a newly created resource in storage.
     * CONVERTIDO A API - Devuelve JSON y agrega validaciones
     */
    public function store(Request $request)
    {
        // Agregar validaciones
        $request->validate([
            'name' => 'required|string|max:255|unique:branches,name',
            'address' => 'required|string|max:255'
        ]);

        try {
            // Usar el método que ya tienes pero mejorado
            $branchId = DB::table('branches')->insertGetId([
                'name' => $request->name,
                'address' => $request->address,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Obtener la sucursal creada
            $branch = DB::table('branches')->where('id', $branchId)->first();

            return response()->json([
                'success' => true,
                'data' => $branch,
                'message' => 'Sucursal creada correctamente'
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear sucursal: ' . $e->getMessage()
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
            $branch = DB::table('branches')->where('id', $id)->first();

            if (!$branch) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sucursal no encontrada'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $branch
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener sucursal: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     * MÉTODO OPCIONAL - Solo si quieres mantener funcionalidad web
     */
    public function edit($id)
    {
        // Mantener solo si necesitas vistas web también
        $branche = Branche::find($id);

        return view('branche.edit', [
            'branche' => $branche
        ]);
    }

    /**
     * Update the specified resource in storage.
     * CONVERTIDO A API - Mantiene tu lógica pero devuelve JSON
     */
    public function update(Request $request, $id)
    {
        // Agregar validaciones
        $request->validate([
            'name' => 'required|string|max:255|unique:branches,name,' . $id,
            'address' => 'required|string|max:255'
        ]);

        try {
            // Usar tu método existente
            $branche = Branche::find($id);

            if (!$branche) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sucursal no encontrada'
                ], 404);
            }

            $branche->name = $request->name;
            $branche->address = $request->address;
            $branche->save();

            return response()->json([
                'success' => true,
                'data' => $branche,
                'message' => 'Sucursal actualizada correctamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar sucursal: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     * CONVERTIDO A API - Mantiene tu lógica pero devuelve JSON
     */
    public function destroy(string $id)
    {
        try {
            $branche = Branche::find($id);

            if (!$branche) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sucursal no encontrada'
                ], 404);
            }

            // Verificar si tiene órdenes relacionadas (preparado para trabajo en equipo)
            $hasOrders = DB::table('orders_pizza')->where('branch_id', $id)->exists();

            if ($hasOrders) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar la sucursal porque tiene órdenes asociadas'
                ], 400);
            }

            $branche->delete();

            return response()->json([
                'success' => true,
                'message' => 'Sucursal eliminada correctamente'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar sucursal: ' . $e->getMessage()
            ], 500);
        }
    }

    // ========== MÉTODOS ADICIONALES PARA TRABAJO EN EQUIPO ==========

    /**
     * Obtener sucursales para web (mantener funcionalidad original)
     */
    public function webIndex()
    {
        $branches = DB::table('branches')->get();
        return view('branche.index', ['branches' => $branches]);
    }

    /**
     * Obtener órdenes de una sucursal específica
     * Preparado para cuando tus compañeros implementen las tablas
     */
    public function getOrders($id)
    {
        try {
            $branch = Branche::find($id);

            if (!$branch) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sucursal no encontrada'
                ], 404);
            }

            // Esto funcionará cuando tus compañeros implementen la tabla orders
            $orders = DB::table('orders')
                ->where('branch_id', $id)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => [
                    'branch' => $branch,
                    'orders' => $orders
                ]
            ]);

        } catch (\Exception $e) {
            // Si la tabla orders no existe aún, devolver solo la sucursal
            return response()->json([
                'success' => true,
                'data' => [
                    'branch' => Branche::find($id),
                    'orders' => [],
                    'message' => 'Tabla orders aún no implementada por compañeros'
                ]
            ]);
        }
    }

    /**
     * Obtener estadísticas de la sucursal
     * Preparado para integración con trabajo en equipo
     */
    public function getStats($id)
    {
        try {
            $branch = Branche::find($id);

            if (!$branch) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sucursal no encontrada'
                ], 404);
            }

            $stats = [
                'branch' => $branch,
                'total_orders' => 0,
                'pending_orders' => 0,
                'completed_orders' => 0,
                'total_revenue' => 0
            ];

            // Estas consultas funcionarán cuando tus compañeros implementen sus tablas
            try {
                $stats['total_orders'] = DB::table('orders')->where('branch_id', $id)->count();
                $stats['pending_orders'] = DB::table('orders')
                    ->where('branch_id', $id)
                    ->where('status', 'pendiente')
                    ->count();
                $stats['completed_orders'] = DB::table('orders')
                    ->where('branch_id', $id)
                    ->where('status', 'entregado')
                    ->count();
                $stats['total_revenue'] = DB::table('orders')
                    ->where('branch_id', $id)
                    ->where('status', 'entregado')
                    ->sum('total_price');
            } catch (\Exception $e) {
                // Las tablas aún no existen, mantener valores por defecto
                $stats['message'] = 'Estadísticas limitadas - esperando implementación de compañeros';
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
}

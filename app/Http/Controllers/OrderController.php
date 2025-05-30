<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = DB::table('orders')
            ->join('clients', 'orders.client_id', '=', 'clients.id')
            ->join('users as client_users', 'clients.user_id', '=', 'client_users.id')
            ->join('branches', 'orders.branch_id', '=', 'branches.id')
            ->leftJoin('employees', 'orders.delivery_person_id', '=', 'employees.id')
            ->leftJoin('users as employees_users', 'employees.user_id', '=', 'employees_users.id')
            ->select(
                'orders.id',
                'orders.client_id',
                'client_users.name as client_name',
                'orders.branch_id',
                'branches.name as branch_name',
                'orders.total_price',
                'orders.status',
                'orders.delivery_type',
                'orders.delivery_person_id',
                'employees_users.name as delivery_person_name',
                'orders.created_at',
                'orders.updated_at'
            )
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $orders
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validaciones
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'branch_id' => 'required|exists:branches,id',
            'total_price' => 'required|numeric|min:0',
            'status' => 'required|string|in:pending,confirmed,preparing,ready,delivered,cancelled',
            'delivery_type' => 'required|string|in:pickup,delivery',
            'delivery_person_id' => 'nullable|exists:employees,id'
        ]);

        $order = new Order();
        $order->client_id = $request->client_id;
        $order->branch_id = $request->branch_id;
        $order->total_price = $request->total_price;
        $order->status = $request->status;
        $order->delivery_type = $request->delivery_type;
        $order->delivery_person_id = $request->delivery_person_id;
        $order->save();

        // Retornar el order con información completa
        $orderWithDetails = DB::table('orders')
            ->join('clients', 'orders.client_id', '=', 'clients.id')
            ->join('users as client_users', 'clients.user_id', '=', 'client_users.id')
            ->join('branches', 'orders.branch_id', '=', 'branches.id')
            ->leftJoin('employees', 'orders.delivery_person_id', '=', 'employees.id')
            ->leftJoin('users as employees_users', 'employees.user_id', '=', 'employees_users.id')
            ->where('orders.id', $order->id)
            ->select(
                'orders.id',
                'orders.client_id',
                'client_users.name as client_name',
                'orders.branch_id',
                'branches.name as branch_name',
                'orders.total_price',
                'orders.status',
                'orders.delivery_type',
                'orders.delivery_person_id',
                'employees_users.name as delivery_person_name',
                'orders.created_at',
                'orders.updated_at'
            )
            ->first();

        return response()->json([
            'status' => 'success',
            'message' => 'Orden creada exitosamente',
            'data' => $orderWithDetails
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = DB::table('orders')
            ->join('clients', 'orders.client_id', '=', 'clients.id')
            ->join('users as client_users', 'clients.user_id', '=', 'client_users.id')
            ->join('branches', 'orders.branch_id', '=', 'branches.id')
            ->leftJoin('employees', 'orders.delivery_person_id', '=', 'employees.id')
            ->leftJoin('users as employees_users', 'employees.user_id', '=', 'employees_users.id')
            ->where('orders.id', $id)
            ->select(
                'orders.id',
                'orders.client_id',
                'client_users.name as client_name',
                'orders.branch_id',
                'branches.name as branch_name',
                'orders.total_price',
                'orders.status',
                'orders.delivery_type',
                'orders.delivery_person_id',
                'employees_users.name as delivery_person_name',
                'orders.created_at',
                'orders.updated_at'
            )
            ->first();

        // Validar si el recurso existe
        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Orden no encontrada'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $order
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $order = Order::find($id);

        // Validar si el recurso existe
        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Orden no encontrada'
            ], 404);
        }

        // Validaciones
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'branch_id' => 'required|exists:branches,id',
            'total_price' => 'required|numeric|min:0',
            'status' => 'required|string|in:pending,confirmed,preparing,ready,delivered,cancelled',
            'delivery_type' => 'required|string|in:pickup,delivery',
            'delivery_person_id' => 'nullable|exists:employees,id'
        ]);

        $order->client_id = $request->client_id;
        $order->branch_id = $request->branch_id;
        $order->total_price = $request->total_price;
        $order->status = $request->status;
        $order->delivery_type = $request->delivery_type;
        $order->delivery_person_id = $request->delivery_person_id;
        $order->save();

        // Retornar el order actualizado con información completa
        $orderWithDetails = DB::table('orders')
            ->join('clients', 'orders.client_id', '=', 'clients.id')
            ->join('users as client_users', 'clients.user_id', '=', 'client_users.id')
            ->join('branches', 'orders.branch_id', '=', 'branches.id')
            ->leftJoin('employees', 'orders.delivery_person_id', '=', 'employees.id')
            ->leftJoin('users as employees_users', 'employees.user_id', '=', 'employees_users.id')
            ->where('orders.id', $order->id)
            ->select(
                'orders.id',
                'orders.client_id',
                'client_users.name as client_name',
                'orders.branch_id',
                'branches.name as branch_name',
                'orders.total_price',
                'orders.status',
                'orders.delivery_type',
                'orders.delivery_person_id',
                'employees_users.name as delivery_person_name',
                'orders.created_at',
                'orders.updated_at'
            )
            ->first();

        return response()->json([
            'status' => 'success',
            'message' => 'Orden actualizada exitosamente',
            'data' => $orderWithDetails
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::find($id);

        // Validar si el recurso existe
        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Orden no encontrada'
            ], 404);
        }

        $order->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Orden eliminada exitosamente'
        ], 200);
    }
}
<?php

namespace App\Http\Controllers;

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
                'client_users.name as client_name',
                'branches.name as branch_name',
                'orders.total_price',
                'orders.status',
                'orders.delivery_type',
                'employees_users.name as employees_name'
            )
            ->get();

        return view('Order.index', ['orders' => $orders]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $orders = DB::table('orders')->get();
        $clients = DB::table('clients')
            ->join('users', 'clients.user_id', '=', 'users.id')
            ->select('clients.id as client_id', 'users.name as client_name')
            ->get();

        $branches = DB::table('branches')->select('id', 'name')->get();

        $employees = DB::table('employees')
            ->join('users', 'employees.user_id', '=', 'users.id')
            ->select('employees.id', 'users.name as employee_name')
            ->get();

        return view('Order.new', [
            'orders' => $orders,
            'clients' => $clients,
            'branches' => $branches,
            'employees' => $employees
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $order = new Order();
        $order->client_id = $request->client_name;
        $order->branch_id = $request->branch;
        $order->total_price = $request->price;
        $order->status = $request->status;
        $order->delivery_type = $request->deliveryType;
        $order->delivery_person_id = $request->employee;
        $order->save();

        return redirect()->route('orders.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $order = Order::find($id);

        $clients = DB::table('clients')
            ->join('users', 'clients.user_id', '=', 'users.id')
            ->select('clients.id as client_id', 'users.name as client_name')
            ->get();

        $branches = DB::table('branches')
            ->select('id', 'name')
            ->get();

        $employees = DB::table('employees')
            ->join('users', 'employees.user_id', '=', 'users.id')
            ->select('employees.id', 'users.name as employee_name')
            ->get();

        return view('Order.edit', [
            'order' => $order,
            'clients' => $clients,
            'branches' => $branches,
            'employees' => $employees,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $order = Order::find($id);
        $order->client_id = $request->client_name;
        $order->branch_id = $request->branch;
        $order->total_price = $request->price;
        $order->status = $request->status;
        $order->delivery_type = $request->deliveryType;
        $order->delivery_person_id = $request->employee;
        $order->save();

        return redirect()->route('orders.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::find($id);
        $order->delete();
        return redirect()->route('orders.index');
    }
}

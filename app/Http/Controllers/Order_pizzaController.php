<?php

namespace App\Http\Controllers;

use App\Models\Order_pizza;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Order_pizzaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $orders = DB::table('orders')->get();

        $pizza_sizes = DB::table('pizza_size')->get();

        return view('order_pizza.new', ['orders' => $orders, 'pizza_sizes' => $pizza_sizes]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $order_pizza = new Order_pizza();
        $order_pizza->order_id = $request->order_id;
        $order_pizza->pizza_size_id = $request->pizza_size_id;
        $order_pizza->quantity = $request->quantity;
        $order_pizza->save();

        return redirect()->route('orders_pizza.index');
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
        $order_pizza = Order_pizza::find($id);

        $order = DB::table('orders')->where('id', $order_pizza->order_id)->first();


        $pizza_sizes = DB::table('pizza_size')->get();

        return view('Order_pizza.edit', [
            'order_pizza' => $order_pizza,
            'orders' => $order,
            'pizza_sizes' => $pizza_sizes
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $order_pizza = Order_pizza::find($id);

        $order_pizza->order_id = $request->order_id;
        $order_pizza->pizza_size_id = $request->pizza_size_id;
        $order_pizza->quantity = $request->quantity;
        $order_pizza->save();

        return redirect()->route('orders_pizza.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order_pizza = Order_pizza::find($id);
        $order_pizza->delete();
        return redirect()->route('orders_pizza.index');
    }
}

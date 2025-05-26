<?php

namespace App\Http\Controllers;

use App\Models\Order_extra_ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Order_extra_ingredientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $order_extra_ingredients = DB::table('order_extra_ingredient')
        ->join('orders', 'order_extra_ingredient.order_id', '=', 'orders.id')
        ->join('extra_ingredients', 'order_extra_ingredient.extra_ingredient_id', '=', 'extra_ingredients.id')
        ->select('order_extra_ingredient.*', 'orders.id as order_code', 'extra_ingredients.name as ingredient_name')
        ->get();

    return view('order_extra_ingredient.index', ['order_extra_ingredients' => $order_extra_ingredients]);
}

/**
 * Show the form for creating a new resource.
 */
public function create()
{
    $orders = DB::table('orders')
    ->orderBy('id'
    )->get();
    $extra_ingredients = DB::table('extra_ingredients')->orderBy('name')->get();

    return view('order_extra_ingredient.new', [
        'orders' => $orders,
        'extra_ingredients' => $extra_ingredients
    ]);
}

/**
 * Store a newly created resource in storage.
 */
public function store(Request $request)
{
    DB::table('order_extra_ingredient')->insert([
        'order_id' => $request->order_id,
        'extra_ingredient_id' => $request->extra_ingredient_id,
        'quantity' => $request->quantity,
        'created_at' => now(),
        'updated_at' => now()
    ]);

    $order_extra_ingredients = DB::table('order_extra_ingredient')
        ->join('orders', 'order_extra_ingredient.order_id', '=', 'orders.id')
        ->join('extra_ingredients', 'order_extra_ingredient.extra_ingredient_id', '=', 'extra_ingredients.id')
        ->select('order_extra_ingredient.*', 'orders.id as order_code', 'extra_ingredients.name as ingredient_name')
        ->get();

    return view('order_extra_ingredient.index', ['order_extra_ingredients' => $order_extra_ingredients]);
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
    public function edit($id)
{
    $order_extra_ingredient = Order_extra_ingredient::find($id);
    $orders = DB::table('orders')
        ->orderBy('id')
        ->get();

    $extra_ingredients = DB::table('extra_ingredients')
        ->orderBy('name')
        ->get();

    return view('order_extra_ingredient.edit', [
        'order_extra_ingredient' => $order_extra_ingredient,
        'orders' => $orders,
        'extra_ingredients' => $extra_ingredients
    ]);
}

/**
 * Update the specified resource in storage.
 */
public function update(Request $request, $id)
{
    $order_extra_ingredient = Order_extra_ingredient::find($id);

    $order_extra_ingredient->order_id = $request->order_id;
    $order_extra_ingredient->extra_ingredient_id = $request->extra_ingredient_id;
    $order_extra_ingredient->quantity = $request->quantity;
    $order_extra_ingredient->save();

    $order_extra_ingredients = DB::table('order_extra_ingredient')
        ->join('orders', 'order_extra_ingredient.order_id', '=', 'orders.id')
        ->join('extra_ingredients', 'order_extra_ingredient.extra_ingredient_id', '=', 'extra_ingredients.id')
        ->select('order_extra_ingredient.*', 'orders.id as order_code', 'extra_ingredients.name as ingredient_name')
        ->get();

    return view('order_extra_ingredient.index', ['order_extra_ingredients' => $order_extra_ingredients]);
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $order_extra_ingredient = Order_extra_ingredient::find($id);
        $order_extra_ingredient->delete();

    
            $order_extra_ingredients = DB::table('order_extra_ingredient')
            ->join('orders', 'order_extra_ingredient.order_id', '=', 'orders.id')
            ->join('extra_ingredients', 'order_extra_ingredient.extra_ingredient_id', '=', 'extra_ingredients.id')
            ->select('order_extra_ingredient.*', 'orders.id as order_code', 'extra_ingredients.name as ingredient_name')
            ->get();

        return view('order_extra_ingredient.index', ['order_extra_ingredients' => $order_extra_ingredients]);
    }
    
}

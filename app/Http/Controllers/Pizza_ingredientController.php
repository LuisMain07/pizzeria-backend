<?php

namespace App\Http\Controllers;

use App\Models\Pizza_ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Pizza_ingredientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pizza_ingredients = DB::table('pizza_ingredient')
            ->join('pizzas','pizza_ingredient.pizza_id', '=', 'pizzas.id')
            ->join('ingredients', 'pizza_ingredient.ingredient_id', '=', 'ingredients.id')
            ->select('pizza_ingredient.*', 'pizzas.name as pizza_name', 'ingredients.name as ingredient_name')
            ->orderBy('pizza_ingredient.pizza_id')
            ->get();
        return view('pizza_ingredient.index', ['pizza_ingredients' => $pizza_ingredients]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pizza_ingredients = DB::table('pizza_ingredient')
            ->join('pizzas','pizza_ingredient.pizza_id', '=', 'pizzas.id')
            ->join('ingredients', 'pizza_ingredient.ingredient_id', '=', 'ingredients.id')
            ->select('pizza_ingredient.*', 'pizzas.name as pizza_name', 'ingredients.name as ingredient_name')
            ->orderBy('pizza_ingredient.pizza_id')
            ->get();
        return view('pizza_ingredient.new', ['pizza_ingredients' => $pizza_ingredients]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $pizza_ingredient = new Pizza_ingredient();

        $pizza_ingredient->pizza_id = $request->pizza;
        $pizza_ingredient->ingredient_id = $request->ingredient;
        $pizza_ingredient->save();

        return redirect()->route('pizza_ingredients.index');
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
        $pizza_ingredient = Pizza_ingredient::find($id);
        $pizzas = DB::table('pizzas')
            ->orderBy('name')
            ->get();

        $ingredients = DB::table('ingredients')
            ->orderBy('name')
            ->get();

        return view('pizza_ingredient.edit', [
            'pizza_ingredient' => $pizza_ingredient,
            'pizzas' => $pizzas,
            'ingredients' => $ingredients
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pizza_ingredient = Pizza_ingredient::find($id);

        $pizza_ingredient->pizza_id = $request->pizza;
        $pizza_ingredient->ingredient_id = $request->ingredient;
        $pizza_ingredient->save();

        return redirect()->route('pizza_ingredients.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pizza_ingredient = Pizza_ingredient::find($id);
        $pizza_ingredient->delete();

        return redirect()->route('pizza_ingredients.index');
    }
}

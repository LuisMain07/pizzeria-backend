<?php

namespace App\Http\Controllers;

use App\Models\Extra_ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Extra_ingredientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $extra_ingredients = DB::table('extra_ingredients')
            ->get();
        return view('Extra_ingredient.index', ['extra_ingredients' => $extra_ingredients]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $extra_ingredients = DB::table('extra_ingredients')
            ->get();
        return view('Extra_ingredient.new', ['extra_ingredients' => $extra_ingredients]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $extra_ingredient = new Extra_ingredient();
        $extra_ingredient->name = $request->ingredient;
        $extra_ingredient->price = $request->price;

        $extra_ingredient->save();

        return redirect()->route('extra_ingredients.index');
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
        $extra_ingredient = Extra_ingredient::find($id);
        return view('Extra_ingredient.edit', ['extra_ingredient' => $extra_ingredient]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $extra_ingredient = Extra_ingredient::find($id);
        $extra_ingredient->name = $request->ingredient;
        $extra_ingredient->price = $request->price;
        $extra_ingredient->save();
        return redirect()->route('extra_ingredients.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $extra_ingredient = Extra_ingredient::find($id);
        $extra_ingredient->delete();

        return redirect()->route('extra_ingredients.index');
    }
}

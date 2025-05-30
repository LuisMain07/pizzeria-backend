<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pizza_ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;

class PizzaIngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Opción 1: Usando Query Builder (actual)
        $pizza_ingredients = DB::table('pizza_ingredient')
            ->join('pizzas','pizza_ingredient.pizza_id', '=', 'pizzas.id')
            ->join('ingredients', 'pizza_ingredient.ingredient_id', '=', 'ingredients.id')
            ->select('pizza_ingredient.*', 'pizzas.name as pizza_name', 'ingredients.name as ingredient_name')
            ->orderBy('pizza_ingredient.pizza_id')
            ->get();
        
        // Opción 2: Usando Eloquent con relaciones (más eficiente)
        // $pizza_ingredients = Pizza_ingredient::withRelations()
        //     ->orderBy('pizza_id')
        //     ->get();
        
        return response()->json($pizza_ingredients, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validaciones
        $request->validate([
            'pizza_id' => 'required|integer|exists:pizzas,id',
            'ingredient_id' => 'required|integer|exists:ingredients,id'
        ]);

        // Opción 1: Método actual
        $pizza_ingredient = new Pizza_ingredient();
        $pizza_ingredient->pizza_id = $request->pizza_id;
        $pizza_ingredient->ingredient_id = $request->ingredient_id;
        $pizza_ingredient->save();

        // Opción 2: Usando fillable (más limpio)
        // $pizza_ingredient = Pizza_ingredient::create($request->only(['pizza_id', 'ingredient_id']));

        // Obtener el registro completo con los nombres
        $created_pizza_ingredient = DB::table('pizza_ingredient')
            ->join('pizzas','pizza_ingredient.pizza_id', '=', 'pizzas.id')
            ->join('ingredients', 'pizza_ingredient.ingredient_id', '=', 'ingredients.id')
            ->select('pizza_ingredient.*', 'pizzas.name as pizza_name', 'ingredients.name as ingredient_name')
            ->where('pizza_ingredient.id', $pizza_ingredient->id)
            ->first();

        return response()->json([
            'message' => 'Pizza ingredient created successfully',
            'data' => $created_pizza_ingredient
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pizza_ingredient = DB::table('pizza_ingredient')
            ->join('pizzas','pizza_ingredient.pizza_id', '=', 'pizzas.id')
            ->join('ingredients', 'pizza_ingredient.ingredient_id', '=', 'ingredients.id')
            ->select('pizza_ingredient.*', 'pizzas.name as pizza_name', 'ingredients.name as ingredient_name')
            ->where('pizza_ingredient.id', $id)
            ->first();

        // Validar si el recurso existe
        if (!$pizza_ingredient) {
            return response()->json([
                'message' => 'Pizza ingredient not found'
            ], 404);
        }

        return response()->json($pizza_ingredient, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validaciones
        $request->validate([
            'pizza_id' => 'required|integer|exists:pizzas,id',
            'ingredient_id' => 'required|integer|exists:ingredients,id'
        ]);

        $pizza_ingredient = Pizza_ingredient::find($id);

        // Validar si el recurso existe
        if (!$pizza_ingredient) {
            return response()->json([
                'message' => 'Pizza ingredient not found'
            ], 404);
        }

        $pizza_ingredient->pizza_id = $request->pizza_id;
        $pizza_ingredient->ingredient_id = $request->ingredient_id;
        $pizza_ingredient->save();

        // Obtener el registro actualizado con los nombres
        $updated_pizza_ingredient = DB::table('pizza_ingredient')
            ->join('pizzas','pizza_ingredient.pizza_id', '=', 'pizzas.id')
            ->join('ingredients', 'pizza_ingredient.ingredient_id', '=', 'ingredients.id')
            ->select('pizza_ingredient.*', 'pizzas.name as pizza_name', 'ingredients.name as ingredient_name')
            ->where('pizza_ingredient.id', $id)
            ->first();

        return response()->json([
            'message' => 'Pizza ingredient updated successfully',
            'data' => $updated_pizza_ingredient
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pizza_ingredient = Pizza_ingredient::find($id);

        // Validar si el recurso existe
        if (!$pizza_ingredient) {
            return response()->json([
                'message' => 'Pizza ingredient not found'
            ], 404);
        }

        $pizza_ingredient->delete();

        return response()->json([
            'message' => 'Pizza ingredient deleted successfully'
        ], 200);
    }
}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Extra_ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExtraIngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $extraIngredients = DB::table('extra_ingredients')
            ->get();
        
        return response()->json([
            'status' => 'success',
            'data' => $extraIngredients
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validaciones
        $request->validate([
            'name' => 'required|string|max:255|unique:extra_ingredients,name',
            'price' => 'required|numeric|min:0'
        ]);

        $extraIngredient = new Extra_ingredient();
        $extraIngredient->name = $request->name;
        $extraIngredient->price = $request->price;
        $extraIngredient->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Ingrediente extra creado exitosamente',
            'data' => $extraIngredient
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $extraIngredient = DB::table('extra_ingredients')
            ->where('id', $id)
            ->first();

        // Validar si el recurso existe
        if (!$extraIngredient) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ingrediente extra no encontrado'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $extraIngredient
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $extraIngredient = Extra_ingredient::find($id);

        // Validar si el recurso existe
        if (!$extraIngredient) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ingrediente extra no encontrado'
            ], 404);
        }

        // Validaciones
        $request->validate([
            'name' => 'required|string|max:255|unique:extra_ingredients,name,' . $id,
            'price' => 'required|numeric|min:0'
        ]);

        $extraIngredient->name = $request->name;
        $extraIngredient->price = $request->price;
        $extraIngredient->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Ingrediente extra actualizado exitosamente',
            'data' => $extraIngredient
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $extraIngredient = Extra_ingredient::find($id);

        // Validar si el recurso existe
        if (!$extraIngredient) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ingrediente extra no encontrado'
            ], 404);
        }

        $extraIngredient->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Ingrediente extra eliminado exitosamente'
        ], 200);
    }
}
<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\PizzaRawMaterial;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PizzaRawMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $relations = DB::table('pizza_raw_material')
            ->join('raw_materials', 'pizza_raw_material.raw_material_id', '=', 'raw_materials.id')
            ->select(
                'pizza_raw_material.id',
                'pizza_raw_material.quantity',
                'pizza_raw_material.raw_material_id',
                'raw_materials.name as raw_material_name'
            )
            ->get();

        return response()->json(['relations' => $relations]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                // 'pizza_id' => ['required', 'exists:pizzas,id'],  // Comentado
                'raw_material_id' => ['required', 'exists:raw_materials,id'],
                'quantity' => ['required', 'numeric', 'min:0'],
            ]);

            $relation = new \App\Models\PizzaRawMaterial();
            // $relation->pizza_id = $request->pizza_id; // También comentar o controlar null
            $relation->raw_material_id = $request->raw_material_id;
            $relation->quantity = $request->quantity;
            $relation->save();

            return response()->json(['relation' => $relation], 201);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al registrar la relación pizza-materia prima.',
                'detalle' => $e->getMessage(),
            ], 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $relation = \App\Models\PizzaRawMaterial::find($id);

        if (is_null($relation)) {
            return response()->json(['error' => 'Relación materia prima no encontrada.'], 404);
        }

        return response()->json([
            'raw_material_id' => $relation->raw_material_id,
            'quantity' => $relation->quantity,
            'created_at' => $relation->created_at,
            'updated_at' => $relation->updated_at,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'raw_material_id' => ['required', 'exists:raw_materials,id'],
            'quantity' => ['required', 'numeric', 'min:0'],
        ]);

        $relation = \App\Models\PizzaRawMaterial::find($id);

        if (is_null($relation)) {
            return response()->json(['message' => 'Relación materia prima no encontrada.'], 404);
        }

        $relation->raw_material_id = $request->raw_material_id;
        $relation->quantity = $request->quantity;

        $relation->save();

        return response()->json(['relation' => $relation], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $relation = \App\Models\PizzaRawMaterial::find($id);

        if (is_null($relation)) {
            return response()->json(['message' => 'Relación materia prima no encontrada.'], 404);
        }

        $relation->delete();

        $relations = \App\Models\PizzaRawMaterial::all();

        return response()->json([
            'relations' => $relations,
            'success' => true
        ]);
    }
}

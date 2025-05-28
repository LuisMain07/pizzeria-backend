<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pizza_size;
use Illuminate\Support\Facades\DB;


class PizzasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pizzas_sizes = DB::table('pizza_size')
            ->join('pizzas', 'pizza_size.pizza_id', '=', 'pizzas.id')
            ->select('pizza_size.*', 'pizzas.name as pizza_name')
            ->get();

        return response()->json($pizzas_sizes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $request->validate([
            'pizza_id' => 'required|exists:pizzas,id',
            'size' => 'required|in:pequeña,mediana,grande',
            'price' => 'required|numeric|min:0',
        ]);

        $id = DB::table('pizza_size')->insertGetId([
            'pizza_id' => $request->pizza_id,
            'size' => $request->size,
            'price' => $request->price,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $newPizzaSize = Pizza_size::find($id);

        return response()->json(['message' => 'Tamaño de pizza agregado exitosamente', 'data' => $newPizzaSize], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pizza_size = Pizza_size::find($id);

        if (!$pizza_size) {
            return response()->json(['message' => 'Tamaño de pizza no encontrado'], 404);
        }

        return response()->json($pizza_size);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pizza_size = Pizza_size::find($id);

        if (!$pizza_size) {
            return response()->json(['message' => 'Tamaño de pizza no encontrado'], 404);
        }

        $request->validate([
            'pizza_id' => 'required|exists:pizzas,id',
            'size' => 'required|in:pequeña,mediana,grande',
            'price' => 'required|numeric|min:0',
        ]);

        $pizza_size->pizza_id = $request->pizza_id;
        $pizza_size->size = $request->size;
        $pizza_size->price = $request->price;
        $pizza_size->updated_at = now();
        $pizza_size->save();

        return response()->json(['message' => 'Tamaño de pizza actualizado', 'data' => $pizza_size]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pizza = Pizza::find($id);

        if (!$pizza) {
            return response()->json(['message' => 'Pizza no encontrada'], 404);
        }

        $pizza->delete();

        return response()->json(['message' => 'Pizza eliminada con éxito']);
    }
}

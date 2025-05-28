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
        $pizzas = DB::table('pizzas')->get();
        return response()->json($pizzas);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $pizza = new Pizza();
        $pizza->name = $request->name;
        $pizza->save();

        return response()->json(['message' => 'Pizza creada con éxito', 'data' => $pizza], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pizza = Pizza::find($id);

        if (!$pizza) {
            return response()->json(['message' => 'Pizza no encontrada'], 404);
        }

        return response()->json($pizza);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $pizza = Pizza::find($id);

        if (!$pizza) {
            return response()->json(['message' => 'Pizza no encontrada'], 404);
        }

        $pizza->name = $request->name;
        $pizza->save();

        return response()->json(['message' => 'Pizza actualizada con éxito', 'data' => $pizza]);
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

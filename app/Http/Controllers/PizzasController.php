<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pizza;
use Illuminate\Support\Facades\DB;

class PizzasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pizzas = DB::table('pizzas')
        ->get();
        return view('pizzas.index', ['pizzas' => $pizzas]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pizzas.new');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $pizza = new Pizza();
        $pizza->name = $request->name;
        $pizza->save(); // <-- Esto es lo que faltaba


        // Obtener todas las pizzas para mostrarlas
        $pizzas = Pizza::all();


        return view('pizzas.index', ['pizzas' => $pizzas]);
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
        $pizza = Pizza::find($id);
        
        return view('pizzas.edit', ['pizza' => $pizza]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pizza = Pizza::find($id);
        
        $pizza->name = $request->name;
        $pizza->save(); 
        $pizzas = DB::table('pizzas')
        ->get();
        $pizzas = Pizza::all();
        
        return view('pizzas.index', ['pizzas' => $pizzas]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pizza = Pizza::find($id);
        $pizza->delete();
        
        $pizzas = DB::table('pizzas')
        ->get();
        $pizzas = Pizza::all();
        
        return view('pizzas.index', ['pizzas' => $pizzas]);
    }
}


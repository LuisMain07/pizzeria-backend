<?php

namespace App\Http\Controllers;

use App\Models\Raw_material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Raw_materialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $raw_materials = DB::table('raw_materials')
        ->get();

        return view('raw_material.index', ['raw_materials' => $raw_materials]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('raw_material.new');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::table('raw_materials')->insert([
            'name' => $request->name,
            'unit' => $request->unit,
            'current_stock' => $request->current_stock,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $raw_materials = DB::table('raw_materials')
        ->get();

        return view('raw_material.index', ['raw_materials' => $raw_materials]);
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
        $raw_material = Raw_material::find($id); 

        return view('raw_material.edit', [
            'raw_material' => $raw_material
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $raw_material = Raw_material::find($id); 

        $raw_material->name = $request->name;
        $raw_material->unit = $request->unit;
        $raw_material->current_stock = $request->current_stock;
        $raw_material->save();

        $raw_materials = DB::table('raw_materials')
        ->get();

        return view('raw_material.index', ['raw_materials' => $raw_materials]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $raw_material = Raw_material::find($id); 
        $raw_material->delete();

        $raw_materials = DB::table('raw_materials')
        ->get();

        return view('raw_material.index', ['raw_materials' => $raw_materials]);
    }
}

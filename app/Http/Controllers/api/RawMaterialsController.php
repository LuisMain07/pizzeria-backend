<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\RawMaterial;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class RawMaterialsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rawMaterials = DB::table('raw_materials')->get();
        return response()->json(['raw_materials' => $rawMaterials]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'max:255'],
                'unit' => ['required', 'max:50'],
                'current_stock' => ['required', 'numeric', 'min:0'],
            ]);

            $rawMaterial = new RawMaterial();
            $rawMaterial->name = $request->name;
            $rawMaterial->unit = $request->unit;
            $rawMaterial->current_stock = $request->current_stock;
            $rawMaterial->save();

            return response()->json(['raw_material' => $rawMaterial], 201);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al crear la materia prima.',
                'detalle' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rawMaterial = RawMaterial::find($id);

        if (is_null($rawMaterial)) {
            return response()->json(['error' => 'Materia prima no encontrada.'], 404);
        }

        return response()->json(['raw_material' => $rawMaterial], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required', 'max:255'],
            'unit' => ['required', 'max:50'],
            'current_stock' => ['required', 'numeric', 'between:0,999999.99'],
        ]);

        $rawMaterial = RawMaterial::find($id);

        if (is_null($rawMaterial)) {
            return response()->json(['message' => 'Materia prima no encontrada.'], 404);
        }

        $rawMaterial->name = $request->name;
        $rawMaterial->unit = $request->unit;
        $rawMaterial->current_stock = $request->current_stock;
        $rawMaterial->save();

        return response()->json(['raw_material' => $rawMaterial], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rawMaterial = RawMaterial::find($id);

        if (is_null($rawMaterial)) {
            return response()->json(['message' => 'Materia prima no encontrada.'], 404);
        }

        $rawMaterial->delete();

        $rawMaterials = RawMaterial::all();

        return response()->json([
            'raw_materials' => $rawMaterials,
            'success' => true
        ]);
    }
}

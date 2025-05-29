<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = DB::table('suppliers')->get();
        return response()->json(['suppliers' => $suppliers]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'max:255'],
                'contact_info' => ['required', 'max:500'],
            ]);

            $supplier = new Supplier();
            $supplier->name = $request->name;
            $supplier->contact_info = $request->contact_info;
            $supplier->save();

            return response()->json(['supplier' => $supplier], 201);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al crear el proveedor.',
                'detalle' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $supplier = Supplier::find($id);

        if (is_null($supplier)) {
            return response()->json(['error' => 'Proveedor no encontrado.'], 404);
        }

        return response()->json(['supplier' => $supplier], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required', 'max:255'],
            'contact_info' => ['nullable', 'max:255'],
        ]);

        $supplier = Supplier::find($id);

        if (is_null($supplier)) {
            return response()->json(['message' => 'Proveedor no encontrado.'], 404);
        }

        $supplier->name = $request->name;
        $supplier->contact_info = $request->contact_info;
        $supplier->save();

        return response()->json(['supplier' => $supplier], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $supplier = Supplier::find($id);

        if (is_null($supplier)) {
            return response()->json(['message' => 'Proveedor no encontrado.'], 404);
        }

        $supplier->delete();

        $suppliers = Supplier::all();

        return response()->json([
            'suppliers' => $suppliers,
            'success' => true
        ]);
    }
}

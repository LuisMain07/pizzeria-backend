<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchases = DB::table('purchases')
            ->join('suppliers', 'purchases.supplier_id', '=', 'suppliers.id')
            ->join('raw_materials', 'purchases.raw_material_id', '=', 'raw_materials.id')
            ->select(
                'purchases.id',
                'purchases.quantity',
                'purchases.purchase_price',
                'purchases.purchase_date',
                'suppliers.name as supplier_name',
                'raw_materials.name as raw_material_name'
            )
            ->get();

        return response()->json(['purchases' => $purchases]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'supplier_id' => ['required', 'exists:suppliers,id'],
                'raw_material_id' => ['required', 'exists:raw_materials,id'],
                'quantity' => ['required', 'numeric', 'min:0'],
                'purchase_price' => ['required', 'numeric', 'min:0'],
                'purchase_date' => ['required', 'date'],
            ]);

            $purchase = new Purchase();
            $purchase->supplier_id = $request->supplier_id;
            $purchase->raw_material_id = $request->raw_material_id;
            $purchase->quantity = $request->quantity;
            $purchase->purchase_price = $request->purchase_price;
            $purchase->purchase_date = $request->purchase_date;
            $purchase->save();

            return response()->json(['purchase' => $purchase], 201);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al registrar la compra.',
                'detalle' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $purchase = Purchase::find($id);

        if (is_null($purchase)) {
            return response()->json(['error' => 'Compra no encontrada.'], 404);
        }

        return response()->json(['purchase' => $purchase], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'supplier_id' => ['required', 'exists:suppliers,id'],
            'raw_material_id' => ['required', 'exists:raw_materials,id'],
            'quantity' => ['required', 'numeric', 'min:0'],
            'purchase_price' => ['required', 'numeric', 'min:0'],
            'purchase_date' => ['required', 'date'],
        ]);

        
        $purchase = Purchase::find($id);

        if (is_null($purchase)) {
            return response()->json(['message' => 'Compra no encontrada.'], 404);
        }

       
        $purchase->supplier_id = $request->supplier_id;
        $purchase->raw_material_id = $request->raw_material_id;
        $purchase->quantity = $request->quantity;
        $purchase->purchase_price = $request->purchase_price;
        $purchase->purchase_date = $request->purchase_date;

        $purchase->save();

        return response()->json(['purchase' => $purchase], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $purchase = Purchase::find($id);

        if (is_null($purchase)) {
            return response()->json(['message' => 'Compra no encontrada.'], 404);
        }

        $purchase->delete();

        $purchases = Purchase::all();

        return response()->json([
            'purchases' => $purchases,
            'success' => true
        ]);
    }
}

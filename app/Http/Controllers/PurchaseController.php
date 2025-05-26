<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        ->select('purchases.*','suppliers.name as supplier_name','raw_materials.name as raw_material_name')
        ->get();

        return view('purchase.index', ['purchases' => $purchases]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = DB::table('suppliers')->orderBy('name')->get();
        $raw_materials = DB::table('raw_materials')->orderBy('name')->get();
    
        return view('purchase.new', [
            'suppliers' => $suppliers,
            'raw_materials' => $raw_materials
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::table('purchases')->insert([
            'supplier_id' => $request->supplier_id,
            'raw_material_id' => $request->raw_material_id,
            'quantity' => $request->quantity,
            'purchase_price' => $request->purchase_price,
            'purchase_date' => $request->purchase_date,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    
        $purchases = DB::table('purchases')
        ->join('suppliers', 'purchases.supplier_id', '=', 'suppliers.id')
        ->join('raw_materials', 'purchases.raw_material_id', '=', 'raw_materials.id')
        ->select('purchases.*','suppliers.name as supplier_name','raw_materials.name as raw_material_name')
        ->get();

        return view('purchase.index', ['purchases' => $purchases]);
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
        $purchase = Purchase::find($id);

        $suppliers = DB::table('suppliers')
            ->orderBy('name')
            ->get();
    
        $raw_materials = DB::table('raw_materials')
            ->orderBy('name')
            ->get();
    
        return view('purchase.edit', [
            'purchase' => $purchase,
            'suppliers' => $suppliers,
            'raw_materials' => $raw_materials
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $purchase = Purchase::find($id);

        $purchase->supplier_id = $request->supplier_id;
        $purchase->raw_material_id = $request->raw_material_id;
        $purchase->quantity = $request->quantity;
        $purchase->purchase_price = $request->purchase_price;
        $purchase->purchase_date = $request->purchase_date;
        $purchase->updated_at = now();
        $purchase->save();

        $purchases = DB::table('purchases')
        ->join('suppliers', 'purchases.supplier_id', '=', 'suppliers.id')
        ->join('raw_materials', 'purchases.raw_material_id', '=', 'raw_materials.id')
        ->select('purchases.*','suppliers.name as supplier_name','raw_materials.name as raw_material_name')
        ->get();

        return view('purchase.index', ['purchases' => $purchases]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $purchase = Purchase::find($id);
        $purchase->delete();

        $purchases = DB::table('purchases')
        ->join('suppliers', 'purchases.supplier_id', '=', 'suppliers.id')
        ->join('raw_materials', 'purchases.raw_material_id', '=', 'raw_materials.id')
        ->select('purchases.*','suppliers.name as supplier_name','raw_materials.name as raw_material_name')
        ->get();

        return view('purchase.index', ['purchases' => $purchases]);
    }
}

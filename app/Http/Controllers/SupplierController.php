<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = DB::table('suppliers')
        ->get();

        return view('supplier.index', ['suppliers' => $suppliers]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('supplier.new');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::table('suppliers')->insert([
            'name' => $request->name,
            'contact_info' => $request->contact_info,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $suppliers = DB::table('suppliers')
        ->get();

        return view('supplier.index', ['suppliers' => $suppliers]);
        
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
        $supplier = Supplier::find($id); 

        return view('supplier.edit', [
            'supplier' => $supplier
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $supplier = Supplier::find($id); 

        $supplier->name = $request->name;
        $supplier->contact_info = $request->contact_info;
        $supplier->save();

        
        $suppliers = DB::table('suppliers')
        ->get();

        return view('supplier.index', ['suppliers' => $suppliers]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $supplier = Supplier::find($id);
        $supplier->delete(); 

        $suppliers = DB::table('suppliers')
        ->get();

        return view('supplier.index', ['suppliers' => $suppliers]);
        
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Client;



class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = DB::table('clients')
            ->join('users', 'clients.user_id', '=', 'users.id')
            ->select('clients.*', 'users.name as user_name') // si el usuario tiene 'name'
            ->get();

        return view('client.index', ['clients' => $clients]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = DB::table('users')->
        orderBy('name')
        ->get();

        return view('client.new', ['users' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::table('clients')->insert([
            'user_id' => $request->user_id,
            'address' => $request->address,
            'phone' => $request->phone,
            'created_at' => now(),
            'updated_at' => now()
        ]);

            $clients = DB::table('clients')
            ->join('users', 'clients.user_id', '=', 'users.id')
            ->select('clients.*', 'users.name as user_name') 
            ->get();

        return view('client.index', ['clients' => $clients]);
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
        $client = Client::find($id);
        $users = DB::table('users')->orderBy('name')->get();
    
        return view('client.edit', [
            'client' => $client,
            'users' => $users
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       

        $client = Client::find($id);
        $client->user_id = $request->user_id;
        $client->address = $request->address;
        $client->phone = $request->phone;
        $client->updated_at = now();
        $client->save();

        $clients = DB::table('clients')
            ->join('users', 'clients.user_id', '=', 'users.id')
            ->select('clients.*', 'users.name as user_name')
            ->get();

        return view('client.index', ['clients' => $clients]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = Client::find($id);
        $client->delete();

        $clients = DB::table('clients')
            ->join('users', 'clients.user_id', '=', 'users.id')
            ->select('clients.*', 'users.name as user_name')
            ->get();

        return view('client.index', ['clients' => $clients]);
    }
}

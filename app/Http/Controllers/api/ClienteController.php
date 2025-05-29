<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    public function index()
    {
        $clients = DB::table('clients')
            ->join('users', 'clients.user_id', '=', 'users.id')
            ->leftJoin('orders', 'clients.id', '=', 'orders.client_id')
            ->select(
                'clients.id',
                'clients.user_id',
                'clients.address',
                'clients.phone',
                'clients.created_at',
                'clients.updated_at',
                'users.name as user_name',
                DB::raw('COUNT(orders.id) as orders_count')
            )
            ->groupBy(
                'clients.id',
                'clients.user_id',
                'clients.address',
                'clients.phone',
                'clients.created_at',
                'clients.updated_at',
                'users.name'
            )
            ->get();

        return response()->json(['clients' => $clients]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'numeric'],
            'address' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $client = Client::create($validated);

        return response()->json(['clients' => $clients]);
    }

    public function show(string $id)
    {
        $client = DB::table('clients')
        ->join('users', 'clients.user_id', '=', 'users.id')
        ->select(
            'clients.id',
            'clients.user_id',
            'clients.address',
            'clients.phone',
            'clients.created_at',
            'clients.updated_at',
            'users.name as user_name'
        )
        ->where('clients.id', $id)
        ->first();

    if (!$client) {
        return abort(404);
    }

    $orders = DB::table('orders')
        ->where('client_id', $id)
        ->get();

    return response()->json([
        'client' => $client,
        'orders' => $orders,
    ]);

    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'numeric'],
            'address' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $client = Client::find($id);
        if (!$client) {
            return abort(404);
        }

        $client->update($validated);

        return response()->json(['client' => $client]);
    }

    public function destroy(string $id)
    {
        $client = Client::find($id);
        if (!$client) {
            return abort(404);
        }

        $client->delete();

        // Lista actualizada
        $clients = DB::table('clients')
            ->join('users', 'clients.user_id', '=', 'users.id')
            ->leftJoin('orders', 'clients.id', '=', 'orders.client_id')
            ->select(
                'clients.id',
                'clients.user_id',
                'clients.address',
                'clients.phone',
                'clients.created_at',
                'clients.updated_at',
                'users.name as user_name',
                DB::raw('COUNT(orders.id) as orders_count')
            )
            ->groupBy(
                'clients.id',
                'clients.user_id',
                'clients.address',
                'clients.phone',
                'clients.created_at',
                'clients.updated_at',
                'users.name'
            )
            ->get();

        return response()->json(['clients' => $clients, 'success' => true]);
    }
}

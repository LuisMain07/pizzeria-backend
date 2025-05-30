<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = DB::table('users')->get();
        return response()->json(['users' => $users]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'max:255'],
                'email' => ['required', 'email', 'unique:users,email'],
                'password' => ['required', 'min:6']
            ]);

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password); // Encriptar la contraseña
            $user->save();

            return response()->json(['user' => $user], 201);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al crear el usuario.',
                'detalle' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);

        if (is_null($user)) {
            return response()->json(['error' => 'Usuario no encontrado.'], 404);
        }

        return response()->json(['user' => $user], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
        ]);

        $user = User::find($id);

        if (is_null($user)) {
            return response()->json(['message' => 'Usuario no encontrado.'], 404);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return response()->json(['user' => $user], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if (is_null($user)) {
            return response()->json(['message' => 'Usuario no encontrado.'], 404);
        }

        $user->delete();

        $users = User::all();

        return response()->json([
            'users' => $users,
            'success' => true
        ]);
    }
}

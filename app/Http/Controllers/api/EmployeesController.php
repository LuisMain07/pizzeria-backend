<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $employees = \App\Models\Employee::with('user')->get();
            return response()->json(['employees' => $employees], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener empleados', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'user.name' => 'required|string|max:255',
                'user.email' => 'required|email|unique:users,email',
                'user.password' => 'required|string|min:6',
                'position' => 'required|in:cajero,administrador,cocinero,mensajero',
                'identification_number' => 'required|max:20',
                'salary' => 'required|numeric|min:0',
                'hire_date' => 'required|date',
            ]);

            // Crear usuario
            $userData = $request->input('user');
            $user = new User();
            $user->name = $userData['name'];
            $user->email = $userData['email'];
            $user->password = bcrypt($userData['password']);
            $user->role = 'empleado'; // fijo
            $user->save();

            // Crear empleado
            $employee = new Employee();
            $employee->user_id = $user->id;
            $employee->position = $request->position;
            $employee->identification_number = $request->identification_number;
            $employee->salary = $request->salary;
            $employee->hire_date = $request->hire_date;
            $employee->save();

            return response()->json(['employee' => $employee], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al crear el empleado.',
                'detalle' => $e->getMessage(),
                'linea' => $e->getLine(),
                'archivo' => $e->getFile()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employee = \App\Models\Employee::with('user')->find($id);

        if (is_null($employee)) {
            return response()->json(['error' => 'Empleado no encontrado.'], 404);
        }

        return response()->json(['employee' => $employee], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       $request->validate([
            'position' => ['required', 'in:cajero,administrador,cocinero,mensajero'],
            'identification_number' => ['required', 'max:20'],
            'salary' => ['required', 'numeric'],
            'hire_date' => ['required', 'date'],
            'user.name' => ['required', 'string', 'max:255'],
            'user.email' => ['required', 'email', 'max:255'],
        ]);

        $employee = \App\Models\Employee::with('user')->find($id);

        if (is_null($employee)) {
            return response()->json(['message' => 'Empleado no encontrado.'], 404);
        }

        // Actualizar datos del empleado
        $employee->position = $request->position;
        $employee->identification_number = $request->identification_number;
        $employee->salary = $request->salary;
        $employee->hire_date = $request->hire_date;
        $employee->save();

        // Actualizar datos del usuario relacionado
        $user = $employee->user;
        $user->name = $request->input('user.name');
        $user->email = $request->input('user.email');
        $user->save();

        return response()->json(['employee' => $employee->load('user')], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employee = \App\Models\Employee::find($id);

        if (is_null($employee)) {
            return response()->json(['message' => 'Empleado no encontrado.'], 404);
        }

        $employee->delete();

        $employees = \App\Models\Employee::all();

        return response()->json([
            'employees' => $employees,
            'success' => true
        ]);
    }
}

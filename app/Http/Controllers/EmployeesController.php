<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = DB::table('employees')
            ->join('users', 'employees.user_id', '=', 'users.id')
            ->select('employees.*', 'users.name as user_name') 
            ->get();

        return view('employees.index', ['employees' => $employees]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = DB::table('users')
        ->orderBy('name')  
        ->get();

    
        return view('employees.new', ['users' => $users]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $employee = new Employee();
        $employee->user_id = $request->user_id;
        $employee->position = $request->position;
        $employee->identification_number = $request->identification_number;
        $employee->salary = $request->salary;
        $employee->hire_date = $request->hire_date;
        $employee->save();
    
            $employees = DB::table('employees')
            ->join('users', 'employees.user_id', '=', 'users.id')
            ->select('employees.*', 'users.name as user_name') 
            
            ->get();

        return view('employees.index', ['employees' => $employees]);
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
        $employee = Employee::find($id);
        $users = DB::table('users')->orderBy('name')->get();
    
        return view('employees.edit', [
            'employee' => $employee,
            'users' => $users
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $employee = Employee::find($id);
        $employee->user_id = $request->user_id;
        $employee->position = $request->position;
        $employee->identification_number = $request->identification_number;
        $employee->salary = $request->salary;
        $employee->hire_date = $request->hire_date;
        $employee->save();

        return redirect()->route('employees.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employee = Employee::find($id);
        $employee->delete();

        $employees = DB::table('employees')
        ->join('users', 'employees.user_id', '=', 'users.id')
        ->select('employees.*', 'users.name as user_name') 
        
        ->get();

        return redirect()->route('employees.index');
    
    }
}

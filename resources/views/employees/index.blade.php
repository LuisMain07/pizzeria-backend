<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('employee') }}
        </h2>
    </x-slot>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Employees List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">

                    @php

                        $user = Auth::user();
                        
                        $isAdmin = false;
                        

                        if ($user->role == 'empleado') {
                            $employee = $user->employee; 
                            if ($employee && $employee->position == 'administrador') {
                                $isAdmin = true;
                            }
                        }
                    @endphp

                    @if($isAdmin) 
        <a href="{{ route('employees.create') }}" class="btn btn-success mt-3 mb-3">Agregar</a>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ID de Usuario</th>
                    <th>Posicion</th>
                    <th>Numero de Identificacion</th>
                    <th>Salario</th>
                    <th>Fecha</th>
                    <th>Actiones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $employee)
                <tr>
                    <td>{{ $employee->id }}</td>
                    <td>{{ $employee->user_name }}</td>
                    <td>{{ $employee->position }}</td>
                    <td>{{ $employee->identification_number }}</td>
                    <td>{{ '$' . number_format($employee->salary, 2, '.', ',') }}</td>
                    <td>{{ $employee->hire_date }}</td>
                    @if($isAdmin)
                    <td>
                        <a href="{{ route('employees.edit', ['employee' => $employee->id]) }}" class="btn btn-info">Edit</a>
                        <form action="{{ route('employees.destroy', ['employee' => $employee->id]) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('delete')
                            <input type="submit" class="btn btn-danger" value="Delete">
                        </form>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
                        </div>
                    </div>
                </div>
            </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
</x-app-layout>

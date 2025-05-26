<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('extra_ingredient') }}
        </h2>
    </x-slot>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Extra Ingredients List</title>
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
                            if ($employee && $employee->position == 'administrador'|| $employee->position == 'cocinero') {
                                $isAdmin = true;
                            }
                        }
                    @endphp

                    @if($isAdmin) 
                        <a href="{{ route('extra_ingredients.create') }}" class="btn btn-success mt-3 mb-3">Add</a>
                    @endif

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Price</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($extra_ingredients as $extra_ingredient)
                                <tr>
                                    <td>{{ $extra_ingredient->id }}</td>
                                    <td>{{ $extra_ingredient->name }}</td>
                                    <td>{{ '$' . number_format($extra_ingredient->price, 2, '.', ',') }}</td>
                                    @if($isAdmin) 
                                        <td>
                                            <a href="{{ route('extra_ingredients.edit', ['extra_ingredient' => $extra_ingredient->id]) }}"
                                                class="btn btn-info">Edit</a>
                                            <form action="{{ route('extra_ingredients.destroy', ['extra_ingredient' => $extra_ingredient->id]) }}"
                                                method="POST" style="display:inline-block">
                                                @method('delete')
                                                @csrf
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

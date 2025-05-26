<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('order_pizza') }}
        </h2>
    </x-slot>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Orders Pizza List</title>
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
                            if ($employee && $employee->position == 'administrador'|| $employee->position == 'cajero') {
                                $isAdmin = true;
                            }
                        }
                    @endphp

                    @if($isAdmin) 
        <a href="{{route('orders_pizza.create')}}" class="btn btn-success mt-3 mb-3">Add</a>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Order Status</th>
                    <th scope="col">Pizza Size</th>
                    <th scope="col">Pizza</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders_pizza as $order_pizza)
                <tr>
                    <td>{{ $order_pizza->id }}</td>
                    <td>{{ $order_pizza->order_status }}</td>
                    <td>{{ $order_pizza->pizza_size }}</td>
                    <td>{{ $order_pizza->pizza_name }}</td>
                    <td>{{ $order_pizza->quantity }}</td>
                    @if($isAdmin)
                    <td>
                        <a href="{{route('orders_pizza.edit', ['order_pizza' => $order_pizza->id])}}"
                            class="btn btn-info">Edit</a></li>
                        <form action="{{route('orders_pizza.destroy',['order_pizza' =>$order_pizza->id])}}"
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


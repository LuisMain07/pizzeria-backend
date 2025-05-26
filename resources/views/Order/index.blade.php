<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('order') }}
        </h2>
    </x-slot>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order List</title>
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
                        $isAdmin1 = false;
                        

                        if ($user->role == 'empleado') {
                            $employee = $user->employee;
                            if ($employee && $employee->position == 'administrador'|| $employee->position == 'cocinero') {
                                $isAdmin = true;
                            }

                            if ($employee && $employee->position == 'administrador'||$employee->position == 'cajero'||$employee->position == 'cocinero'||$employee->position == 'mensajero') {
                                $isAdmin1 = true;
                            }
                        }
                    @endphp

                    @if($isAdmin) 
        <a href="{{route('orders.create')}}" class="btn btn-success mt-3 mb-3">Add</a>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Client</th>
                    <th>Branch</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Delivery Type</th>
                    <th>Delivery Person</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->client_name }}</td>
                        <td>{{ $order->branch_name }}</td>
                        <td>{{ '$' . number_format($order->total_price, 2, '.', ',') }}</td>
                        <td>{{ $order->status }}</td>
                        <td>{{ $order->delivery_type }}</td>
                        <td>{{ $order->employees_name ?? 'N/A' }}</td>
                        @if($isAdmin1)
                        <td>
                            <a href="{{route('orders.edit', ['order' => $order->id])}}"
                                class="btn btn-info">Edit</a></li>
                            <form action="{{route('orders.destroy',['order' =>$order->id])}}"
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

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('clients') }}
        </h2>
    </x-slot>

<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Clientes</title>
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
        <a href="{{ route('clients.create') }}" class="btn btn-success mb-3">Agregar</a>
        @endif

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ID Usuario</th>
                    <th>Dirección</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clients as $client)
                <tr>
                    <td>{{ $client->id }}</td>
                    <td>{{ $client->user_name }}</td>
                    <td>{{ $client->address }}</td>
                    <td>{{ $client->phone }}</td>
                    @if($isAdmin)
                    <td>
                        <a href="{{ route('clients.edit', ['client' => $client->id]) }}" class="btn btn-info btn-sm">Editar</a>
                        <form action="{{ route('clients.destroy', ['client' => $client->id]) }}" method="POST" style="display:inline-block">
                            @method('delete')
                            @csrf
                            <input class="btn btn-danger btn-sm" type="submit" value="Eliminar">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </body>
</html>
</x-app-layout>

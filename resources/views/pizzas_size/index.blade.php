<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('pizzas_size') }}
        </h2>
    </x-slot>

<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Precios por Tamaño de Pizza</title>
  </head>
   <body>
    <div class="container">
      <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">

        @php
          $employee = \App\Models\Employee::where('user_id', Auth::id())->first();
      @endphp

      @if($employee && $employee->position == 'administrador')
        <a href="{{ route('pizzas_sizes.create') }}" class="btn btn-success mb-3">Agregar Tamaño</a>
      @endif

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ID de Pizza</th>
                    <th>Tamaño</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pizzas_sizes as $pizzas_size)
                <tr>
                    <td>{{ $pizzas_size->id }}</td>
                    <td>{{ $pizzas_size->pizza_id }}</td>
                    <td>{{ ucfirst($pizzas_size->size) }}</td>
                    <td>${{ number_format($pizzas_size->price, 2) }}</td>
                    @if($employee && $employee->position == 'administrador')
                    <td>
                      <a href="{{ route('pizzas_sizes.edit', ['pizzas_size' => $pizzas_size->id]) }}" class="btn btn-info btn-sm">Editar</a>
                      <form action="{{ route('pizzas_sizes.destroy', ['pizzas_size' => $pizzas_size->id]) }}" method="POST" style="display:inline-block">
                          @csrf
                          @method('DELETE')
                          <input type="submit" class="btn btn-danger btn-sm" value="Eliminar">
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
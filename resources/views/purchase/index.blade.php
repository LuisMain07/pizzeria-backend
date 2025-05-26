<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('purchase') }}
        </h2>
    </x-slot>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Listado de Compras</title>
  </head>
  <body>

    <div class="container mt-4">
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
      <a href="{{ route('purchases.create') }}" class="btn btn-success mb-3">Agregar</a>
      @endif

      <table class="table table-striped">
        <thead>
          <tr>
            <th>ID</th>
            <th>Proveedor</th>
            <th>Materia Prima</th>
            <th>Cantidad</th>
            <th>Precio de Compra</th>
            <th>Fecha de Compra</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach($purchases as $purchase)
            <tr>
              <td>{{ $purchase->id }}</td>
              <td>{{ $purchase->supplier_name }}</td>
              <td>{{ $purchase->raw_material_name }}</td>
              <td>{{ $purchase->quantity }}</td>
              <td>{{ $purchase->purchase_price }}</td>
              <td>{{ $purchase->purchase_date }}</td>
              @if($isAdmin)
              <td>
                <a href="{{ route('purchases.edit', ['purchase' => $purchase->id]) }}" class="btn btn-info btn-sm">Editar</a>
                <form action="{{ route('purchases.destroy', ['purchase' => $purchase->id]) }}" method="POST" style="display:inline-block">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
</x-app-layout>

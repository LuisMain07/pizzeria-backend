<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('pizza_raw_material') }}
        </h2>
    </x-slot>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Listado de Materias Primas por Pizza</title>
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
                            if ($employee && $employee->position == 'administrador'|| $employee->position == 'cocinero') {
                                $isAdmin = true;
                            }
                        }
                    @endphp

                    @if($isAdmin) 
      <a href="{{ route('pizza_raw_materials.create') }}" class="btn btn-success mb-3">Agregar</a>
      @endif

      <table class="table table-striped">
        <thead>
          <tr>
            <th>ID</th>
            <th>Pizza</th>
            <th>Materia Prima</th>
            <th>Cantidad</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach($pizza_raw_materials as $item)
            <tr>
              <td>{{ $item->id }}</td>
              <td>{{ $item->pizza_name }}</td>
              <td>{{ $item->raw_material_name }}</td>
              <td>{{ $item->quantity }}</td>
              @if($isAdmin)
              <td>
                <a href="{{ route('pizza_raw_materials.edit', ['pizza_raw_material' => $item->id]) }}" class="btn btn-info btn-sm">Editar</a>
                <form action="{{ route('pizza_raw_materials.destroy', ['pizza_raw_material' => $item->id]) }}" method="POST" style="display:inline-block">
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
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('raw_material') }}
        </h2>
    </x-slot>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Listado de Materias Primas</title>
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
      <a href="{{ route('raw_materials.create') }}" class="btn btn-success mb-3">Agregar</a>
      @endif

      <table class="table table-striped">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Unidad</th>
            <th>Stock Actual</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach($raw_materials as $raw_material)
            <tr>
              <td>{{ $raw_material->id }}</td>
              <td>{{ $raw_material->name }}</td>
              <td>{{ $raw_material->unit }}</td>
              <td>{{ $raw_material->current_stock }}</td>
              @if($isAdmin)
              <td>
                <a href="{{ route('raw_materials.edit', ['raw_material' => $raw_material->id]) }}" class="btn btn-info btn-sm">Editar</a>
                <form action="{{ route('raw_materials.destroy', ['raw_material' => $raw_material->id]) }}" method="POST" style="display:inline-block">
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
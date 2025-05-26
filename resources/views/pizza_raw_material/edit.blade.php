<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Editar Relación de Materias Primas</title>
  </head>
  <body>
    
    <div class="container mt-4">
      <h1>Editar Relación de Materias Primas</h1>

      <form method="POST" action="{{ route('pizza_raw_materials.update', ['pizza_raw_material' => $pizza_raw_material->id]) }}">
        @method('put')
        @csrf

        <div class="mb-3">
          <label for="id" class="form-label">ID</label>
          <input type="text" class="form-control" id="id" disabled value="{{ $pizza_raw_material->id }}">
          <div class="form-text">ID de la relación entre pizza y materia prima</div>
        </div>

        <div class="mb-3">
          <label for="pizza_id" class="form-label">Pizza</label>
          <select class="form-control" id="pizza_id" name="pizza_id" required>
            @foreach($pizzas as $pizza)
              <option value="{{ $pizza->id }}" {{ $pizza->id == $pizza_raw_material->pizza_id ? 'selected' : '' }}>
                {{ $pizza->name }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="mb-3">
          <label for="raw_material_id" class="form-label">Materia Prima</label>
          <select class="form-control" id="raw_material_id" name="raw_material_id" required>
            @foreach($raw_materials as $material)
              <option value="{{ $material->id }}" {{ $material->id == $pizza_raw_material->raw_material_id ? 'selected' : '' }}>
                {{ $material->name }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="mb-3">
          <label for="quantity" class="form-label">Cantidad</label>
          <input type="number" step="0.01" class="form-control" id="quantity" name="quantity" value="{{ $pizza_raw_material->quantity }}" required>
        </div>

        <div class="mt-3">
          <button type="submit" class="btn btn-primary">Actualizar</button>
          <a href="{{ route('pizza_raw_materials.index') }}" class="btn btn-warning">Cancelar</a>
        </div>
      </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" 
      crossorigin="anonymous"></script>
  </body>
</html>

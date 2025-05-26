<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Agregar Materia Prima</title>
  </head>
  <body>
    <div class="container mt-4">
      <h1>Agregar Materia Prima</h1>

      <form method="POST" action="{{ route('raw_materials.store') }}">
        @csrf

        <div class="mb-3">
          <label for="name" class="form-label">Nombre de la Materia Prima</label>
          <input type="text" class="form-control" id="name" name="name" placeholder="Ej. Harina de Trigo" required>
        </div>

        <div class="mb-3">
          <label for="unit" class="form-label">Unidad</label>
          <input type="text" class="form-control" id="unit" name="unit" placeholder="Ej. kg, litros, unidades" required>
        </div>

        <div class="mb-3">
          <label for="current_stock" class="form-label">Stock Actual</label>
          <input type="number" step="0.01" class="form-control" id="current_stock" name="current_stock" placeholder="Ej. 100.50" required>
        </div>

        <div class="mt-3">
          <button type="submit" class="btn btn-primary">Guardar</button>
          <a href="{{ route('raw_materials.index') }}" class="btn btn-warning">Cancelar</a>
        </div>
      </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </body>
</html>

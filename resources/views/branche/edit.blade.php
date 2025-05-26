<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Editar Sucursal</title>
  </head>
  <body>
    
    <div class="container mt-4">
      <h1>Editar Sucursal</h1>

      <form method="POST" action="{{ route('branches.update', ['branche' => $branche->id]) }}">
        @method('put')
        @csrf

        <div class="mb-3">
          <label for="id" class="form-label">ID</label>
          <input type="text" class="form-control" id="id" name="id" disabled value="{{ $branche->id }}">
          <div class="form-text">ID de la sucursal</div>
        </div>

        <div class="mb-3">
          <label for="name" class="form-label">Nombre</label>
          <input type="text" class="form-control" id="name" name="name" required value="{{ $branche->name }}">
        </div>

        <div class="mb-3">
          <label for="address" class="form-label">Dirección</label>
          <input type="text" class="form-control" id="address" name="address" required value="{{ $branche->address }}">
        </div>

        <div class="mt-3">
          <button type="submit" class="btn btn-primary">Actualizar</button>
          <a href="{{ route('branches.index') }}" class="btn btn-warning">Cancelar</a>
        </div>
      </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </body>
</html>

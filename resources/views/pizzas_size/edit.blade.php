<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Editar Tamaño de Pizza</title>
  </head>
  <body>
    
    <div class="container mt-4">
      <h1>Editar Tamaño de Pizza</h1>
      <form method="POST" action="{{ route('pizzas_sizes.update', ['pizzas_size' => $pizza_size->id]) }}">
        @method('PUT')  
        @csrf

        <div class="mb-3">
          <label for="pizza_id" class="form-label">Pizza</label>
          <select class="form-select" id="pizza_id" name="pizza_id" required>
            @foreach ($pizzas as $pizza)
              <option value="{{ $pizza->id }}" {{ $pizza->id == $pizza_size->pizza_id ? 'selected' : '' }}>
                {{ $pizza->name }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="mb-3">
          <label for="size" class="form-label">Tamaño</label>
          <select class="form-select" id="size" name="size" required>
            <option value="pequeña" {{ $pizza_size->size === 'pequeña' ? 'selected' : '' }}>Pequeña</option>
            <option value="mediana" {{ $pizza_size->size === 'mediana' ? 'selected' : '' }}>Mediana</option>
            <option value="grande" {{ $pizza_size->size === 'grande' ? 'selected' : '' }}>Grande</option>
          </select>
        </div>

        <div class="mb-3">
          <label for="price" class="form-label">Precio</label>
          <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ $pizza_size->price }}" required>
        </div>

        <div class="mt-3">
          <button type="submit" class="btn btn-primary">Actualizar</button>
          <a href="{{ route('pizzas_sizes.index') }}" class="btn btn-warning">Cancelar</a>
        </div>
      </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" 
      crossorigin="anonymous"></script>
  </body>
</html>

<!doctype html> 
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Agregar Tamaño de Pizza</title>
  </head>
  <body>
    <div class="container mt-5">
        <h1>Agregar Tamaño de Pizza</h1>

        <form method="POST" action="{{ route('pizzas_sizes.store') }}">
            @csrf

            {{-- Seleccionar Pizza (ID) --}}
            <div class="mb-3">
                <label for="pizza_id" class="form-label">Selecciona la pizza</label>
                <select class="form-control" name="pizza_id" id="pizza_id">
                    @foreach ($pizzas as $pizza)
                        <option value="{{ $pizza->id }}">{{ $pizza->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Seleccionar tamaño --}}
            <div class="mb-3">
                <label for="size" class="form-label">Tamaño</label>
                <select class="form-control" name="size" id="size">
                    <option value="pequeña">Pequeña</option>
                    <option value="mediana">Mediana</option>
                    <option value="grande">Grande</option>
                </select>
            </div>

            {{-- Precio --}}
            <div class="mb-3">
                <label for="price" class="form-label">Precio</label>
                <input type="number" step="0.01" class="form-control" id="price" name="price" placeholder="Ej: 25000">
            </div>

            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ route('pizzas_sizes.index') }}" class="btn btn-warning">Cancelar</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
  </body>
</html>

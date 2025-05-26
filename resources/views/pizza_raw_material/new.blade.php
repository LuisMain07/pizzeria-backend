<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Agregar Materia Prima a Pizza</title>
  </head>
  <body>
    <div class="container mt-4">
        <h1>Agregar Materia Prima a Pizza</h1>

        <form method="POST" action="{{ route('pizza_raw_materials.store') }}">
            @csrf

            <div class="mb-3">
                <label for="pizza_id" class="form-label">Pizza</label>
                <select class="form-select" id="pizza_id" name="pizza_id" required>
                    <option value="" selected disabled>Seleccione una pizza</option>
                    @foreach($pizzas as $pizza)
                        <option value="{{ $pizza->id }}">{{ $pizza->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="raw_material_id" class="form-label">Materia Prima</label>
                <select class="form-select" id="raw_material_id" name="raw_material_id" required>
                    <option value="" selected disabled>Seleccione una materia prima</option>
                    @foreach($raw_materials as $material)
                        <option value="{{ $material->id }}">{{ $material->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="quantity" class="form-label">Cantidad</label>
                <input type="number" step="0.01" class="form-control" id="quantity" name="quantity" placeholder="Ej. 2.50" required>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('pizza_raw_materials.index') }}" class="btn btn-warning">Cancelar</a>
            </div>  
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </body>
</html>

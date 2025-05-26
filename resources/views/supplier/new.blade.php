<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Agregar Proveedor</title>
  </head>
  <body>
    <div class="container mt-4">
        <h1>Agregar Proveedor</h1>

        <form method="POST" action="{{ route('suppliers.store') }}">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Nombre del Proveedor</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Ej. Distribuidora XYZ" required>
            </div>

            <div class="mb-3">
                <label for="contact_info" class="form-label">Información de Contacto</label>
                <input type="text" class="form-control" id="contact_info" name="contact_info" placeholder="Ej. 555-1234 | contacto@xyz.com">
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('suppliers.index') }}" class="btn btn-warning">Cancelar</a>
            </div>  
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </body>
</html>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Editar Compra</title>
  </head>
  <body>
    
    <div class="container mt-4">
      <h1>Editar Compra</h1>

      <form method="POST" action="{{ route('purchases.update', ['purchase' => $purchase->id]) }}">
        @method('put')
        @csrf

        <div class="mb-3">
          <label for="id" class="form-label">ID</label>
          <input type="text" class="form-control" id="id" disabled value="{{ $purchase->id }}">
          <div class="form-text">ID de la compra</div>
        </div>

        <div class="mb-3">
          <label for="supplier_id" class="form-label">Proveedor</label>
          <select class="form-control" id="supplier_id" name="supplier_id" required>
            @foreach($suppliers as $supplier)
              <option value="{{ $supplier->id }}" {{ $supplier->id == $purchase->supplier_id ? 'selected' : '' }}>
                {{ $supplier->name }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="mb-3">
          <label for="raw_material_id" class="form-label">Materia Prima</label>
          <select class="form-control" id="raw_material_id" name="raw_material_id" required>
            @foreach($raw_materials as $material)
              <option value="{{ $material->id }}" {{ $material->id == $purchase->raw_material_id ? 'selected' : '' }}>
                {{ $material->name }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="mb-3">
          <label for="quantity" class="form-label">Cantidad</label>
          <input type="number" step="0.01" class="form-control" id="quantity" name="quantity" value="{{ $purchase->quantity }}" required>
        </div>

        <div class="mb-3">
          <label for="purchase_price" class="form-label">Precio de Compra</label>
          <input type="number" step="0.01" class="form-control" id="purchase_price" name="purchase_price" value="{{ $purchase->purchase_price }}" required>
        </div>

        <div class="mb-3">
          <label for="purchase_date" class="form-label">Fecha de Compra</label>
          <input type="datetime-local" class="form-control" id="purchase_date" name="purchase_date" 
            value="{{ \Carbon\Carbon::parse($purchase->purchase_date)->format('Y-m-d\TH:i') }}" required>
        </div>

        <div class="mt-3">
          <button type="submit" class="btn btn-primary">Actualizar</button>
          <a href="{{ route('purchases.index') }}" class="btn btn-warning">Cancelar</a>
        </div>
      </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" 
      crossorigin="anonymous"></script>
  </body>
</html>

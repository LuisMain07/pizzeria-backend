<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Edit Order Extra Ingredient</title>
  </head>
  <body>
    
    <div class="container">
      <h1>Edit Order Extra Ingredient</h1>

      <form method="POST" action="{{ route('order_extra_ingredients.update', ['order_extra_ingredient' => $order_extra_ingredient->id]) }}">
        @method('put')
        @csrf

        <div class="mb-3">
          <label for="id" class="form-label">ID</label>
          <input type="text" class="form-control" id="id" name="id" disabled value="{{ $order_extra_ingredient->id }}">
          <div class="form-text">Record ID</div>
        </div>

        <div class="mb-3">
          <label for="order_id" class="form-label">Order</label>
          <select class="form-select" id="order_id" name="order_id" required>
            <option selected disabled value="">Choose one...</option>
            @foreach ($orders as $order)
              <option value="{{ $order->id }}" {{ $order->id == $order_extra_ingredient->order_id ? 'selected' : '' }}>
                Order #{{ $order->id }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="mb-3">
          <label for="extra_ingredient_id" class="form-label">Extra Ingredient</label>
          <select class="form-select" id="extra_ingredient_id" name="extra_ingredient_id" required>
            <option selected disabled value="">Choose one...</option>
            @foreach ($extra_ingredients as $ingredient)
              <option value="{{ $ingredient->id }}" {{ $ingredient->id == $order_extra_ingredient->extra_ingredient_id ? 'selected' : '' }}>
                {{ $ingredient->name }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="mb-3">
          <label for="quantity" class="form-label">Quantity</label>
          <input type="number" class="form-control" id="quantity" name="quantity" required value="{{ $order_extra_ingredient->quantity }}">
        </div>

        <div class="mt-3">
          <button type="submit" class="btn btn-primary">Update</button>
          <a href="{{ route('order_extra_ingredients.index') }}" class="btn btn-warning">Cancel</a>
        </div>
      </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </body>
</html>

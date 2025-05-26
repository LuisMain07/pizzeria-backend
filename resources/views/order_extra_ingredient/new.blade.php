<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Add Order Extra Ingredient</title>
  </head>
  <body>
    <div class="container mt-4">
        <h1>Add Order Extra Ingredient</h1>

        <form method="POST" action="{{ route('order_extra_ingredients.store') }}">
            @csrf

            <div class="mb-3">
                <label for="order_id" class="form-label">Order</label>
                <select class="form-select" id="order_id" name="order_id" required>
                    <option selected disabled value="">Choose order...</option>
                    @foreach ($orders as $order)
                        <option value="{{ $order->id }}">Order #{{ $order->id }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="extra_ingredient_id" class="form-label">Extra Ingredient</label>
                <select class="form-select" id="extra_ingredient_id" name="extra_ingredient_id" required>
                    <option selected disabled value="">Choose ingredient...</option>
                    @foreach ($extra_ingredients as $ingredient)
                        <option value="{{ $ingredient->id }}">{{ $ingredient->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" class="form-control" id="quantity" name="quantity" min="1" required>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('order_extra_ingredients.index') }}" class="btn btn-warning">Cancel</a>
            </div>  
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </body>
</html>

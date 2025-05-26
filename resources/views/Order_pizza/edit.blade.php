<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Order Pizza</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h1>Edit Order Pizza</h1>
        <form method="POST" action="{{ route('orders_pizza.update', $order_pizza->id) }}">
            @method('put')
            @csrf

            <div class="mb-3">
                <label for="id" class="form-label">Id</label>
                <input type="number" class="form-control" id="id" name="id" value="{{ $order_pizza->id }}" disabled>
                <div class="form-text">Order Pizza ID</div>
            </div>

            <div class="mb-3">
                <label for="order_status" class="form-label">Order Status</label>
                <input type="text" class="form-control" id="order_status" name="order_status"
                    value="{{ $orders->status }}" disabled>
                <div class="form-text">Status of the order</div>
            </div>

            <input type="hidden" name="order_id" value="{{ $order_pizza->order_id }}">

            <div class="mb-3">
                <label for="pizza_size_id" class="form-label">Pizza Size</label>
                <select class="form-select" id="pizza_size_id" name="pizza_size_id" required>
                    <option disabled value="">Choose one...</option>
                    @foreach ($pizza_sizes as $pizza_size)
                        <option value="{{ $pizza_size->id }}" {{ $order_pizza->pizza_size_id == $pizza_size->id ? 'selected' : '' }}>
                            {{ $pizza_size->size }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" class="form-control" id="quantity" name="quantity"
                    value="{{ $order_pizza->quantity }}" required min="1">
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('orders_pizza.index') }}" class="btn btn-warning">Cancel</a>
            </div>
        </form>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Order Pizza</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1>Add Order Pizza</h1>

        <form method="POST" action="{{ route('orders_pizza.store') }}">
            @csrf

            <div class="mb-3">
                <label for="order_id" class="form-label">Order ID:</label>
                <select class="form-select" id="order_id" name="order_id" required>
                    <option selected disabled value="">Choose Order...</option>
                    @foreach ($orders as $order)
                        <option value="{{ $order->id }}">{{ $order->id }} - {{ $order->status }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="pizza_size_id" class="form-label">Pizza Size:</label>
                <select class="form-select" id="pizza_size_id" name="pizza_size_id" required>
                    <option selected disabled value="">Choose Pizza Size...</option>
                    @foreach ($pizza_sizes as $pizza_size)
                        <option value="{{ $pizza_size->id }}">{{ $pizza_size->size }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity:</label>
                <input type="number" class="form-control" id="quantity" name="quantity" required min="1">
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('orders_pizza.index') }}" class="btn btn-warning">Cancel</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>


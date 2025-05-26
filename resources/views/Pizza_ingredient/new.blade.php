<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add pizza ingredient</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h1>Add pizza ingredient</h1>
        <form method="POST" action="{{ route('pizza_ingredients.store') }}">
            @csrf
            <div class="mb-3">
                <label for="pizza" class="form-label">pizza:</label>
                <select class="form-select" id="pizza" name="pizza" required>
                    <option select disabled value="">Choose one...</option>
                    @foreach ($pizza_ingredients as $pizza_ingredient)
                        <option value="{{ $pizza_ingredient->pizza_id }}">{{ $pizza_ingredient->pizza_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="ingredient" class="form-label">Ingredient:</label>
                <select class="form-select" id="ingredient" name="ingredient" required>
                    <option select disabled value="">Choose one...</option>
                    @foreach ($pizza_ingredients as $pizza_ingredient)
                        <option value="{{ $pizza_ingredient->ingredient_id }}">{{ $pizza_ingredient->ingredient_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{route('pizza_ingredients.index')}}" class="btn btn-warning">Cancel</a>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>

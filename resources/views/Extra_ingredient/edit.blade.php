<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add extra ingredient</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <h1>Add extra ingredient</h1>
        <form method="POST" action="{{ route('extra_ingredients.update', $extra_ingredient->id) }}">
            @method('put')
            @csrf
            <div class="mb-3">
                <label for="ingredient" class="form-label">Ingredient: </label>
                <input type="text" class="form-control" id="ingredient"
                    aria-describedby="IngredientHelp" name="ingredient"
                    value="{{$extra_ingredient->name}}">
                <div id="IngredientHelp" class="form-text">Extra ingredient</div>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price: </label>
                <input type="number" class="form-control" id="price"
                    aria-describedby="PriceHelp" name="price"
                    value="{{$extra_ingredient->price}}">
                <div id="PriceHelp" class="form-text">Price</div>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{route('extra_ingredients.index')}}" class="btn btn-warning">Cancel</a>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>



<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <h1>Add order</h1>
        <form method="POST" action="{{ route('orders.store') }}">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="client_name" class="form-label">Client:</label>
                    <select class="form-select" id="client_name" name="client_name" required>
                        <option selected disabled value="">Choose one...</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->client_id }}">{{ $client->client_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="branch" class="form-label">Branch:</label>
                    <select class="form-select" id="branch" name="branch" required>
                        <option selected disabled value="">Choose one...</option>
                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="price" class="form-label">Price: </label>
                    <input type="number" class="form-control" id="price"
                        aria-describedby="PriceHelp" name="price">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="status" class="form-label">Status:</label>
                    <select class="form-select" id="status" name="status" required>
                        <option selected disabled value="">Choose one...</option>
                        <option value="pendiente">Pendiente</option>
                        <option value="en_preparacion">En Preparación</option>
                        <option value="listo">Listo</option>
                        <option value="entregado">Entregado</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="deliveryType" class="form-label">Delivery type:</label>
                    <select class="form-select" id="deliveryType" name="deliveryType" required>
                        <option selected disabled value="">Choose one...</option>
                        <option value="en_local">en local</option>
                        <option value="a_domicilio">a domicilio</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="employee" class="form-label">Employee:</label>
                    <select class="form-select" id="employee" name="employee">
                        <option selected disabled value="">Choose one...</option>
                        @foreach ($employees as $employee)
                            <option value="{{ $employee->id}}">{{ $employee->employee_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{route('orders.index')}}" class="btn btn-warning">Cancel</a>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>


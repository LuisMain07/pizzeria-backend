<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Edit Employee</title>
</head>

<body>
    <div class="container">
        <h1>Edit Employee</h1>

        <form method="POST" action="{{ route('employees.update', ['employee' => $employee->id]) }}">
            @method('put')
            @csrf

            <div class="mb-3">
                <label for="id" class="form-label">ID</label>
                <input type="text" class="form-control" id="id" name="id" disabled value="{{ $employee->id }}">
                <div class="form-text">Employee ID</div>
            </div>

            <div class="mb-3">
                <label for="user_id" class="form-label">User</label>
                <select class="form-select" id="user_id" name="user_id" required>
                    <option selected disabled value="">Choose a user...</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ $user->id == $employee->user_id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="position" class="form-label">Position</label>
                <select class="form-select" id="position" name="position" required>
                    <option selected disabled value="">Choose a position...</option>
                    <option value="cajero" {{ $employee->position == 'cajero' ? 'selected' : '' }}>Cajero</option>
                    <option value="administrador" {{ $employee->position == 'administrador' ? 'selected' : '' }}>Administrador</option>
                    <option value="cocinero" {{ $employee->position == 'cocinero' ? 'selected' : '' }}>Cocinero</option>
                    <option value="mensajero" {{ $employee->position == 'mensajero' ? 'selected' : '' }}>Mensajero</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="identification_number" class="form-label">Identification Number</label>
                <input type="text" class="form-control" id="identification_number" name="identification_number" value="{{ $employee->identification_number }}">
            </div>

            <div class="mb-3">
                <label for="salary" class="form-label">Salary</label>
                <input type="text" class="form-control" id="salary" name="salary" value="{{ $employee->salary }}">
            </div>

            <div class="mb-3">
                <label for="hire_date" class="form-label">Hire Date</label>
                <input type="date" class="form-control" id="hire_date" name="hire_date" value="{{ $employee->hire_date }}">
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('employees.index') }}" class="btn btn-warning">Cancel</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

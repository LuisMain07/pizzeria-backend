<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Edit Client</title>
  </head>
  <body>
    <div class="container">
      <h1>Edit Client</h1>

      <form method="POST" action="{{ route('clients.update', ['client' => $client->id]) }}">
        @method('put')
        @csrf

        <div class="mb-3">
          <label for="id" class="form-label">ID</label>
          <input type="text" class="form-control" id="id" name="id" disabled value="{{ $client->id }}">
          <div class="form-text">Client ID</div>
        </div>

        <div class="mb-3">
          <label for="user_id" class="form-label">User</label>
          <select class="form-select" id="user_id" name="user_id" required>
            <option selected disabled value="">Choose a user...</option>
            @foreach ($users as $user)
              <option value="{{ $user->id }}" {{ $user->id == $client->user_id ? 'selected' : '' }}>
                {{ $user->name }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="mb-3">
          <label for="address" class="form-label">Address</label>
          <input type="text" class="form-control" id="address" name="address" value="{{ $client->address }}">
        </div>

        <div class="mb-3">
          <label for="phone" class="form-label">Phone</label>
          <input type="text" class="form-control" id="phone" name="phone" value="{{ $client->phone }}">
        </div>

        <div class="mt-3">
          <button type="submit" class="btn btn-primary">Update</button>
          <a href="{{ route('clients.index') }}" class="btn btn-warning">Cancel</a>
        </div>
      </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>

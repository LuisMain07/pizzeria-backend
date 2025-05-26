<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Editar Usuario</title>
  </head>
  <body>
    
    <div class="container mt-4">
      <h1>Editar Usuario</h1>

      <form method="POST" action="{{ route('users.update', ['user' => $user->id]) }}">
        @method('put')
        @csrf

        <div class="mb-3">
          <label for="id" class="form-label">ID</label>
          <input type="text" class="form-control" id="id" disabled value="{{ $user->id }}">
          <div class="form-text">ID del usuario</div>
        </div>

        <div class="mb-3">
          <label for="name" class="form-label">Nombre</label>
          <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Correo Electrónico</label>
          <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Nueva Contraseña</label>
          <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese nueva contraseña (opcional)">
          <div class="form-text">Dejar en blanco si no desea cambiar la contraseña</div>
        </div>

        <div class="mb-3">
          <label for="role" class="form-label">Rol</label>
          <select class="form-control" id="role" name="role" required>
            <option value="cliente" {{ $user->role == 'cliente' ? 'selected' : '' }}>Cliente</option>
            <option value="empleado" {{ $user->role == 'empleado' ? 'selected' : '' }}>Empleado</option>
          </select>
        </div>

        <div class="mt-3">
          <button type="submit" class="btn btn-primary">Actualizar</button>
          <a href="{{ route('users.index') }}" class="btn btn-warning">Cancelar</a>
        </div>
      </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" 
      crossorigin="anonymous"></script>
  </body>
</html>

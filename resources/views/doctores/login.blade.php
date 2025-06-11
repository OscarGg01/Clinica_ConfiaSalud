<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Login Doctores — Clínica ConfíaSalud</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background: #f5f5f5; }
    .login-card { max-width: 400px; margin: 100px auto; }
  </style>
</head>
<body>
  <div class="card login-card shadow">
    <div class="card-body p-4">
      <h3 class="card-title text-center mb-4" style="color:#024744;">Acceso Doctores</h3>
      @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
      @endif
      <form method="POST" action="{{ route('doctor.login.submit') }}">
        @csrf
        <div class="mb-3">
          <label for="email" class="form-label">Correo electrónico</label>
          <input type="email" id="email" name="email" class="form-control" required autofocus>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Contraseña (teléfono)</label>
          <input type="password" id="password" name="password" class="form-control" required pattern="\d{9}" title="9 dígitos">
        </div>
        <button type="submit" class="btn w-100" style="background:#024744;color:#fde6c4;">
          Ingresar
        </button>
      </form>
    </div>
  </div>
</body>
</html>

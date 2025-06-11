<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Detalles de Cita</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    :root {
      --verde-oscuro: #024744;
      --verde-claro:  #40aba4;
      --crema:        #fde6c4;
    }
    body { background: var(--crema); }
    .sidebar {
      background: var(--verde-oscuro);
      min-height: 100vh;
      color: white;
    }
    .sidebar a { color: white; }
    .sidebar a:hover { background: var(--verde-claro); color: #024744; }
    .card-admin {
      border: none;
      border-radius: .5rem;
      box-shadow: 0 2px 6px rgba(0,0,0,.1);
    }
    .card-admin-header {
      background: var(--verde-claro);
      color: white;
      padding: .75rem 1.25rem;
      border-top-left-radius: .5rem;
      border-top-right-radius: .5rem;
    }
  </style>
</head>
<body>

  <nav class="navbar navbar-light" style="background:#024744;">
    <div class="container">
      <span class="navbar-brand mb-0 h1 text-white">Clínica ConfíaSalud</span>
    </div>
  </nav>

  <div class="container py-5">
    <h2 class="mb-4" style="color:#024744;">Detalles de la Cita</h2>

    {{-- Datos del paciente --}}
    <div class="card shadow-sm mb-4">
      <div class="card-body">
        <h5 class="card-title">Datos del Paciente</h5>
        <ul class="list-group list-group-flush">
          <li class="list-group-item"><strong>DNI:</strong> {{ $cita->dni }}</li>
          <li class="list-group-item"><strong>Apellido paterno:</strong> {{ $cita->paciente->apellido_paterno }}</li>
          <li class="list-group-item"><strong>Apellido materno:</strong> {{ $cita->paciente->apellido_materno }}</li>
          <li class="list-group-item"><strong>Nombres:</strong> {{ $cita->paciente->nombres }}</li>
          <li class="list-group-item"><strong>Fecha nacimiento:</strong> {{ \Carbon\Carbon::parse($cita->paciente->fecha_nac)->format('d/m/Y') }}</li>
          <li class="list-group-item"><strong>Sexo:</strong> {{ $cita->paciente->sexo }}</li>
          <li class="list-group-item"><strong>Email:</strong> {{ $cita->paciente->email }}</li>
          <li class="list-group-item"><strong>Teléfono:</strong> {{ $cita->paciente->telefono }}</li>
          <li class="list-group-item"><strong>Whatsapp:</strong> {{ $cita->paciente->whatsapp }}</li>
          <li class="list-group-item"><strong>Ubicación:</strong> {{ $cita->paciente->ubicacion }}</li>
        </ul>
      </div>
    </div>

    {{-- Mensaje de éxito --}}
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
      </div>
    @endif

    {{-- Formulario de notas e imagen --}}
    <form method="POST"
    action="{{ route('doctor.citas.notas.update', $cita) }}"
    enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="mb-3">
        <label for="notas" class="form-label">Notas/Resultados</label>
        <textarea id="notas" name="notas" class="form-control" rows="4">{{ old('notas', $cita->notas) }}</textarea>
      </div>

      <div class="mb-3">
        <label for="imagen" class="form-label">Subir imagen clínica (si es necesario)</label>
        <input type="file" id="imagen" name="imagen" class="form-control" accept="image/*">
        @if($cita->imagen)
          <div class="mb-3">
            <label class="form-label">Imagen subida:</label><br>
            <img src="{{ asset('storage/' . $cita->imagen) }}"
                alt="Imagen cita"
                style="max-width: 200px; border-radius: .5rem;">
          </div>
        @endif

      </div>

      <button type="submit" class="btn" style="background:#40aba4; color:#024744;">Guardar</button>
      <a href="{{ route('doctor.dashboard') }}" class="btn btn-secondary ms-2">← Volver al Dashboard</a>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

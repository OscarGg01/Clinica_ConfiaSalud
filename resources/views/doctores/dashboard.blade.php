<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Dashboard Doctores</title>
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
  {{-- Navbar --}}
  <nav class="navbar navbar-light" style="background:#024744;">
    <div class="container">
      <span class="navbar-brand mb-0 h1 text-white">Clínica ConfíaSalud</span>
    </div>
  </nav>

  <div class="container py-5">
    {{-- Bienvenida --}}
    <h1 class="text-center mb-4" style="color:#024744;">
      Bienvenido {{ $nombre }}
    </h1>

    {{-- Listado de citas --}}
    <h3 class="mb-3">Tus citas agendadas</h3>
    @if($citas->isEmpty())
      <div class="alert alert-info">No tienes citas agendadas.</div>
    @else
      <table class="table table-striped shadow-sm">
        <thead class="table-light">
          <tr>
            <th>Paciente</th>
            <th>Área</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Detalles</th>
          </tr>
        </thead>
        <tbody>
          @foreach($citas as $c)
            <tr>
              <td>{{ $c->paciente->nombres }} {{ $c->paciente->apellido_paterno }}</td>
              <td>{{ $c->area->nombre }}</td>
              <td>{{ \Carbon\Carbon::parse($c->fecha)->format('d/m/Y') }}</td>
              <td>{{ $c->hora }}</td>
              <td>
                <a href="{{ route('doctor.citas.show', $c) }}"
                   class="btn btn-sm"
                   style="background: #40aba4; color: #024744;">
                  Ver detalles
                </a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @endif
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Panel Admin</title>
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
  <div class="d-flex">
    {{-- Sidebar --}}
    <nav class="sidebar flex-shrink-0 p-3">
      <a href="{{ route('admin.dashboard') }}" class="d-block mb-4 text-white text-decoration-none">
        <h3>ConfíaSalud administración</h3>
      </a>
      <ul class="nav nav-pills flex-column">
        <li class="nav-item"><a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard</a></li>
        <li class="nav-item"><a href="{{ route('especialistas.index') }}" class="nav-link">Especialistas</a></li>
        <li class="nav-item"><a href="{{ route('areas.index') }}" class="nav-link">Áreas</a></li>
        <li class="nav-item"><a href="{{ route('horarios.index') }}" class="nav-link">Horarios</a></li>
      </ul>
    </nav>

    {{-- Contenido principal --}}
    <div class="flex-grow-1 p-4">
      @yield('content')
    </div>
  </div>
</body>
</html>

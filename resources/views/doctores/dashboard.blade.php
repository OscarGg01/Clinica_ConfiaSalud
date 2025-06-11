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
    .navbar { background: var(--verde-oscuro); }
    .navbar .navbar-brand { color: white; }
    .card-admin { border: none; border-radius: .5rem; box-shadow: 0 2px 6px rgba(0,0,0,.1); }
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
  <nav class="navbar navbar-light">
    <div class="container">
      <span class="navbar-brand mb-0 h1">Clínica ConfíaSalud</span>
    </div>
  </nav>

  <div class="container py-5">
    {{-- Bienvenida --}}
    <h1 class="text-center mb-4" style="color: var(--verde-oscuro);">
      Bienvenido {{ $nombre }}
    </h1>

    {{-- Listado de citas --}}
    <h3 class="mb-3">Tus citas agendadas</h3>
    @if($citas->isEmpty())
      <div class="alert alert-info">No tienes citas agendadas.</div>
    @else
      <table class="table table-striped shadow-sm mb-5">
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
                   style="background: var(--verde-claro); color: var(--verde-oscuro);">
                  Ver detalles
                </a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @endif

    {{-- Historial médico del paciente --}}
    <div class="card card-admin p-4 mb-5">
      <div class="card-admin-header">Historial médico del paciente</div>
      <div class="card-body">
        <form id="historial-form" class="row g-3 align-items-end" method="GET" action="{{ route('doctor.historial') }}">
          @csrf
          <div class="col-md-8">
            <label for="hist-dni" class="form-label">Ingresa DNI del paciente</label>
            <input type="text"
                   id="hist-dni"
                   name="dni"
                   class="form-control"
                   required
                   pattern="\d{8}"
                   title="8 dígitos">
          </div>
          <div class="col-md-4">
            <button type="submit"
                    class="btn w-100"
                    style="background: var(--verde-oscuro); color: var(--crema);">
              <i class="bi bi-search me-1"></i> Buscar
            </button>
          </div>
        </form>
        
        <div id="historial-result" class="mt-4">
          {{-- Aquí se mostrará el historial tras la búsqueda --}}
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

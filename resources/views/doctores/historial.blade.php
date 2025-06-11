<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Historial Médico</title>
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
  <nav class="navbar navbar-light mb-4">
    <div class="container">
      <a href="{{ route('doctor.dashboard') }}" class="navbar-brand">Clínica ConfíaSalud</a>
    </div>
  </nav>

  <div class="container py-4">
    <h2 class="mb-4" style="color: var(--verde-oscuro);">
      Historial Médico de {{ $paciente->nombres }} {{ $paciente->apellido_paterno }} {{ $paciente->apellido_materno }}
    </h2>

    {{-- Datos del paciente --}}
    <div class="card mb-4">
      <div class="card-body">
        <p><strong>DNI:</strong> {{ $paciente->dni }}</p>
        <p><strong>Apellido paterno:</strong> {{ $paciente->apellido_paterno }}</p>
        <p><strong>Apellido materno:</strong> {{ $paciente->apellido_materno }}</p>
        <p><strong>Nombres:</strong> {{ $paciente->nombres }}</p>
        <p><strong>Fecha de nacimiento:</strong> {{ \Carbon\Carbon::parse($paciente->fecha_nac)->format('d/m/Y') }}</p>
        <p><strong>Sexo:</strong> {{ $paciente->sexo }}</p>
        <p><strong>Email:</strong> {{ $paciente->email }}</p>
        <p><strong>Teléfono:</strong> {{ $paciente->telefono }}</p>
        <p><strong>WhatsApp:</strong> {{ $paciente->whatsapp }}</p>
        <p><strong>Ubicación:</strong> {{ $paciente->ubicacion }}</p>
      </div>
    </div>

    {{-- Selector de orden --}}
    <div class="mb-4">
      <form method="GET" action="{{ route('doctor.historial') }}" class="row g-3 align-items-end">
        <input type="hidden" name="dni" value="{{ $paciente->dni }}">
        <div class="col-md-3">
          <label for="order_by" class="form-label">Ordenar Historial de citas por:</label>
          <select id="order_by" name="order_by" class="form-select">
            <option value="fecha" {{ ($sort??'fecha')==='fecha' ? 'selected' : '' }}>Fecha</option>
            <option value="especialista" {{ ($sort??'fecha')==='especialista' ? 'selected' : '' }}>Especialista</option>
            <option value="area" {{ ($sort??'fecha')==='area' ? 'selected' : '' }}>Área</option>
          </select>
        </div>
        <div class="col-md-2">
          <button type="submit" class="btn w-100" style="background: var(--verde-oscuro); color: var(--crema);">
            Aplicar
          </button>
        </div>
      </form>
    </div>

    {{-- Citas --}}
    @if($citas->isEmpty())
      <div class="alert alert-info">Este paciente no tiene citas registradas.</div>
    @else
      @foreach($citas as $c)
        <div class="card mb-4">
          <div class="card-header" style="background: var(--verde-claro); color: var(--verde-oscuro);">
            Cita con <strong>{{ $c->especialista->nombre }}</strong>
            ({{ $c->area->nombre }}) —
            {{ \Carbon\Carbon::parse($c->fecha)->format('d/m/Y') }} a las {{ $c->hora }}
          </div>
          <div class="card-body">
            <p><strong>Notas:</strong> {{ $c->notas ?? '—' }}</p>
            <p><strong>Imágenes:</strong></p>
            <div class="d-flex flex-wrap gap-2">
              @forelse($c->imagenes as $img)
                <img src="{{ asset('storage/'.$img->path) }}"
                     style="width:100px; height:100px; object-fit:cover; border-radius:.5rem;">
              @empty
                <span class="text-muted">Sin imágenes</span>
              @endforelse
            </div>
          </div>
        </div>
      @endforeach
    @endif

    <a href="{{ route('doctor.dashboard') }}" class="btn btn-secondary ms-2">← Volver al Dashboard</a>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

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
      --blanco:       #ffffff;
    }
    body { background: var(--crema); }
    .navbar { background: var(--verde-oscuro); }
    .navbar .navbar-brand { color: var(--blanco); }
    .card-admin { border: none; border-radius: .5rem; box-shadow: 0 2px 6px rgba(0,0,0,.1); }
    .card-admin-header {
      background: var(--verde-claro);
      color: var(--blanco);
      padding: .75rem 1.25rem;
      border-top-left-radius: .5rem;
      border-top-right-radius: .5rem;
    }
    .section-title { color: var(--verde-oscuro); font-weight: 700; margin-top: 2rem; }
  </style>
</head>
<body>
  <nav class="navbar mb-4">
    <div class="container">
      <a href="{{ route('doctor.dashboard') }}" class="navbar-brand">← Clínica ConfíaSalud</a>
    </div>
  </nav>

  <div class="container py-4">
    <h2 class="mb-4 section-title">
      Historial Médico de {{ $paciente->nombres }} {{ $paciente->apellido_paterno }} {{ $paciente->apellido_materno }}
    </h2>

    {{-- Datos y sección de historial clínico --}}
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                {{-- Columna izquierda: datos del paciente --}}
                <div class="col-md-6">
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
        
                {{-- Columna derecha: formularios --}}
                <div class="col-md-6">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
        
                {{-- Antecedentes --}}
                <h4 class="section-title">Antecedentes Familiares</h4>
                <form method="POST" action="{{ route('doctor.paciente.antecedentes.update', $paciente) }}" class="mb-4">
                    @csrf @method('PUT')
                    <textarea name="texto" class="form-control mb-2" rows="4">{{ old('texto', optional($paciente->antecedentesFamiliares)->texto) }}</textarea>
                    <button class="btn" style="background: var(--verde-claro); color: var(--verde-oscuro);">Guardar Antecedentes</button>
                </form>
        
                {{-- Alergias --}}
                <h4 class="section-title">Alergias</h4>
                <form method="POST" action="{{ route('doctor.paciente.alergias.update', $paciente) }}" class="mb-4">
                    @csrf @method('PUT')
                    <textarea name="descripcion" class="form-control mb-2" rows="3">{{ old('descripcion', optional($paciente->alergias)->descripcion) }}</textarea>
                    <button class="btn" style="background: var(--verde-claro); color: var(--verde-oscuro);">Guardar Alergias</button>
                </form>
        
                {{-- Historial de Cirugías --}}
                <h4 class="section-title">Cirugías</h4>
                <form method="POST" action="{{ route('doctor.paciente.cirugias.store', $paciente) }}" class="mb-4">
                    @csrf
                    <div class="row g-2">
                    <div class="col">
                        <input type="date" name="fecha" class="form-control" required>
                    </div>
                    <div class="col">
                        <input type="text" name="descripcion" class="form-control" placeholder="Descripción" required>
                    </div>
                    <div class="col-auto">
                        <button class="btn" style="background: var(--verde-claro); color: var(--verde-oscuro);">Agregar</button>
                    </div>
                    </div>
                </form>
                <ul class="list-group mb-4">
                    @forelse($paciente->cirugias()->orderBy('fecha','desc')->get() as $cir)
                    <li class="list-group-item d-flex justify-content-between">
                        <span>{{ \Carbon\Carbon::parse($cir->fecha)->format('d/m/Y') }} – {{ $cir->descripcion }}</span>
                        <form method="POST" action="{{ route('doctor.paciente.cirugias.destroy', $cir) }}" onsubmit="return confirm('Eliminar?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">X</button>
                        </form>
                    </li>
                    @empty
                    <li class="list-group-item text-muted">No hay cirugías registradas.</li>
                    @endforelse
                </ul>
        
                {{-- Historial de Hospitalizaciones --}}
                <h4 class="section-title">Hospitalizaciones</h4>
                <form method="POST" action="{{ route('doctor.paciente.hospitalizaciones.store', $paciente) }}" class="mb-4">
                    @csrf
                    <div class="row g-2">
                    <div class="col">
                        <input type="date" name="fecha" class="form-control" required>
                    </div>
                    <div class="col">
                        <input type="text" name="descripcion" class="form-control" placeholder="Descripción" required>
                    </div>
                    <div class="col-auto">
                        <button class="btn" style="background: var(--verde-claro); color: var(--verde-oscuro);">Agregar</button>
                    </div>
                    </div>
                </form>
                <ul class="list-group">
                    @forelse($paciente->hospitalizaciones()->orderBy('fecha','desc')->get() as $h)
                    <li class="list-group-item d-flex justify-content-between">
                        <span>{{ \Carbon\Carbon::parse($h->fecha)->format('d/m/Y') }} – {{ $h->descripcion }}</span>
                        <form method="POST" action="{{ route('doctor.paciente.hospitalizaciones.destroy', $h) }}" onsubmit="return confirm('Eliminar?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">X</button>
                        </form>
                    </li>
                    @empty
                    <li class="list-group-item text-muted">No hay hospitalizaciones registradas.</li>
                    @endforelse
                </ul>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Historial médico de citas --}}
    <h4 class="section-title">Historial de Citas</h4>
    <div class="card mb-4 p-4">
      <form method="GET" action="{{ route('doctor.historial') }}" class="row g-3 align-items-end mb-3">
        <input type="hidden" name="dni" value="{{ $paciente->dni }}">
        <div class="col-md-3">
          <label for="order_by" class="form-label">Ordenar por:</label>
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
    
      @if($citas->isEmpty())
        <div class="alert alert-info">Este paciente no tiene citas registradas.</div>
      @else
        @foreach($citas as $c)
          <div class="card mb-3">
            <div class="card-header" style="background: var(--verde-claro); color: var(--verde-oscuro);">
              Cita con <strong>{{ $c->especialista->nombre }}</strong>
              ({{ $c->area->nombre }}) —
              <strong>{{ \Carbon\Carbon::parse($c->fecha)->format('d/m/Y') }}</strong> a las {{ $c->hora }}
            </div>
            <div class="card-body">
              <p><strong>Diagnóstico:</strong> {{ $c->diagnostico ?? '—' }}</p>
              <p><strong>Notas/Resultados:</strong> {{ $c->notas ?? '—' }}</p>
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
    </div>
    

    <a href="{{ route('doctor.dashboard') }}" class="btn btn-secondary">← Volver al Dashboard</a>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

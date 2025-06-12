<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Detalles de la Cita</title>
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
    .card-admin-header { background: var(--verde-claro); color: white; padding: .75rem 1.25rem; border-top-left-radius: .5rem; border-top-right-radius: .5rem; }
    .cita-img-wrapper { position: relative; display: inline-block; }
    .cita-img { width:120px; height:120px; object-fit:cover; cursor: context-menu; }
    .cita-img-wrapper .badge {
      position: absolute; top: .25rem; right: .25rem;
      cursor: pointer; z-index: 10;
    }
  </style>
</head>
<body>

  <nav class="navbar navbar-light">
    <div class="container">
      <a href="{{ route('doctor.dashboard') }}" class="navbar-brand">Clínica ConfíaSalud</a>
    </div>
  </nav>

  <div class="container py-5">
    <h2 class="mb-4" style="color: var(--verde-oscuro);">Detalles de la Cita</h2>

    {{-- Datos del paciente --}}
    <div class="card-admin mb-4">
      <div class="card-body">
        <h5 class="card-admin-header">Datos del Paciente</h5>
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
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    {{-- Formulario de notas e imágenes --}}
    <form method="POST"
          action="{{ route('doctor.citas.detalles.update', $cita) }}"
          enctype="multipart/form-data">
      @csrf
      @method('PUT')

      {{-- Notas --}}
      <div class="mb-3">
        <label for="notas" class="form-label">Notas/Resultados</label>
        <textarea id="notas"
                  name="notas"
                  class="form-control"
                  rows="4">{{ old('notas', $cita->notas) }}</textarea>
      </div>

      {{-- Subir nuevas imágenes --}}
      <div class="mb-3">
        <label for="nuevasImagenes" class="form-label">Agregar imágenes</label>
        <input type="file"
               id="nuevasImagenes"
               name="nuevasImagenes[]"
               class="form-control"
               accept="image/*"
               multiple>
      </div>

      {{-- Imágenes existentes --}}
      <div class="mb-3">
        <label class="form-label">Imágenes actuales (click derecho para eliminar)</label>
        <div class="d-flex flex-wrap gap-2">
          @foreach($cita->imagenes as $img)
            <div class="cita-img-wrapper">
              <img src="{{ asset('storage/'.$img->path) }}"
                   data-id="{{ $img->id }}"
                   class="cita-img">
              <span class="badge bg-danger d-none">X</span>
            </div>
          @endforeach
        </div>
      </div>

      {{-- Contenedor para inputs ocultos de eliminación --}}
      <div id="eliminar-container"></div>

      <button type="submit"
              class="btn"
              style="background: var(--verde-claro); color: var(--verde-oscuro);">
        Guardar Cambios
      </button>
      <a href="{{ route('doctor.dashboard') }}" class="btn btn-secondary ms-2">← Volver al Dashboard</a>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const container = document.getElementById('eliminar-container');
  
    // Primero, al hacer click derecho mostramos la X
    document.querySelectorAll('.cita-img').forEach(img => {
      img.addEventListener('contextmenu', e => {
        e.preventDefault();
        const wrapper = img.closest('.cita-img-wrapper');
        const badge   = wrapper.querySelector('.badge');
        badge.classList.remove('d-none');
      });
    });
  
    // Luego, al hacer clic en la X, eliminamos la imagen de la vista y creamos el input hidden
    document.querySelectorAll('.cita-img-wrapper .badge').forEach(badge => {
      badge.addEventListener('click', () => {
        const wrapper = badge.closest('.cita-img-wrapper');
        const img     = wrapper.querySelector('.cita-img');
        const id      = img.dataset.id;
  
        // Crear input hidden para eliminación
        const input = document.createElement('input');
        input.type  = 'hidden';
        input.name  = 'eliminar[]';
        input.value = id;
        container.appendChild(input);
  
        // Remover la vista de la imagen
        wrapper.remove();
      });
    });
  </script>
  
  
</body>
</html>

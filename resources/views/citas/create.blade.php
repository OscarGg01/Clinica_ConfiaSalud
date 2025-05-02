<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  {{-- Token CSRF para Axios --}}
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>ClinicaCitas</title>

  {{-- Estilos --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,800" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
</head>

<body>
  {{-- Barra superior --}}
  <div class="superior-bar">
    <div class="container d-flex justify-content-between align-items-center">
      <div>
        <i class="bi bi-telephone-fill"></i> Central Telefónica:
        <a href="tel:064000000" class="text-black">000-000000</a>
        &nbsp;|&nbsp;
        <i class="bi bi-whatsapp"></i>
        <a href="https://wa.me/51923813488" target="_blank" class="text-black">000-000-000</a>
      </div>
      <div>
        <a href="#" class="text-black me-3"><i class="bi bi-facebook fs-4"></i></a>
        <a href="#" class="text-black me-3"><i class="bi bi-twitter fs-4"></i></a>
        <a href="#" class="text-black me-3"><i class="bi bi-instagram fs-4"></i></a>
      </div>
    </div>
  </div>

  {{-- Navbar --}}
  <nav class="navbar navbar-expand-lg navbar-light second-bar">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
        <img class="logo" src="{{ asset('/images/imagen1.png') }}" alt="Logo" height="80" class="me-2">
        <span class="nombre-empresa">Clinica Confía<span class="salud">Salud</span></span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
              aria-controls="navbarNav" aria-expanded="false" aria-label="Alternar navegación">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="{{ route('prueba') }}">Inicio</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('especialidades') }}">Especialidades</a></li>
          <li class="nav-item dropdown">
            <a
              class="nav-link dropdown-toggle"
              href="#"
              id="navbarCitas"
              role="button"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >
              Citas
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarCitas">
              <li>
                <a class="dropdown-item" href="{{ route('citas.create') }}">
                  Agendar cita
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="{{ route('citas.historial.form') }}">
                  Historial de citas
                </a>
              </li>
            </ul>
          </li>          
          <li class="nav-item"><a class="nav-link" href="{{ route('staff') }}">Staff Médico</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('nosotros') }}">Nosotros</a></li>
        </ul>
      </div>
    </div>
  </nav>

  {{-- Contenido principal --}}
  <div class="relleno-citas">
    <div class="titulo-container text-center my-3">
      <h1 class="titulo-citas">AGENDA TU CITA AQUÍ</h1>
      <p class="subtitulo-citas">Complete todos los campos obligatorios (*) para programar su cita</p>
    </div>
    <div class="agendar">
      <div class="container">

        {{-- Datos personales --}}
        <div class="card p-4 mb-4 bg-white">
          <h2 class="mb-4">Datos personales</h2>
          <form id="form-paciente" class="row g-3">
            @csrf

            {{-- DNI dentro del form --}}
            <div class="row align-items-center g-2 mb-4">
              <div class="col-auto">
                <label for="dni" class="form-label mb-0">DNI:</label>
              </div>
              <div class="col">
                <input
                  type="text"
                  id="dni"
                  name="dni"
                  class="form-control"
                  placeholder="Ingrese nro. documento"
                  value="{{ old('dni') }}"
                  required
                >
              </div>
              <div class="col-auto">
                <button type="button" id="btn-buscar" class="btn btn-info">
                  <i class="bi bi-search"></i> Buscar
                </button>
              </div>
            </div>

            {{-- Campos dinámicos --}}
            @php
              $fields = [
                ['apellido_paterno','Apellido paterno','text'],
                ['apellido_materno','Apellido materno','text'],
                ['nombres','Nombres','text'],
                ['fecha_nac','Fecha nacimiento','date'],
                ['sexo','Sexo','select',['','Masculino','Femenino','Otro']],
                ['email','Correo electrónico','email'],
                ['telefono','Teléfono','text'],
                ['whatsapp','Whatsapp','text'],
                ['ubicacion','Ubicación','text'],
              ];
            @endphp

            @foreach($fields as $f)
              @if($f[0] === 'sexo')
                <div class="col-md-6">
                  <label class="form-label">{{ $f[1] }} *</label>
                  <select
                    id="sexo"
                    name="sexo"
                    class="form-select"
                    required
                  >
                    @foreach(['','Masculino','Femenino','Otro'] as $opt)
                      <option
                        value="{{ $opt }}"
                        {{ old('sexo') === $opt ? 'selected' : '' }}
                      >
                        {{ $opt }}
                      </option>
                    @endforeach
                  </select>
                </div>
              @else
                <div class="col-md-6">
                  <label class="form-label">{{ $f[1] }} *</label>
                  @if($f[2] === 'select' && $f[0] !== 'sexo')
                    <select
                      id="{{ $f[0] }}"
                      name="{{ $f[0] }}"
                      class="form-select"
                      required
                    >
                      @foreach($f[3] as $opt)
                        <option
                          value="{{ $opt }}"
                          {{ old($f[0]) === $opt ? 'selected' : '' }}
                        >
                          {{ $opt }}
                        </option>
                      @endforeach
                    </select>
                  @else
                    <input
                      type="{{ $f[2] }}"
                      id="{{ $f[0] }}"
                      name="{{ $f[0] }}"
                      class="form-control"
                      value="{{ old($f[0]) }}"
                      required
                    >
                  @endif
                </div>
              @endif
            @endforeach

            {{-- Botón Registrar Usuario --}}
            <div class="col-md-6 d-flex align-items-end">
              <button type="button" id="btn-registrar-paciente" class="btn btn-primary w-100">
                <i class="bi bi-person-plus-fill"></i> Registrar Usuario
              </button>
            </div>
          </form>
        </div>

        {{-- Agendar cita --}}
        <div class="card p-4 bg-white">
          <h2 class="mb-4">Agendar Cita</h2>
          <form id="form-cita" method="POST" action="{{ route('citas.store') }}">
            @csrf
            <input type="hidden" name="dni" id="h-dni">

            <div class="row g-3">
              <div class="col-md-4">
                <label class="form-label">Área *</label>
                <select name="area_id" id="area_id" class="form-select" required>
                  <option value="">Seleccione...</option>
                  @foreach($areas as $a)
                    <option value="{{ $a->id }}">{{ $a->nombre }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-4">
                <label class="form-label">Especialista *</label>
                <select name="especialista_id" id="especialista_id" class="form-select" required>
                  <option value="">Primero seleccione área</option>
                </select>
              </div>
              <div class="col-md-4">
                <label class="form-label">Fecha *</label>
                <input type="date" name="fecha" id="fecha" class="form-control" required>
              </div>
            </div>

            <div class="row g-3 mt-3">
              <div class="col-md-4">
                <label class="form-label">Hora Disponible *</label>
                <select name="hora" id="hora" class="form-select" required>
                  <option value="">Elige fecha y especialista</option>
                </select>
              </div>
            </div>

            <button class="btn btn-success mt-4">
              <i class="bi bi-calendar-check"></i> Agendar Cita
            </button>
          </form>
        </div>

      </div>
    </div>
  </div>

  {{-- Footer --}}
  <footer class="final bg-dark text-white pt-5">
    <div class="container">
      <div class="row">
        <div class="col-md-4 mb-4">
          <h5 class="titulos-footer">Contáctanos</h5>
          <p>
            Ubicación: <a href="https://maps.app.goo.gl/UzatxvEhkDiczQd96" class="text-white">Av. asd 123, Huancayo</a><br>
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d1340.2719197061174!2d-75.19958571445709!3d-12.047501742928866!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x910e979ec9e0a7c9%3A0xfc772b2952606584!2sUniversidad%20Continental%20-%20Campus%20Huancayo!5e0!3m2!1ses!2spe!4v1745431026091!5m2!1ses!2spe" class="mapa" width="400" height="300" style="border:5px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            <br>
            Tel: <a href="tel:012345678" class="text-white">01-2345678</a><br>
            Email: <a href="mailto:info@confiasalud.com" class="text-white">info@confiasalud.com</a>
          </p>
        </div>
        <div class="col-md-2 mb-4">
          <h5 class="titulos-footer">Enlaces</h5>
          <ul class="list-unstyled">
            <li><a href="{{ route('prueba') }}" class="text-white">Inicio</a></li>
            <li><a href="{{ route('especialidades') }}" class="text-white">Especialidades</a></li>
            <li><a href="{{ route('citas.create') }}" class="text-white">Citas</a></li>
            <li><a href="{{ route('staff') }}" class="text-white">Staff Médico</a></li>
            <li><a href="{{ route('nosotros') }}" class="text-white">Nosotros</a></li>
          </ul>
        </div>
        <div class="col-md-3 mb-4">
          <h5 class="titulos-footer">Horario de atención</h5>
          <p>
            Lun-Vie: 08:00 – 18:00<br>
            Sáb: 09:00 – 14:00<br>
            Dom: Cerrado
          </p>
        </div>
        <div class="col-md-3 mb-4">
          <h5 class="titulos-footer">Síguenos</h5>
          <a href="#" class="text-white me-3"><i class="bi bi-facebook fs-4"></i></a>
          <a href="#" class="text-white me-3"><i class="bi bi-instagram fs-4"></i></a>
          <a href="#" class="text-white"><i class="bi bi-youtube fs-4"></i></a>
        </div>
      </div>
      <hr class="border-secondary">
      <div class="d-flex justify-content-between align-items-center py-3">
        <small>© 2025 Clínica ConfíaSalud. Todos los derechos reservados.</small>
        <a href="#" class="text-white">↑ Volver arriba</a>
      </div>
    </div>
  </footer>

  {{-- Scripts al final --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  {{-- Aquí va tu lógica de citas: btn-buscar, area change, fecha change y form submit --}}
  <script>
    // public/js/citas.js

    // 0) Configura CSRF para Axios (si no está globalmente en tu layout)
    axios.defaults.headers.common['X-CSRF-TOKEN'] =
      document.querySelector('meta[name="csrf-token"]').content;

    // 1) Buscar paciente por DNI
    document.getElementById('btn-buscar').addEventListener('click', () => {
      const dni = document.getElementById('dni').value.trim();
      if (!dni) return alert('¡Ingrese un número de documento!');
      axios.post('/citas/buscar-paciente', { dni })
        .then(({ data }) => {
          if (data) {
            ['apellido_paterno','apellido_materno','nombres','fecha_nac','sexo',
            'email','telefono','whatsapp','ubicacion']
              .forEach(f => document.getElementById(f).value = data[f] || '');
          } else {
            alert('Paciente no encontrado. Complete los datos manualmente.');
          }
        })
        .catch(() => alert('Error al buscar paciente. Complete los datos manualmente.'));
    });

    // 2) Cargar especialistas
    document.getElementById('area_id').addEventListener('change', function() {
      const select = document.getElementById('especialista_id');
      if (!this.value) {
        select.innerHTML = '<option value="">Primero seleccione área</option>';
        return;
      }
      select.innerHTML = '<option>Cargando...</option>';
      axios.post('/citas/especialistas', { area_id: this.value })
        .then(({ data }) => {
          select.innerHTML = '<option value="">Seleccione...</option>';
          data.forEach(e =>
            select.insertAdjacentHTML('beforeend',
              `<option value="${e.id}">${e.nombre}</option>`
            )
          );
        })
        .catch(() => {
          alert('Error al cargar especialistas');
          select.innerHTML = '<option value="">Seleccione...</option>';
        });
    });

    // 3) Generar horas fijas
    function generarSlots() {
      const selectHora = document.getElementById('hora');
      const esp = document.getElementById('especialista_id').value;
      const fecha = document.getElementById('fecha').value;
      if (!esp || !fecha) {
        selectHora.innerHTML = '<option value="">Elige fecha y especialista</option>';
        return;
      }
      const slots = [];
      [[8,14],[16,20]].forEach(([start,end]) => {
        for (let h = start; h < end; h++) {
          slots.push(`${String(h).padStart(2,'0')}:00`);
          slots.push(`${String(h).padStart(2,'0')}:30`);
        }
      });
      const opciones = slots
        .filter(s => {
          const [hh,mm] = s.split(':').map(Number);
          return (hh < 14 || hh >= 16) && !(hh === 20 && mm > 0);
        })
        .map(s => `<option value="${s}">${s}</option>`)
        .join('');
      selectHora.innerHTML = opciones;
    }

    document.getElementById('especialista_id').addEventListener('change', generarSlots);
    document.getElementById('fecha').addEventListener('change', generarSlots);

    // 4) Validar y enviar
    document.getElementById('form-cita').addEventListener('submit', function(e) {
      document.getElementById('h-dni').value =
        document.getElementById('dni').value.trim();

      const reqs = Array.from(document.querySelectorAll('[required]'));
      if (!reqs.every(i => i.value.trim() !== '')) {
        e.preventDefault();
        alert('¡Complete todos los campos obligatorios!');
        (document.querySelector('[required]:invalid') || reqs.find(i=>i.value===''))
          .scrollIntoView({ behavior:'smooth' });
      }
    });

    // Botón Registrar Usuario
    document.getElementById('btn-registrar-paciente').addEventListener('click', async () => {
      const form = document.getElementById('form-paciente');
      const formData = new FormData(form);

      try {
        const res = await axios.post('{{ route("pacientes.store") }}', formData);
        if (res.data.success) {
          alert(res.data.message);
        }
      } catch (err) {
        console.error(err);
        if (err.response && err.response.data.errors) {
          // Mostrar el primer error de validación
          const msgs = Object.values(err.response.data.errors).flat();
          alert('Error: ' + msgs[0]);
        } else {
          alert('Error al registrar paciente.');
        }
      }
    });

  </script>
</body>
</html>

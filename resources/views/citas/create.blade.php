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
            <i class="bi bi-telephone-fill"></i> Central Telefónica: <a href="tel:064-247087" class="text-black">064-247087</a>
            &nbsp;|&nbsp;
            <i class="bi bi-whatsapp"></i> <a href="https://wa.me/51964650418" target="_blank" class="text-black">964 650 418</a>
        </div>
        <div>
            <a href="https://www.facebook.com/clinicaconfiasalud" class="text-black me-3"><i class="bi bi-facebook fs-4"></i></a>
            <a href="https://x.com/C_ConfiaSalud" class="text-black me-3"><i class="bi bi-twitter fs-4"></i></a>
            <a href="https://www.instagram.com/clinicaconfiasalud?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" class="text-black me-3"><i class="bi bi-instagram fs-4"></i></a>
        </div>
    </div>
  </div>
  <nav class="navbar navbar-expand-lg navbar-light second-bar">

    <div class="container">
      {{-- 1. Logo + Nombre de la empresa --}}
      <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
        <img class="logo" src="{{ asset('/images/logo-confia-salud.png') }}" alt="Logo Empresa" height="80" class="me-2">
      </a>

      {{-- 2. Botón toggler para móvil --}}
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Alternar navegación">
        <span class="navbar-toggler-icon"></span>
      </button>
      {{-- 3. Menú colapsable --}}
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('prueba') }}">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('especialidades') }}">Especialidades</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarCitas" role="button" data-bs-toggle="dropdown" aria-expanded="false">Citas</a>
            <ul class="dropdown-menu" aria-labelledby="navbarCitas">
              <li>
                <a class="dropdown-item" href="{{ route('citas.create') }}">Agendar cita</a>
              </li>
              <li>
                <a class="dropdown-item" href="{{ route('citas.historial.form') }}">Historial de citas</a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('staff') }}">Staff Médico</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('nosotros') }}">Nosotros</a>
          </li>
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
                <button type="button" id="btn-buscar" class="btn btn-primary">
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
  <footer class="final" class="bg-dark text-white pt-5">
    <div class="container">

        <div class="row">
    
          <!-- 1. Contacto -->
          <div class="mapa-weas col-md-4 mb-4">
            <h5 class="titulos-footer">Ubícanos</h5>
            <p>
              Ubicación: <a href="https://maps.app.goo.gl/6PNuraD5kBHwZab27" class="avenida">Av. Huancavelica 745, El Tambo, Huancayo, Peru</a>
              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3901.71469231958!2d-75.22186592493856!3d-12.06314088817495!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x910e9640d17f31b3%3A0xa39c4d64ffbd66dc!2zQ2zDrW5pY2EgQ29uZsOtYVNhbHVk!5e0!3m2!1ses!2spe!4v1748238053229!5m2!1ses!2spe" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
              <br>
              Tel: <a href="tel:064-247087" class="text-white">064-247087 </a><br>
              Email: <a href="mailto:info@confiasalud.com" class="text-white">info@confiasalud.com</a>
            </p>
          </div>
    
          <!-- 2. Enlaces rápidos -->
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
    
          <!-- 3. Horarios -->
          <div class="col-md-3 mb-4">
            <h5 class="titulos-footer">Horario de atención</h5>
            <p>
              Lun‑Vie: 08:00 – 18:00<br>
              Sáb: 09:00 – 14:00<br>
              Dom: Cerrado
            </p>
          </div>
    
          <!-- 4. Redes sociales -->
          <div class="col-md-3 mb-4">
            <h5 class="titulos-footer">Síguenos</h5>
            <a href="https://www.facebook.com/clinicaconfiasalud" class="text-white me-3"><i class="bi bi-facebook fs-4"></i></a>
            <a href="https://www.instagram.com/clinicaconfiasalud?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" class="text-white me-3"><i class="bi bi-instagram fs-4"></i></a>
            <a href="https://x.com/C_ConfiaSalud" class="text-white"><i class="bi bi-twitter fs-4"></i></a>
          </div>
    
        </div> <!-- /.row -->
    
        <hr class="border-secondary">
    
        <div class="d-flex justify-content-between align-items-center py-3">
          <!-- Copyright -->
          <small>© 2025 Clínica ConfíaSalud. Todos los derechos reservados.</small>
          <!-- Back to top -->
          <a href="#" class="text-white"> ↑ Volver arriba</a>
        </div>
    
      </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  {{-- Aquí va tu lógica de citas: btn-buscar, area change, fecha change y form submit --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script>
    // 0) Configuración global CSRF para Axios
    axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').content;
  
    // 1) Buscar paciente por DNI
    document.getElementById('btn-buscar').addEventListener('click', () => {
      const dni = document.getElementById('dni').value.trim();
      if (!dni) {
        alert('¡Ingrese un número de documento!');
        return;
      }
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
        .catch(() => {
          alert('Error al buscar paciente. Complete los datos manualmente.');
        });
    });
  
    // 2) Cargar especialistas al cambiar área
    document.getElementById('area_id').addEventListener('change', function() {
      const select = document.getElementById('especialista_id');
      select.innerHTML = this.value
        ? '<option>Cargando...</option>'
        : '<option value="">Primero seleccione área</option>';
      if (!this.value) return;
  
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
  
    // 3) Cargar horarios desde BD al cambiar especialista
    document.getElementById('especialista_id').addEventListener('change', () => {
      const selectHora = document.getElementById('hora');
      const esp = document.getElementById('especialista_id').value;
      selectHora.innerHTML = esp
        ? '<option>Cargando...</option>'
        : '<option value="">Selecciona especialista primero</option>';
      if (!esp) return;
  
      axios.post('/citas/horarios', { especialista_id: esp })
        .then(({ data }) => {
          selectHora.innerHTML = data.length
            ? data.map(h => `<option value="${h}">${h}</option>`).join('')
            : '<option value="">No hay horarios disponibles</option>';
        })
        .catch(() => {
          alert('Error al cargar horarios');
          selectHora.innerHTML = '<option value="">Error al cargar</option>';
        });
    });
  
    // 4) Validación y envío de la cita
    document.getElementById('form-cita').addEventListener('submit', function(e) {
      document.getElementById('h-dni').value =
        document.getElementById('dni').value.trim();
  
      const requireds = Array.from(this.querySelectorAll('[required]'));
      if (!requireds.every(i => i.value.trim() !== '')) {
        e.preventDefault();
        alert('¡Complete todos los campos obligatorios!');
        (this.querySelector('[required]:invalid') || requireds.find(i => i.value===''))
          .scrollIntoView({ behavior:'smooth' });
      }
    });
  
    // 5) Registrar paciente (solo datos personales)
    document.getElementById('btn-registrar-paciente').addEventListener('click', async () => {
      const form = document.getElementById('form-paciente');
      const formData = new FormData(form);
  
      try {
        const res = await axios.post('{{ route("pacientes.store") }}', formData);
        alert(res.data.message);
      } catch (err) {
        if (err.response?.data?.errors) {
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

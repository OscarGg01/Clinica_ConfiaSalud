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

  <div class="relleno_edit">
    <div class="container py-5">
        <h2 class="mb-4">Reprogramar Cita</h2>
      
        {{-- Mostrar posibles errores --}}
        @if ($errors->any())
          <div class="alert alert-danger">
            <ul class="mb-0">
              @foreach ($errors->all() as $err)
                <li>{{ $err }}</li>
              @endforeach
            </ul>
          </div>
        @endif
      
        <form id="form-cita-edit" method="POST" action="{{ route('citas.update', $cita) }}">
          @csrf
          @method('PUT')
      
          {{-- DNI (solo lectura) --}}
          <div class="mb-3">
            <label class="form-label">DNI</label>
            <input type="text" class="form-control" value="{{ $cita->dni }}" readonly>
            <input type="hidden" name="dni" value="{{ $cita->dni }}">
          </div>
      
          {{-- Área --}}
          <div class="mb-3">
            <label class="form-label">Área *</label>
            <select name="area_id" id="area_id" class="form-select" required>
              <option value="">Seleccione...</option>
              @foreach($areas as $a)
                <option 
                  value="{{ $a->id }}" 
                  @if(old('area_id', $cita->area_id) == $a->id) selected @endif
                >{{ $a->nombre }}</option>
              @endforeach
            </select>
          </div>
      
          {{-- Especialista --}}
          <div class="mb-3">
            <label class="form-label">Especialista *</label>
            <select name="especialista_id" id="especialista_id" class="form-select" required>
              <option value="">Primero seleccione área</option>
            </select>
          </div>
      
          {{-- Fecha --}}
          <div class="mb-3">
            <label class="form-label">Fecha *</label>
            <input 
              type="date" 
              name="fecha" 
              id="fecha" 
              class="form-control" 
              required 
              value="{{ old('fecha', $cita->fecha->format('Y-m-d')) }}"
            >
          </div>
      
          {{-- Hora --}}
          <div class="mb-3">
            <label class="form-label">Hora Disponible *</label>
            <select name="hora" id="hora" class="form-select" required>
              <option value="">Elige fecha y especialista</option>
            </select>
          </div>
      
          <button class="btn btn-primary">
            <i class="bi bi-save"></i> Guardar cambios
          </button>
          <a href="{{ route('citas.historial.form') }}" class="btn btn-secondary ms-2">
            Cancelar
          </a>
        </form>
      </div>

        {{-- Reutiliza tu citas.js pero adaptado para precarga --}}
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script>
          axios.defaults.headers.common['X-CSRF-TOKEN'] =
            document.querySelector('meta[name="csrf-token"]').content;
      
          // Función para generar horas fijas
          function generarSlots() {
            const selectHora = document.getElementById('hora');
            const esp       = document.getElementById('especialista_id').value;
            const fecha     = document.getElementById('fecha').value;
            if (!esp || !fecha) {
              selectHora.innerHTML = '<option value="">Elige fecha y especialista</option>';
              return;
            }
            const slots = [];
            [[8,14],[16,20]].forEach(([s,e]) => {
              for (let h=s; h<e; h++) {
                slots.push(`${String(h).padStart(2,'0')}:00`);
                slots.push(`${String(h).padStart(2,'0')}:30`);
              }
            });
            const opciones = slots
              .map(s => `<option value="${s}">${s}</option>`)
              .join('');
            selectHora.innerHTML = opciones;
          }
      
          // Al cambiar área cargamos especialistas
          document.getElementById('area_id').addEventListener('change', function(){
            const areaId = this.value;
            const select = document.getElementById('especialista_id');
            if (!areaId) {
              select.innerHTML = '<option value="">Primero seleccione área</option>';
              return;
            }
            select.innerHTML = '<option>Cargando...</option>';
            axios.post('/citas/especialistas', { area_id: areaId })
              .then(({ data }) => {
                select.innerHTML = '<option value="">Seleccione...</option>';
                data.forEach(e => {
                  select.insertAdjacentHTML('beforeend',
                    `<option value="${e.id}">${e.nombre}</option>`
                  );
                });
                // Preseleccionar el especialista actual
                select.value = "{{ old('especialista_id', $cita->especialista_id) }}";
                // Generar slots y preseleccionar hora
                generarSlots();
                document.getElementById('hora').value = "{{ old('hora', $cita->hora) }}";
              });
          });
      
          // Al cambiar fecha o especialista generamos slots
          document.getElementById('especialista_id').addEventListener('change', generarSlots);
          document.getElementById('fecha').addEventListener('change', generarSlots);
      
          // Al cargar la página disparamos el change de área para precarga
          window.addEventListener('DOMContentLoaded', () => {
            document.getElementById('area_id').dispatchEvent(new Event('change'));
          });
        </script>
  </div>

  <footer class="final" class="bg-dark text-white pt-5">
    <div class="container">
        <div class="row">
    
          <!-- 1. Contacto -->
          <div class="mapa-weas col-md-4 mb-4">
            <h5 class="titulos-footer">Contáctanos</h5>
            <p>
              Ubicación: <a href="https://maps.app.goo.gl/UzatxvEhkDiczQd96" class="avenida">Av. asd 123</a> Huancayo, Perú
              <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d1340.2719197061174!2d-75.19958571445709!3d-12.047501742928866!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x910e979ec9e0a7c9%3A0xfc772b2952606584!2sUniversidad%20Continental%20-%20Campus%20Huancayo!5e0!3m2!1ses!2spe!4v1745431026091!5m2!1ses!2spe" class="mapa" width="400" height="300" style="border:5px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
              
              <br>
              Tel: <a href="tel:012345678" class="text-white">01‑2345678</a><br>
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
            <a href="#" class="text-white me-3"><i class="bi bi-facebook fs-4"></i></a>
            <a href="#" class="text-white me-3"><i class="bi bi-instagram fs-4"></i></a>
            <a href="#" class="text-white"><i class="bi bi-twitter fs-4"></i></a>
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
</body>
</html>
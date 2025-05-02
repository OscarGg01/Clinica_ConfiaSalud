<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>ClinicaCitas</title>
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,800" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
</head>

<body>
    <div class="superior-bar">
        <div class="container d-flex justify-content-between align-items-center">
            <div>
                <i class="bi bi-telephone-fill"></i> Central Telefónica: <a href="tel:064000000" class="text-black">000-000000</a>
                &nbsp;|&nbsp;
                <i class="bi bi-whatsapp"></i> <a href="https://wa.me/51923813488" target="_blank" class="text-black">000-000-000</a>
            </div>
            <div>
                <a href="#" class="text-black me-3"><i class="bi bi-facebook fs-4"></i></a>
                <a href="#" class="text-black me-3"><i class="bi bi-twitter fs-4"></i></a>
                <a href="#" class="text-black me-3"><i class="bi bi-instagram fs-4"></i></a>
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
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                  aria-controls="navbarNav" aria-expanded="false" aria-label="Alternar navegación">
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

    <div class="relleno_lista">
        <div class="container py-5">
            <h2 class="mb-4">Tus próximas citas</h2>
          
            @if($citas->isEmpty())
              <div class="alert alert-info">No tienes citas pendientes.</div>
            @else
              <table class="table">
                <thead>
                  <tr>
                    <th>Especialista</th><th>Área</th><th>Fecha</th><th>Hora</th><th></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($citas as $c)
                    <tr>
                      <td>{{ $c->especialista->nombre }}</td>
                      <td>{{ $c->area->nombre }}</td>
                      <td>{{ \Carbon\Carbon::parse($c->fecha)->format('d/m/Y') }}</td>
                      <td>{{ \Carbon\Carbon::parse($c->hora)->format('H:i') }}</td>
                      <td>
                        <a href="{{ route('citas.edit',$c) }}" class="btn btn-sm btn-warning">
                          Reprogramar
                        </a>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            @endif
        </div>
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
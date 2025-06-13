<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>ClinicaCitas - Historial de citas</title>
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
        <i class="bi bi-telephone-fill"></i> Central Telefónica: 
        <a href="tel:064-247087" class="text-black">064-247087</a>
        &nbsp;|&nbsp;
        <i class="bi bi-whatsapp"></i> 
        <a href="https://wa.me/51964650418" target="_blank" class="text-black">964 650 418</a>
      </div>
      <div>
        <a href="https://www.facebook.com/clinicaconfiasalud" class="text-black me-3">
          <i class="bi bi-facebook fs-4"></i>
        </a>
        <a href="https://x.com/C_ConfiaSalud" class="text-black me-3">
          <i class="bi bi-twitter fs-4"></i>
        </a>
        <a href="https://www.instagram.com/clinicaconfiasalud?igsh=ZDNlZDc0MzIxNw==" class="text-black me-3">
          <i class="bi bi-instagram fs-4"></i>
        </a>
      </div>
    </div>
  </div>

  <nav class="navbar navbar-expand-lg navbar-light second-bar">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
        <img src="{{ asset('/images/logo-confia-salud.png') }}" alt="Logo" height="80" class="me-2">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="{{ route('prueba') }}">Inicio</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('especialidades') }}">Especialidades</a></li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarCitas" data-bs-toggle="dropdown">
              Citas
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarCitas">
              <li><a class="dropdown-item" href="{{ route('citas.create') }}">Agendar cita</a></li>
              <li><a class="dropdown-item" href="{{ route('citas.historial.form') }}">Historial de citas</a></li>
            </ul>
          </li>
          <li class="nav-item"><a class="nav-link" href="{{ route('staff') }}">Staff Médico</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('nosotros') }}">Nosotros</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container-fluid py-5" style="background: #f7faf3;">
    <div class="container">
      <h2 class="text-center mb-4" style="color: #024744; font-weight: 1000;">
        Tu historial de citas
      </h2>
    
      <div class="row">
        {{-- Citas pasadas a la izquierda --}}
        <div class="col-md-6">
          <h4 class="mb-3">Citas pasadas</h4>
    
          @if($citasPas->isEmpty())
            <div class="alert alert-secondary">No tienes citas pasadas.</div>
          @else
            @foreach($citasPas as $c)
              @php $modalId = 'detalleCita'.$c->id; @endphp
    
              <div class="card mb-3">
                <div class="card-header" style="background: #5353ac; color: #ffffff;">
                  {{ \Carbon\Carbon::parse($c->fecha)->format('d/m/Y') }} — {{ $c->hora }}
                </div>
                <div class="card-body d-flex justify-content-between align-items-center">
                  <div>
                    <p class="mb-1"><strong>Especialista:</strong> {{ $c->especialista->nombre }}</p>
                    <p class="mb-0"><strong>Área:</strong> {{ $c->area->nombre }}</p>
                  </div>
                  <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#{{ $modalId }}">
                    Ver detalles
                  </button>
                </div>
              </div>
    
              <!-- Modal de detalles -->
              <div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Detalles de la cita</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                      <p><strong>Diagnóstico:</strong> {{ $c->diagnostico ?? '—' }}</p>
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
                    <div class="modal-footer">
                      <button class="btn btn-outline-primary" disabled>
                        Descargar PDF
                      </button>
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cerrar
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          @endif
        </div>
    
        {{-- Próximas citas a la derecha --}}
        <div class="col-md-6">
          <h4 class="mb-3">Próximas citas</h4>
          @if($citasProx->isEmpty())
            <div class="alert alert-info">No tienes próximas citas.</div>
          @else
            @foreach($citasProx as $c)
              <div class="card mb-3">
                <div class="card-header bg-success text-white">
                  {{ \Carbon\Carbon::parse($c->fecha)->format('d/m/Y') }} — {{ $c->hora }}
                </div>
                <div class="card-body">
                  <p><strong>Especialista:</strong> {{ $c->especialista->nombre }}</p>
                  <p><strong>Área:</strong> {{ $c->area->nombre }}</p>
                  <a href="{{ route('citas.edit', $c) }}" class="btn btn-sm btn-warning">
                    Reprogramar
                  </a>
                </div>
              </div>
            @endforeach
          @endif
        </div>
      </div>
    </div>
  
    <div class="text-center my-4">
      <a href="{{ route('citas.logout') }}" class="btn btn-danger">
        Cerrar sesión
      </a>
    </div>
  </div>
  

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
</body>
</html>
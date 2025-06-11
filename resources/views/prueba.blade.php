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

    <div class="imagen-descripcion d-flex align-items-center">
        <div class="container01 row w-100 align-items-stretch">
            <div class="col-md-6 d-flex flex-column justify-content-center">
                <h1><span class="titulo">Bienvenido a la Clínica ConfíaSalud </span></h1>
                <hr>
                <p>Tu salud es nuestra prioridad. Ofrecemos atención médica de calidad y un equipo de especialistas listos para ayudarte.</p>
            </div>
            <div class="col-md-6 p-0">
                <img src="{{ asset('/images/recepción.png') }}" class="img-fluid h-100 w-100 object-fit-cover" alt="Imagen Clínica">
            </div>
        </div>
    </div>

    <div class="relleno" style="background-color: #b5a2a8; border-bottom-left-radius: 1rem; border-bottom-right-radius: 1rem;">

      <div class="container">
        <h2 class="text-center mb-4" style="color: #024744; font-weight: 700;">¿Quiénes somos?
        </h2>
        <p class="text-center" style="color: #024744; font-size: 1.05rem;">
                En ConfíaSalud, somos una clínica comprometida con tu bienestar. Nuestro equipo de profesionales está dedicado a brindarte atención médica integral y de calidad, utilizando tecnología avanzada y un enfoque humano.
        </p>
      </div>
      <div class="container py-5">
        <h2 class="text-center mb-4" style="color: #024744; font-weight: 1000;">
          Nuestra Esencia
        </h2>
        <div class="row g-4">
          
          <!-- Misión -->
          <div class="col-md-6">
            <div class="card h-100 shadow-sm" style="border: none; border-radius: 1rem;">
              <div class="card-body p-4" style="background: #024744; border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
                <div class="d-flex align-items-center mb-3">
                  <i class="bi bi-bullseye fs-1 text-white me-3"></i>
                  <h3 class="card-title mb-0 text-white">Misión</h3>
                </div>
              </div>
              <div class="card-body p-4" style="background: #fde6c4; border-bottom-left-radius: 1rem; border-bottom-right-radius: 1rem;">
                <p class="card-text" style="color: #024744; font-size: 1.05rem;">
                  Brindar servicios integrales de salud digital con altos estándares de calidad, facilitando 
                  el acceso a atención médica, asesoría preventiva y gestión de citas a través de herramientas 
                  tecnológicas innovadoras. Confiasalud busca empoderar al paciente mediante el uso eficiente 
                  de la información y la atención oportuna, promoviendo el bienestar individual y colectivo.
                </p>
              </div>
            </div>
          </div>
    
          <!-- Visión -->
          <div class="col-md-6">
            <div class="card h-100 shadow-sm" style="border: none; border-radius: 1rem;">
              <div class="card-body p-4" style="background: #024744; border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
                <div class="d-flex align-items-center mb-3">
                  <i class="bi bi-binoculars fs-1 text-white me-3"></i>
                  <h3 class="card-title mb-0 text-white">Visión</h3>
                </div>
              </div>
              <div class="card-body p-4" style="background: #fde6c4; border-bottom-left-radius: 1rem; border-bottom-right-radius: 1rem;">
                <p class="card-text" style="color: #024744; font-size: 1.05rem;">
                  Ser la plataforma líder en salud digital en el Perú y América Latina, reconocida por su 
                  compromiso con la innovación, la calidad de atención, la equidad en el acceso y la transformación 
                  del sistema sanitario mediante tecnologías de la información.
                </p>
              </div>
            </div>
          </div>
    
        </div>
      </div>
    </div>
    
    <section id="contacto" class="py-5" style="background-color: #b5a2a8; border-top-left-radius: 1rem; border-top-right-radius: 1rem; margin-top: 0.5rem;">
      <div class="container">
        <h2 class="text-center mb-4" style="color: #024744; font-weight: 700;">
          Contáctanos
        </h2>
    
        <div class="row g-4">
          {{-- IZQUIERDA: Formulario de contacto --}}
          <div class="col-md-6">
            <div class="card shadow-sm" style="border-radius: 1rem; background-color: #024744;">
              <div class="card-body text-white p-4">
                @if(session('success'))
                  <div class="alert alert-light">
                    {{ session('success') }}
                  </div>
                @endif
    
                @if($errors->any())
                  <div class="alert alert-warning">
                    <ul class="mb-0">
                      @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                      @endforeach
                    </ul>
                  </div>
                @endif
    
                <form method="POST" action="{{ route('contacto.enviar') }}">
                  @csrf
    
                  <div class="mb-3">
                    <label for="nombre" class="form-label text-white">Nombre *</label>
                    <input type="text" id="nombre" name="nombre"
                           class="form-control" value="{{ old('nombre') }}" required>
                  </div>
    
                  <div class="mb-3">
                    <label for="email_contacto" class="form-label text-white">Correo electrónico *</label>
                    <input type="email" id="email_contacto" name="email"
                           class="form-control" value="{{ old('email') }}" required>
                  </div>
    
                  <div class="mb-3">
                    <label for="asunto" class="form-label text-white">Asunto *</label>
                    <input type="text" id="asunto" name="asunto"
                           class="form-control" value="{{ old('asunto') }}" required>
                  </div>
    
                  <div class="mb-3">
                    <label for="mensaje" class="form-label text-white">Mensaje *</label>
                    <textarea id="mensaje" name="mensaje"
                              class="form-control" rows="4" required>{{ old('mensaje') }}</textarea>
                  </div>
    
                  <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="privacy" name="privacy"
                           {{ old('privacy') ? 'checked' : '' }} required>
                    <label class="form-check-label text-white" for="privacy">
                      Acepto la
                      <a href="{{ route('politica.privacidad') }}" class="text-white text-decoration-underline" target="_blank">
                        política de privacidad
                      </a>.
                    </label>
                  </div>
    
                  <button type="submit" class="btn btn-light">
                    Enviar Consulta
                  </button>
                </form>
              </div>
            </div>
          </div>
    
          {{-- DERECHA: WhatsApp + Chat --}}
          <div class="col-md-6">
            {{-- WhatsApp --}}
            <div class="card shadow-sm mb-3" style="border-radius: 1rem; background-color: #024744;">
              <div class="card-body text-white p-4">
                <form onsubmit="enviarWhatsApp(event)">
                  <div class="mb-3">
                      <label for="userName" class="form-label">Tu nombre</label>
                      <input type="text" id="userName" class="form-control" placeholder="Ej. Juan Pérez" required>
                  </div>
                  <div class="mb-3">
                      <label for="userMessage" class="form-label">Mensaje</label>
                      <textarea id="userMessage" class="form-control" rows="3" placeholder="Escribe tu mensaje..." required></textarea>
                  </div>
                  <button type="submit" class="btn btn-success">
                      <i class="bi bi-whatsapp me-1"></i> Enviar por WhatsApp
                  </button>
              </form>
              </div>
            </div>
    
            {{-- Chat disponible 24/7 --}}
            <div class="p-4 text-center" style="background: #024744; border-radius: .5rem;">
              <i class="bi bi-chat-dots fs-1 mb-2" style="color: #fde6c4;"></i>
              <p style="color: #fde6c4">Chat en línea disponible 24/7</p>
              {{-- Aquí puedes incrustar tu widget de chat --}}
            </div>

            <script>
              function enviarWhatsApp(event) {
                  event.preventDefault();
                  const businessPhone = "51923813488";
            
                  // Tomar datos del formulario
                  const userName = document.getElementById("userName").value.trim();
                  const userMessage = document.getElementById("userMessage").value.trim();
                  const texto = `Hola, soy ${userName}, y escribo por que ${userMessage}`;
                  const urlWhatsApp = `https://api.whatsapp.com/send?phone=${businessPhone}&text=${encodeURIComponent(texto)}`;
                  window.open(urlWhatsApp, "_blank");
              }
            </script>
          </div>
        </div>
      </div>
    </section>


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

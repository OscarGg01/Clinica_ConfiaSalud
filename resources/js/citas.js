// public/js/citas.js

// 0) Configura CSRF para Axios
axios.defaults.headers.common['X-CSRF-TOKEN'] =
  document.querySelector('meta[name="csrf-token"]').content;

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
    .catch(error => {
      console.error('Error al buscar paciente:', error);
      alert('Error al buscar paciente');
    });
});

// 2) Cargar especialistas según área
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
    .catch(error => {
      console.error('Error al cargar especialistas:', error);
      alert('Error al cargar especialistas');
      select.innerHTML = '<option value="">Seleccione...</option>';
    });
});

// 3) Generar horas fijas en slots
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

// 4) Validar, copiar datos de paciente y enviar
document.getElementById('form-cita').addEventListener('submit', function(e) {
  // Campos de paciente a copiar
  const camposPaciente = [
    'dni','apellido_paterno','apellido_materno','nombres',
    'fecha_nac','sexo','email','telefono','whatsapp','ubicacion'
  ];

  // 4.1) Copiar cada campo al hidden correspondiente
  camposPaciente.forEach(field => {
    const val = document.getElementById(field).value.trim();
    const hidden = document.getElementById('h-' + field);
    if (hidden) hidden.value = val;
  });

  // 4.2) Validar todos los campos required dentro del form
  const requeridos = Array.from(this.querySelectorAll('[required]'));
  const faltantes = requeridos.filter(input => input.value.trim() === '');
  if (faltantes.length) {
    e.preventDefault();
    alert('¡Complete todos los campos obligatorios!');
    faltantes[0].scrollIntoView({ behavior: 'smooth' });
  }
});

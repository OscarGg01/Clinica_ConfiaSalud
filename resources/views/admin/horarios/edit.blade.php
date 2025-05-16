@extends('admin.layout')

@section('content')
<div class="container">
  <h1 class="mb-4">Editar Horario: {{ \Carbon\Carbon::parse($horario->hora)->format('H:i') }}</h1>

  @if($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach($errors->all() as $err)
          <li>{{ $err }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="card card-admin mb-4">
    <div class="card-admin-header">Actualizar Horario</div>
    <div class="card-body">
      <form action="{{ route('horarios.update', $horario) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
          <label for="especialista_id" class="form-label">Especialista *</label>
          <select id="especialista_id" 
                  name="especialista_id" 
                  class="form-select" 
                  required>
            <option value="">Seleccione...</option>
            @foreach($especialistas as $e)
              <option
                value="{{ $e->id }}"
                {{ old('especialista_id', $horario->especialista_id) == $e->id ? 'selected' : '' }}>
                {{ $e->nombre }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="mb-3">
          <label for="hora" class="form-label">Hora (HH:MM) *</label>
          <input type="time"
                 id="hora"
                 name="hora"
                 class="form-control"
                 value="{{ old('hora', \Carbon\Carbon::parse($horario->hora)->format('H:i')) }}"
                 required>
        </div>

        <button type="submit"
                class="btn"
                style="background: var(--verde-oscuro); color: var(--crema);">
          Guardar Cambios
        </button>
        <a href="{{ route('horarios.index') }}" class="btn btn-secondary ms-2">Cancelar</a>
      </form>
    </div>
  </div>
</div>
@endsection

@extends('admin.layout')

@section('content')
<div class="container">
  <h1 class="mb-4">Editar Especialista: {{ $especialista->nombre }}</h1>

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
    <div class="card-admin-header">Actualizar Datos</div>
    <div class="card-body">
      <form action="{{ route('especialistas.update', $especialista) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
          <label for="nombre" class="form-label">Nombre *</label>
          <input 
            type="text" 
            id="nombre" 
            name="nombre" 
            class="form-control" 
            value="{{ old('nombre', $especialista->nombre) }}" 
            required>
        </div>

        <div class="mb-3">
          <label for="area_id" class="form-label">Área *</label>
          <select 
            id="area_id" 
            name="area_id" 
            class="form-select" 
            required>
            <option value="">Seleccione...</option>
            @foreach($areas as $a)
              <option 
                value="{{ $a->id }}" 
                {{ old('area_id', $especialista->area_id) == $a->id ? 'selected' : '' }}>
                {{ $a->nombre }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email"
                 id="email"
                 name="email"
                 class="form-control"
                 value="{{ old('email', $especialista->email) }}">
        </div>
      
        <div class="mb-3">
          <label for="telefono" class="form-label">Teléfono</label>
          <input type="text" id="telefono" name="telefono" class="form-control" value="{{ old('telefono') }}" pattern="\d{9}" title="Ingresa un número telefónico válido">
        </div>

        <button 
          type="submit" 
          class="btn" 
          style="background: var(--verde-oscuro); color: var(--crema);">
          Guardar Cambios
        </button>
        <a href="{{ route('especialistas.index') }}" class="btn btn-secondary ms-2">Cancelar</a>
      </form>
    </div>
  </div>
</div>
@endsection

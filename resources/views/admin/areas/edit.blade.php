@extends('admin.layout')

@section('content')
<div class="container">
  <h1 class="mb-4">Editar Área: {{ $area->nombre }}</h1>

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
      <form action="{{ route('areas.update', $area) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
          <label for="nombre" class="form-label">Nombre *</label>
          <input type="text"
                 id="nombre"
                 name="nombre"
                 class="form-control"
                 value="{{ old('nombre', $area->nombre) }}"
                 required>
        </div>
        <button type="submit" class="btn" style="background: var(--verde-oscuro); color: #fde6c4;">
          Guardar Cambios
        </button>
        <a href="{{ route('areas.index') }}" class="btn btn-secondary ms-2">Cancelar</a>
      </form>
    </div>
  </div>
</div>
@endsection

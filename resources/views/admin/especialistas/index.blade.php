@extends('admin.layout')

@section('content')
<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="m-0">Especialistas</h1>
    <a href="{{ route('especialistas.create') }}" class="btn btn-light" style="background: var(--verde-claro); color: var(--verde-oscuro);">
      + Nuevo Especialista
    </a>
  </div>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <table class="table table-hover card-admin">
    <thead class="table-light">
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Área</th>
        <th width="180">Acciones</th>
      </tr>
    </thead>
    <tbody>
      @forelse($list as $e)
        <tr>
          <td>{{ $e->id }}</td>
          <td>{{ $e->nombre }}</td>
          <td>{{ $e->area->nombre }}</td>
          <td>{{ $e->email }}</td>
          <td>{{ $e->telefono }}</td>
          <td>
            <a href="{{ route('especialistas.edit', $e) }}" class="btn btn-sm" style="background: var(--verde-claro); color: var(--verde-oscuro);">
              Editar
            </a>
            <form action="{{ route('especialistas.destroy', $e) }}" method="POST" class="d-inline">
              @csrf @method('DELETE')
              <button 
                type="submit" 
                class="btn btn-sm btn-danger"
                onclick="return confirm('¿Eliminar especialista {{ $e->nombre }}?')">
                Eliminar
              </button>
            </form>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="6" class="text-center">No hay especialistas registrados.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection

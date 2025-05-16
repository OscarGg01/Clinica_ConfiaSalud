@extends('admin.layout')

@section('content')
<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="m-0">Áreas de Especialidad</h1>
    <a href="{{ route('areas.create') }}" class="btn btn-light" style="background: var(--verde-claro); color: #024744;">
      + Nueva Área
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
        <th width="180">Acciones</th>
      </tr>
    </thead>
    <tbody>
      @forelse($list as $area)
        <tr>
          <td>{{ $area->id }}</td>
          <td>{{ $area->nombre }}</td>
          <td>
            <a href="{{ route('areas.edit', $area) }}" class="btn btn-sm" style="background: var(--verde-claro); color: #024744;">
              Editar
            </a>
            <form action="{{ route('areas.destroy', $area) }}" method="POST" class="d-inline">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn-sm btn-danger" 
                      onclick="return confirm('¿Eliminar área {{ $area->nombre }}?')">
                Eliminar
              </button>
            </form>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="3" class="text-center">No hay áreas registradas.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection

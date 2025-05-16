@extends('admin.layout')

@section('content')
<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="m-0">Horarios de Especialistas</h1>
    <a href="{{ route('horarios.create') }}" 
       class="btn btn-light" 
       style="background: var(--verde-claro); color: var(--verde-oscuro);">
      + Nuevo Horario
    </a>
  </div>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <table class="table table-hover card-admin">
    <thead class="table-light">
      <tr>
        <th>ID</th>
        <th>Especialista</th>
        <th>Hora</th>
        <th width="180">Acciones</th>
      </tr>
    </thead>
    <tbody>
      @forelse($list as $h)
        <tr>
          <td>{{ $h->id }}</td>
          <td>{{ $h->especialista->nombre }}</td>
          <td>{{ \Carbon\Carbon::parse($h->hora)->format('H:i') }}</td>
          <td>
            <a href="{{ route('horarios.edit', $h) }}" 
               class="btn btn-sm" 
               style="background: var(--verde-claro); color: var(--verde-oscuro);">
              Editar
            </a>
            <form action="{{ route('horarios.destroy', $h) }}" method="POST" class="d-inline">
              @csrf @method('DELETE')
              <button type="submit" 
                      class="btn btn-sm btn-danger"
                      onclick="return confirm('¿Eliminar horario {{ $h->hora }}?')">
                Eliminar
              </button>
            </form>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="4" class="text-center">No hay horarios registrados.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
@endsection
